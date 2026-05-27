<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recibo Encomenda #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { margin-bottom: 20px; }
        .items { margin-top: 20px; width: 100%; border-collapse: collapse; }
        .items th, .items td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2 class="header">Recibo - Encomenda #{{ $order->id }}</h2>

    <p><strong>Cliente:</strong> {{ $order->member->name ?? 'N/A' }}</p>
    <p><strong>Data:</strong> {{ $order->date }}</p>
    <p><strong>Total:</strong> {{ $order->total }}€</p>

    <table class="items">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}€</td>
                    <td>{{ number_format($item->subtotal, 2) }}€</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
