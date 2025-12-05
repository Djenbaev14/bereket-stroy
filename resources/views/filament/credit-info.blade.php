<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <title>Информация о рассрочке</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
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
            border-top: 1px solid rgba(0, 0, 0, 0.2);
        }

        .table-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .profit-section {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 1px solid rgba(0, 0, 0, 0.2);
        }

        .profit-text {
            text-align: right;
            font-weight: bold;
            color: #000;
        }

        .profit-label {
            font-size: 12px;
            font-weight: normal;
            margin-top: 2px;
        }

        .date {
            font-size: 12px;
            margin-top: 10px;
            opacity: 0.8;
        }

        .print-button {
            margin-top: 15px;
            padding: 12px 24px;
            background: #fff;
            color: #333;
            border-radius: 8px;
            border: 1px solid #333;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .print-button:hover {
            background: #f0f0f0;
        }

        /* PRINT STYLES */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }

            body {
                background: #fff !important;
                padding: 0 !important;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .no-print {
                display: none !important;
            }

            .sticker {
                box-shadow: none !important;
                width: 380px !important;
                page-break-inside: avoid;
                background: linear-gradient(135deg, #f4dd2c, #f2c94c) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
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

    <div style="text-align: center;">
        <div class="sticker" id="printContent">
            <div class="title">Велотренажер PowerGym B37</div>

            <div class="price-section">
                <div class="gray">12 ойга</div>
                <div class="big-price">286 350 <span class="gray" style="font-weight: normal">сўмдан бошланади</span></div>
            </div>

            <div class="table">
                <div class="table-row">
                    <span>Маҳсулот нархи</span>
                    <span>2 490 000 сўмдан</span>
                </div>
                <div class="table-row">
                    <span>Promo нархи</span>
                    <span>2 490 000 сўмдан</span>
                </div>
                <div class="table-row">
                    <span>24 ойга</span>
                    <span>182 600 сўмдан</span>
                </div>
                <div class="table-row">
                    <span>18 ойга</span>
                    <span>217 183 сўмдан</span>
                </div>
                <div class="table-row">
                    <span>9 ойга</span>
                    <span>365 200 сўмдан</span>
                </div>
                <div class="table-row">
                    <span>6 ойга</span>
                    <span>518 750 сўмдан</span>
                </div>
                <div class="table-row">
                    <span>3 ойга</span>
                    <span>954 500 сўмдан</span>
                </div>
            </div>

            <div class="profit-section">
                <div class="profit-text">
                    0
                    <div class="profit-label">Мижозга фойда</div>
                </div>
            </div>

            <div class="date">2025-12-05</div>
        </div>
    </div>

    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const observer = new MutationObserver(function(mutations) {
                const printBtn = document.querySelector('button[type="submit"]');
                if (printBtn && printBtn.textContent.includes('Распечатать')) {
                    printBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        window.print();
                        return false;
                    });
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });

        if (typeof Livewire !== 'undefined') {
            Livewire.on('printCredit', () => {
                window.print();
            });
        }
    </script>

</body>

</html>