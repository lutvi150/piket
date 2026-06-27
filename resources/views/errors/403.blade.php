<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>403 - Akses Ditolak</title>

<style>
*{margin:0;padding:0;box-sizing:border-box}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#dd4b39,#ff851b);
    font-family:Arial,sans-serif;
    overflow:hidden;
}

.container{
    text-align:center;
    color:#fff;
    z-index:2;
}

.error-code{
    font-size:140px;
    font-weight:bold;
    animation:pulse 2s infinite;
    text-shadow:0 10px 30px rgba(0,0,0,.25);
}

.icon{
    font-size:70px;
    margin-bottom:15px;
    animation:shake 3s infinite;
}

.title{
    font-size:32px;
    margin-bottom:15px;
}

.desc{
    font-size:18px;
    opacity:.9;
    max-width:600px;
    margin:auto;
    line-height:1.6;
}

.btn{
    margin-top:30px;
    display:inline-block;
    padding:12px 30px;
    background:#fff;
    color:#dd4b39;
    text-decoration:none;
    border-radius:50px;
    font-weight:bold;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-3px);
}

.circle{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    animation:float 10s linear infinite;
}

.circle:nth-child(1){
    width:180px;
    height:180px;
    top:10%;
    left:5%;
}

.circle:nth-child(2){
    width:250px;
    height:250px;
    bottom:10%;
    right:10%;
}

@keyframes pulse{
    0%,100%{transform:scale(1)}
    50%{transform:scale(1.05)}
}

@keyframes shake{
    0%,100%{transform:rotate(0deg)}
    25%{transform:rotate(-8deg)}
    75%{transform:rotate(8deg)}
}

@keyframes float{
    0%{transform:translateY(0)}
    50%{transform:translateY(-30px)}
    100%{transform:translateY(0)}
}
</style>
</head>
<body>

<div class="circle"></div>
<div class="circle"></div>

<div class="container">
    <div class="icon">🔒</div>
    <div class="error-code">403</div>

    <h2 class="title">Akses Ditolak</h2>

    <p class="desc">
        Anda tidak memiliki izin untuk mengakses halaman ini.
        Silakan hubungi administrator sekolah apabila Anda merasa seharusnya memiliki akses.
    </p>

    <a href="{{ url('/') }}" class="btn">
        Kembali ke Dashboard
    </a>
</div>

</body>
</html>