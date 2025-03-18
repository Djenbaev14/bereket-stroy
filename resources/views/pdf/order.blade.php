<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ #{{ $order->id }}</title>
    <style>
        /* body { font-family: Arial, sans-serif; margin: 20px; } */
        h1 { text-align: center; }
        .section { margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .section-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
        .info { font-size: 16px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        /* { font-family: "DejaVu Sans", sans-serif; margin: 20px;} */
    </style>
</head>
<body style="font-family: 'DejaVu Sans', sans-serif;">

    <h1>Заказ #{{ $order->id }}</h1>

    <!-- Информация о клиенте -->
    <div class="section">
        <div class="section-title">Информация о клиенте</div>
        <p class="info"><strong>ФИО:</strong> {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
        <p class="info"><strong>Тел номер:</strong> {{ $order->customer->phone }}</p>
    </div>

    <!-- Информация о продаже -->
    <div class="section">
        <div class="section-title">Информация о продаже</div>
        <p class="info"><strong>Заказ ID:</strong> {{ $order->id }}</p>
        <p class="info"><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
        <p class="info"><strong>Общая сумма:</strong> {{ number_format($order->total_amount, 2, '.', ' ') }} сум</p>
        <p class="info"><strong>Статус оплаты:</strong> 
            <span style="padding:3px 5px;border-radius:5px;color:#fff;background: {{ $order->payment_status_id == 1 || $order->payment_status_id == 5 ? 'rgb(209, 26, 29)' : '#22bb33' }};">
                {{ $order->payment_status->name }}
            </span>
        </p>
        <p class="info"><strong>Статус:</strong> 
            <span style="padding:3px 5px;border-radius:5px;color:#fff;background: {{ $order->order_status_id == 1 || $order->order_status_id == 1 ? 'rgb(209, 26, 29)' : '#22bb33' }};">
                {{ $order->status->name }}
            </span>
        </p>
    </div>

    <!-- Таблица товаров -->
    <div class="section">
        <div class="section-title">Товары в заказе</div>
        <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Кол</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2, '.', ' ') }} сум</td>
                        <td>{{ number_format($item->price * $item->quantity, 2, '.', ' ') }} сум</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
