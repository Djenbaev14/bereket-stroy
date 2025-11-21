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
        flex-direction: column;
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
        margin-bottom: 20px;
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

    .print-btn {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        background: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .print-btn:hover {
        background: #45a049;
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
    }
</style>
</head>
<body>

<div class="sticker" id="sticker">
    <div class="title">{{ $product->name }}</div>

    <div class="price-section">
        <div class="gray">12 ойга</div>
        <div class="big-price">{{$m12}} <span class="gray" style="font-weight: normal">сўмдан бошланади</span></div>
    </div>

    <div class="table">
        <div><span>Маҳсулот нархи</span> <span>{{ number_format($price, 0, '.', ' ') }} сўмдан</span></div>
        <div><span>24 ойга</span> <span>{{ $m24 }} сўмдан</span></div>
        <div><span>18 ойга</span> <span>{{ $m18 }} сўмдан</span></div>
        <div><span>9 ойга</span> <span>{{ $m9 }} сўмдан</span></div>
        <div><span>6 ойга</span> <span>{{ $m6 }} сўмдан</span></div>
        <div><span>3 ойга</span> <span>{{ $m3 }} сўмдан</span></div>
    </div>
</div>

<button class="print-btn" onclick="printSticker()">Распечатать</button>

<script>
function printSticker() {
    const stickerContent = document.getElementById('sticker').innerHTML;
    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write('<html><head><title>Печать</title>');
    printWindow.document.write('<style>body{font-family: Arial, sans-serif; padding:20px;} .sticker{background: linear-gradient(135deg, #f4dd2c, #f2c94c); padding:25px; border-radius:15px; width:100%; box-sizing:border-box;} .title{font-size:20px;font-weight:bold;margin-bottom:10px;} .price-section{margin-bottom:10px;} .big-price{font-size:36px;font-weight:bold;} .gray{font-size:14px;color:#333;} .table div{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(0,0,0,0.1);}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div class="sticker">' + stickerContent + '</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>

</body>
</html>
