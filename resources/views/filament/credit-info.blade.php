<div id="printArea" style="font-size:16px">
    <h2 style="font-weight: bold">{{ $product->name }}</h2>

    <p><b>Цена товара:</b> {{ number_format($price, 0, '.', ' ') }} сум</p>

    <hr>

    <table style="width:100%; border-collapse: collapse" border="1">
        <tr>
            <th>Срок</th>
            <th>Ежемесячная оплата</th>
        </tr>
        <tr>
            <td>3 месяца (+15%)</td>
            <td>{{ $m3 }} сум</td>
        </tr>
        <tr>
            <td>6 месяцев (+25%)</td>
            <td>{{ $m6 }} сум</td>
        </tr>
        <tr>
            <td>9 месяцев (+32%)</td>
            <td>{{ $m9 }} сум</td>
        </tr>
        <tr>
            <td>12 месяцев (+38%)</td>
            <td>{{ $m12 }} сум</td>
        </tr>
        <tr>
            <td>18 месяцев (+57%)</td>
            <td>{{ $m18 }} сум</td>
        </tr>
        <tr>
            <td>24 месяцев (+76%)</td>
            <td>{{ $m24 }} сум</td>
        </tr>
    </table>
</div>

<button onclick="printDiv()" 
    style="margin-top: 15px; padding: 10px 20px; background:#2563eb; color:#fff; border-radius:8px">
    🖨 Распечатать
</button>

<script>
    function printCredit() {
        const content = document.getElementById("creditPrint").innerHTML;
        const printWindow = window.open("", "_blank", "width=800,height=900");

        printWindow.document.open();
        printWindow.document.write(`
            <html>
                <head>
                    <title>Печать</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
                        h2 { margin-bottom: 10px; }
                    </style>
                </head>
                <body>
                    ${content}
                    <script>
                        window.onload = function () {
                            window.print();
                        };
                    <\/script>
                </body>
            </html>
        `);
        printWindow.document.close();
    }
</script>
