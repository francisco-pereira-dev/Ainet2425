<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    /**
     * Constrói a mensagem.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Define o envelope e o corpo do email.
     */
    public function build()
    {
        return $this
            ->subject("Recibo de Encomenda #{$this->order->id}")
            ->markdown('emails.receipt') // ou ->markdown('emails.receipt') se usares Markdown
            ->with(['order' => $this->order]);
    }
}
