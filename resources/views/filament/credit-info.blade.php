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
    }

    .sticker {
        background: #f4dd2c;
        padding: 20px;
        border-radius: 8px;
        color: #000;
        position: relative;
        display: block;
        width: 100%;
        height: 100%; /* 🔥 modalni to‘liq egallash uchun */
        margin: 0;
        overflow: visible; /* scroll chiqmasligi uchun */
    }

    .title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .specs {
        font-size: 12px;
        line-height: 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .big-price {
        font-size: 42px;
        font-weight: bold;
        margin: 5px 0;
    }

    .gray {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .table {
        margin-top: 10px;
        font-size: 14px;
    }

    .table div {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid rgba(0,0,0,0.2);
    }

    .qr-area {
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .benefit {
        font-size: 22px;
        font-weight: bold;
        color: #000;
        text-align: right;
    }

    .benefit small {
        font-size: 14px;
        display: block;
    }

    .footer {
        font-size: 12px;
        margin-top: 15px;
    }
    /* 🔥 RESPONSIVE */
    @media (max-width: 450px) {
        .big-price { font-size: 34px; }
        .title { font-size: 18px; }
        .benefit { font-size: 18px; }
        .qr-area img { width: 70px; }
    }
</style>
</head>
<body>

<div class="sticker">


    <div class="title">Совутгич Artel HD 395 FWEN — WH</div>

    <div class="specs">
        <div>
            <div>Шиклар сони: 2</div>
            <div>Шовқин: 42 dB</div>
            <div>Энергия сарфи: 252 кВт</div>
        </div>
        <div>
            <div>Ҳажми: 305 л</div>
            <div>Класс: A+</div>
            <div>No Frost</div>
        </div>
    </div>

    <div class="gray">12 ойга</div>
    <div class="big-price">693 000</div>
    <div class="gray">сўмдан бошланади</div>

    <div class="table">
        <div><span>Маҳсулот нархи</span> <span>8 873 000 сўмдан</span></div>
        <div><span>Promo нархи</span> <span>5 856 180 сўмдан</span></div>
        <div><span>9 ойга</span> <span>897 900 сўмдан</span></div>
        <div><span>6 ойга</span> <span>1 327 400 сўмдан</span></div>
        <div><span>3 ойга</span> <span>2 479 100 сўмдан</span></div>
    </div>


</div>

</body>
</html>
