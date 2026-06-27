<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #3c8dbc, #00c0ef);
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .container {
            text-align: center;
            color: white;
            z-index: 2;
        }

        .error-code {
            font-size: 150px;
            font-weight: bold;
            animation: bounce 2s infinite;
            text-shadow: 0 10px 30px rgba(0,0,0,.2);
        }

        .title {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .desc {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: .9;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: white;
            color: #3c8dbc;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: .3s;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,.2);
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
            animation: float 8s infinite linear;
        }

        .circle:nth-child(1) {
            width: 120px;
            height: 120px;
            left: 10%;
            top: 20%;
        }

        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            right: 10%;
            bottom: 10%;
            animation-duration: 10s;
        }

        .circle:nth-child(3) {
            width: 80px;
            height: 80px;
            right: 25%;
            top: 15%;
            animation-duration: 6s;
        }

        @keyframes bounce {
            0%,100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-30px) rotate(180deg);
            }
            100% {
                transform: translateY(0px) rotate(360deg);
            }
        }
    </style>
</head>
<body>

    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="container">
        <div class="error-code">404</div>

        <h2 class="title">
            Halaman Tidak Ditemukan
        </h2>

        <p class="desc">
            Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.
        </p>

        <a href="{{ url('/') }}" class="btn">
            Kembali ke Dashboard
        </a>
    </div>

</body>
</html>