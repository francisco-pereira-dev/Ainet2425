<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $filename;

    public function __construct(Order $order, string $filename)
    {
        $this->order = $order;
        $this->filename = $filename;
    }

    public function build()
    {
        return $this->subject('Encomenda Concluída - Fatura')
                    ->markdown('emails.receipt')
                    ->attach(storage_path("\app\private/{$this->filename}"))
                    ->with(['order' => $this->order]);
    }
}
