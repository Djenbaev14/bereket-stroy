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

    .specs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        font-size: 12px;
        line-height: 1.4;
        gap: 10px;
    }

    .specs div {
        display: flex;
        flex-direction: column;
        gap: 3px;
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
        .specs {
            grid-template-columns: 1fr;
        }
        .benefit {
            font-size: 16px;
        }
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

    <div class="price-section">
        <div class="gray">12 ойга</div>
        <div class="big-price">693 000</div>
        <div class="gray">сўмдан бошланади</div>
    </div>

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
