@component('mail::message')
# Recibo da Encomenda #{{ $order->id }}

Obrigado pela sua encomenda. Detalhes:
- **Data:** {{ $order->created_at->toDateString() }}
- **Total:** €{{ number_format($order->total,2) }}

@component('mail::table')
| Produto     | Qtd | Unit\| Subtotal |
| ----------- |:---:| ----:| ---------:|
@foreach($order->items as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | €{{ number_format($item->unit_price,2) }} | €{{ number_format($item->unit_price * $item->quantity - ($item->discount * $item->quantity),2) }} |
@endforeach
@endcomponent

Custos de envio: €{{ number_format($order->shipping_cost,2) }}

Atenciosamente,  
Grocery Club
@endcomponent
