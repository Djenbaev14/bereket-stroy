<!DOCTYPE html>
<html lang="uz">
<head>
<meta charset="UTF-8">
<title>Responsive Sticker</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f2f2f2;
        padding: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .sticker {
        background: linear-gradient(135deg, #f4dd2c, #f2c94c);
        padding: 25px;
        border-radius: 15px;
        color: #000;
        width: 380px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .title {
        font-size: 20px;
        font-weight: bold;
        line-height: 1.2;
    }


    .price-section {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .big-price {
        font-size: 36px;
        font-weight: bold;
    }

    .gray {
        font-size: 14px;
        color: #333;
    }

    .table {
        font-size: 14px;
        margin-top: 10px;
        border-top: 1px solid rgba(0,0,0,0.2);
    }

    .table div {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }

    .benefit {
        font-size: 18px;
        font-weight: bold;
        text-align: right;
        color: #000;
    }

    .benefit small {
        font-size: 12px;
        display: block;
    }

    @media (max-width: 420px) {
        .sticker {
            width: 90%;
            padding: 20px;
        }
        .big-price {
            font-size: 28px;
        }
        .title {
            font-size: 16px;
        }
        .benefit {
            font-size: 16px;
        }
    }
</style>
</head>
<body>

<div class="sticker">

    <div class="title">{{ $product->name }}</div>

    <div class="price-section">
        <div class="gray">12 ойга</div>
        <div class="big-price">{{$m12}} <span class="gray" style="font-weight: normal">сўмдан бошланади</span></div>
    </div>

    <div class="table">
        <div><span>Маҳсулот нархи</span> <span>{{ number_format($old_price, 0, '.', ' ') }} сўмдан</span></div>
        <div><span>Promo нархи</span> <span>{{ number_format($price, 0, '.', ' ') }} сўмдан</span></div>
        <div><span>24 ойга</span> <span>{{ $m24 }} сўмдан</span></div>
        <div><span>18 ойга</span> <span>{{ $m18 }} сўмдан</span></div>
        <div><span>9 ойга</span> <span>{{ $m9 }} сўмдан</span></div>
        <div><span>6 ойга</span> <span>{{ $m6 }} сўмдан</span></div>
        <div><span>3 ойга</span> <span>{{ $m3 }} сўмдан</span></div>
    </div>

    <div style="
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid rgba(0,0,0,0.2);
    ">

        <!-- QR CODE -->
        <img src="/mnt/data/d3c517b7-e9ed-4101-ae01-4ae00c78db2f.png"
            style="width:90px; height:auto; border-radius:8px;">

        <!-- BENEFIT (MIJOZGA FOYDA) -->
        <div style="text-align:right; font-weight:bold; color:#000;">
            {{ number_format($benefit, 0, '.', ' ') }}
            <div style="font-size:12px; font-weight:normal; margin-top:2px;">
                Мижозга фойда
            </div>
        </div>

    </div>

    <!-- FOOTER (ID va sana) -->
    <div style="font-size:12px; margin-top:10px; opacity:0.8;">
        {{-- ID: {{ $product->id }} <br> --}}
        {{ date('Y-m-d') }}
    </div>

</div>

    <button onclick="printDiv()" 
        style="margin-top: 15px; padding: 10px 20px; background:#fff; color:#333; border-radius:8px;border:1px solid #333;">
        🖨 Распечатать
    </button>
</body>

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
</html>
