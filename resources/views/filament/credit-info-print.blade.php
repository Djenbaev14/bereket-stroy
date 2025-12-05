<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <title>Печать - {{ $product->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
            width: 210mm;
            min-height: 297mm;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Sticker o'lchovlari A4 ga moslashtirildi */
        .sticker {
            background: linear-gradient(135deg, #f4dd2c, #f2c94c);
            padding: 40px 60px;
            /* Padding kamaytirildi */
            color: #000;
            width: 190mm;
            min-height: 270mm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 25px;
            /* Bo'shliq kamaytirildi */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 0;
        }

        /* Shrift hajmlari kamaytirildi */
        .title {
            font-size: 40px;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .price-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 15px;
        }

        .price-label {
            font-size: 28px;
            color: #333;
            font-weight: 500;
        }

        .big-price {
            font-size: 70px;
            font-weight: bold;
            line-height: 1.1;
        }

        .big-price-sub {
            font-size: 28px;
            font-weight: normal;
            color: #333;
        }

        .table {
            font-size: 24px;
            margin-top: 15px;
            border-top: 3px solid rgba(0, 0, 0, 0.3);
            padding-top: 15px;
        }

        .table-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 2px solid rgba(0, 0, 0, 0.15);
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .table-row strong {
            font-weight: bold;
        }

        .profit-section {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-top: 15px;
            border-top: 3px solid rgba(0, 0, 0, 0.3);
        }

        .profit-text {
            text-align: right;
            font-weight: bold;
            color: #000;
            font-size: 36px;
        }

        .profit-label {
            font-size: 22px;
            font-weight: normal;
            margin-top: 6px;
        }

        .date {
            font-size: 20px;
            margin-top: 15px;
            opacity: 0.7;
            text-align: right;
        }

        /* Print Controls (Tugmalar) CSS kodlari qo'shildi */
        .print-controls {
            text-align: center;
            margin-top: 30px;
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }

        .btn {
            padding: 18px 36px;
            margin: 0 10px;
            border-radius: 12px;
            border: 2px solid #333;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-print {
            background: #f4dd2c;
            color: #000;
        }

        .btn-print:hover {
            background: #f2c94c;
            transform: scale(1.05);
        }

        .btn-close {
            background: #fff;
            color: #333;
        }

        .btn-close:hover {
            background: #f5f5f5;
        }

        /* Bosib chiqarish uchun o'zgartirishlar */
        @media print {
            body {
                width: 210mm;
                height: 297mm;
                padding: 0;
                margin: 0;
            }

            .print-controls {
                display: none !important;
            }

            .sticker {
                box-shadow: none;
                width: 210mm;
                min-height: 297mm;
                padding: 20mm 15mm;
                /* Sahifa chekka o'lchovlari kamaytirildi */
                border-radius: 0;
                background: linear-gradient(135deg, #f4dd2c, #f2c94c) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                page-break-inside: avoid;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }

        /* Ekrandagi kichik qurilmalar uchun moslashuvchanlik */
        @media screen and (max-width: 800px) {
            body {
                width: 100%;
                padding: 20px;
            }

            .sticker {
                width: 100%;
                min-height: auto;
                padding: 30px;
            }

            .title {
                font-size: 28px;
            }

            .big-price {
                font-size: 48px;
            }

            .table {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

    <div class="sticker">
        <div class="title">{{ $product->name }}</div>

        <div class="price-section">
            <div class="price-label">12 ойга</div>
            <div class="big-price">
                {{ $m12 }}
                <div class="big-price-sub">сўмдан бошланади</div>
            </div>
        </div>

        <div class="table">
            <div class="table-row">
                <span>Маҳсулот нархи</span>
                <span><strong>{{ number_format($product->old_price, 0, '.', ' ') }} сўм</strong></span>
            </div>
            <div class="table-row">
                <span>Promo нархи</span>
                <span><strong>{{ number_format($price, 0, '.', ' ') }} сўм</strong></span>
            </div>
            <div class="table-row">
                <span>24 ойга</span>
                <span>{{ $m24 }} сўм</span>
            </div>
            <div class="table-row">
                <span>18 ойга</span>
                <span>{{ $m18 }} сўм</span>
            </div>
            <div class="table-row">
                <span>9 ойга</span>
                <span>{{ $m9 }} сўм</span>
            </div>
            <div class="table-row">
                <span>6 ойга</span>
                <span>{{ $m6 }} сўм</span>
            </div>
            <div class="table-row">
                <span>3 ойга</span>
                <span>{{ $m3 }} сўм</span>
            </div>
        </div>

        <div class="profit-section">
            <div class="profit-text">
                {{ number_format($product->old_price - $price, 0, '.', ' ') }} сўм
                <div class="profit-label">Мижозга фойда</div>
            </div>
        </div>

        <div class="date">{{ date('Y-m-d') }}</div>
    </div>

    <div class="print-controls">
        <button onclick="window.print()" class="btn btn-print">🖨 Распечатать</button>
        <a href="javascript:window.close()" class="btn btn-close">Закрыть</a>
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>

</body>

</html>