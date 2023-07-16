<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

class OrderExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $order = Order::with(['product','user'])->where('user_id', '=', Auth::User()->id)->get();
        $collect = [];
        foreach($order as $val){
            $data = [
                'transaction_no' => $val->transaction_no,
                'name_product'  => $val->product->name_product,
                'qty'           => $val->qty,
                'unit_price'    => $val->unit_price,
                'total_price'   => $val->total_price,
                'status'        => $val->status == 1 ? 'CANCEL' : ($val->paid == 1 ? 'PAID' : 'NOT PAID'),
                //'created_at'    => $val->created_at,

            ];

            array_push($collect, $data);
        }
        return collect($collect);
    }

    function headings(): array
    {
        return [
            'Transaction No',
            'Name Product',
            'Quantity',
            'Unit Price',
            'Total Price',
            'Status'
        ];
    }
}
