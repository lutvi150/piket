<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>500 - Kesalahan Sistem</title>

<style>
*{margin:0;padding:0;box-sizing:border-box}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#001f3f,#0073b7);
    font-family:Arial,sans-serif;
    overflow:hidden;
}

.container{
    text-align:center;
    color:white;
    z-index:2;
}

.error-code{
    font-size:140px;
    font-weight:bold;
    animation:glitch 2s infinite;
    text-shadow:0 10px 30px rgba(0,0,0,.3);
}

.icon{
    font-size:70px;
    margin-bottom:20px;
    animation:rotate 5s linear infinite;
}

.title{
    font-size:32px;
    margin-bottom:15px;
}

.desc{
    font-size:18px;
    max-width:650px;
    margin:auto;
    line-height:1.6;
    opacity:.9;
}

.btn{
    margin-top:30px;
    display:inline-block;
    padding:12px 30px;
    background:white;
    color:#0073b7;
    border-radius:50px;
    text-decoration:none;
    font-weight:bold;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-3px);
}

.dot{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    animation:float 8s linear infinite;
}

.dot:nth-child(1){
    width:120px;
    height:120px;
    left:10%;
    top:20%;
}

.dot:nth-child(2){
    width:200px;
    height:200px;
    right:10%;
    bottom:15%;
}

.dot:nth-child(3){
    width:80px;
    height:80px;
    top:15%;
    right:30%;
}

@keyframes rotate{
    from{transform:rotate(0deg)}
    to{transform:rotate(360deg)}
}

@keyframes glitch{
    0%,100%{
        transform:translateX(0);
    }
    20%{
        transform:translateX(-3px);
    }
    40%{
        transform:translateX(3px);
    }
    60%{
        transform:translateX(-3px);
    }
    80%{
        transform:translateX(3px);
    }
}

@keyframes float{
    0%{transform:translateY(0)}
    50%{transform:translateY(-25px)}
    100%{transform:translateY(0)}
}
</style>
</head>
<body>

<div class="dot"></div>
<div class="dot"></div>
<div class="dot"></div>

<div class="container">
    <div class="icon">⚙️</div>

    <div class="error-code">500</div>

    <h2 class="title">Terjadi Kesalahan Sistem</h2>

    <p class="desc">
        Maaf, sistem piket sekolah sedang mengalami gangguan.
        Silakan coba kembali beberapa saat lagi atau hubungi administrator jika masalah terus berlanjut.
    </p>

    <a href="{{ url('/') }}" class="btn">
        Kembali ke Dashboard
    </a>
</div>

</body>
</html>