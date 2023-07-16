<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use App\Mail\RegisterMail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $to;
    protected $data;
    protected $type;
    
    public function __construct($to, $type, $data)
    {
        $this->to = $to;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'orderSummary' || $this->type == 'orderCancel'){
            Mail::to($this->to)->send(new OrderMail($this->data, $this->type));
        }elseif($this->type == 'register'){
            Mail::to($this->to)->send(new RegisterMail($this->data, $this->type));
        }
    }
}
