<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $type)
    {
        $this->orderDetail = $order;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == 'orderSummary'){
            return $this->from('order@story.com','OrderStory')
                    ->view('mail.order_summary')
                    ->subject('Order Summary for transaction #'. $this->orderDetail->transaction_no)
                    ->with([
                        'transaction_no' => $this->orderDetail->transaction_no,
                        'created_at' => $this->orderDetail->created_at,
                        'name_product' => $this->orderDetail->product->name_product,
                        'total_price' => $this->orderDetail->total_price
                    ]);
        }elseif($this->type == 'orderCancel'){
            return $this->from('order@story.com','OrderStory')
                    ->view('mail.order_cancel')
                    ->subject('Order Cancel for transaction #'. $this->orderDetail->transaction_no)
                    ->with([
                        'transaction_no' => $this->orderDetail->transaction_no,
                        'created_at' => $this->orderDetail->created_at,
                        'name_product' => $this->orderDetail->product->name_product,
                        'total_price' => $this->orderDetail->total_price
                    ]);
        }
    }
}
