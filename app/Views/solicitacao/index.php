<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de Cargo - Jornal Atlas</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="search-box"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Buscar notícias..."></div>
        <div class="logo"><a href="<?= url('/') ;?>"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a></div>
        <div class="header-buttons">
            <a href="<?= url('/') ;?>" class="btn-login"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        </div>
    </header>
    <section class="secao" style="margin-top:30px;">
        <h2>Solicitações de Cargo</h2>
        <div class="card" style="padding:40px; max-width:600px; margin:0 auto;">
            <p style="text-align:center; color:#777; font-size:16px;">
                <i class="fa-solid fa-wrench" style="font-size:40px; color:var(--dourado); margin-bottom:15px; display:block;"></i>
                Esta funcionalidade será implementada em breve.
            </p>
        </div>
    </section>
</body>
</html>