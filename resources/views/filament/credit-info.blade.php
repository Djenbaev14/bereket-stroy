<div id="sticker">
    <div class="title">{{ $product->name }}</div>

    <div class="price-section">
        <div class="gray">12 ойга</div>
        <div class="big-price">{{ $m12 }} <span class="gray" style="font-weight: normal">сўмдан бошланади</span></div>
    </div>

    <div class="table">
        <div><span>Маҳсулот нархи</span> <span>{{ number_format($price, 0, '.', ' ') }} сўмдан</span></div>
        <div><span>24 ойга</span> <span>{{ $m24 }} сўмдан</span></div>
        <div><span>18 ойга</span> <span>{{ $m18 }} сўмдан</span></div>
        <div><span>9 ойга</span> <span>{{ $m9 }} сўмдан</span></div>
        <div><span>6 ойга</span> <span>{{ $m6 }} сўмдан</span></div>
        <div><span>3 ойga</span> <span>{{ $m3 }} сўмдан</span></div>
    </div>
</div>

<button type="button" class="print-btn" onclick="printSticker()">Распечатать</button>

<script>
function printSticker() {
    // Sticker divni olamiz
    const stickerContent = document.getElementById('sticker').innerHTML;

    // Yangi window ochamiz
    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write('<html><head><title>Печать</title>');
    printWindow.document.write('<style>body{font-family: Arial,sans-serif;padding:20px;} .sticker{background:#f4dd2c;padding:25px;border-radius:15px;width:100%;box-sizing:border-box;} .title{font-size:20px;font-weight:bold;margin-bottom:10px;} .price-section{margin-bottom:10px;} .big-price{font-size:36px;font-weight:bold;} .gray{font-size:14px;color:#333;} .table div{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(0,0,0,0.1);}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div class="sticker">' + stickerContent + '</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>
