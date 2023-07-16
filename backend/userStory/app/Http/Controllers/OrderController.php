<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\OrderRequest;
use App\Mail\OrderMail;
use App\Exports\OrderExport;
use App\Jobs\SendEmail;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use App;
use Response;

class OrderController extends Controller
{
    function show()
    {
        $order = Order::with(['product','user'])->where('user_id', '=', Auth::User()->id)->orderBy('created_at','DESC')->paginate(5);

        return view('order.show', ["order" => $order]);
    }

    function buyProduct($id)
    {
        $product = Product::find($id);

        return view('product.buy', ["product" => $product]);
    }

    function buyPerformProduct(OrderRequest $request)
    {
        $product = Product::find($request->product_id);
        $user = Auth::User();
        
        $validated = [
            'transaction_no' => sprintf("%s-%s%s", "ORDER", Str::upper(Str::random(4)), time()),
            'product_id' => $product->id,
            'user_id' => $user->id,
            'qty' => $request->qty,
            'total_price' => $product->price_product * $request->qty,
            'unit_price' => $product->price_product
        ];
        
        $order = Order::create($validated);
        if (!$order){
            return back()->with('error', 'Order failed!');
        }
        
        return back()->with('success', 'Order added, see menu my orders to paid or cancel!');
    }

    function payPerformProduct($id)
    {
        if ($id){
            $order = Order::with(['product','user'])->find($id);
            $order->paid = 1;
            if ($order->save()){
                $this->sendMailSummary($order,'orderSummary');
                return back()->with('success', 'Pay success!');
            }else{
                return back()->with('error', 'Pay failed!');
            }
        }else{
            return back()->with('error', 'Pay failed!');
        }
    }

    function cancelPerformProduct($id)
    {
        if ($id){
            $order = Order::with(['product','user'])->find($id);
            $order->status = 1;
            if ($order->save()){
                $this->sendMailSummary($order,'orderCancel');
                return back()->with('success', 'Cancel success!');    
            }else{
                return back()->with('error', 'Cancel failed!');
            }
        }else{
            return back()->with('error', 'Cancel failed!');
        }
    }

    function exportOrder2File($type)
    {
        if ($type == "csv"){
            $delimiter = ",";
            $order = Order::with(['product','user'])->where('user_id', '=', Auth::User()->id)->get();

            $data = sprintf("%s,%s,%s,%s,%s,%s,%s\n", "Transaction No", "Name Product", "Quantity", "Unit Price", "Total Price", "Status", "Created");
            foreach($order as $val){
                $data .= sprintf("%s,%s,%s,%s,%s,%s,%s\n", $val->transaction_no, $val->product->name_product, $val->qty, $val->unit_price, $val->total_price, $val->status == 1 ? 'CANCEL' : ($val->paid == 1 ? 'PAID' : 'NOT PAID'), $val->created_at);
            }

            $pathName = "public/file/".time().".csv";

            $contents = $data;
            $filename = time(). '.csv';
            return response()->streamDownload(function () use ($contents) {
                echo $contents;
            }, $filename);

            return back()->with('error', 'Download failed, try again!');
        }elseif($type == "xls"){
            return Excel::download(new OrderExport, time().'.xlsx');
        }

    }

    function sendMailSummary($order, $type)
    {
        dispatch(new SendEmail(Auth::User()->email, $type, $order));
    }


}
