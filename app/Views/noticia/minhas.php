<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Notícias - Jornal Atlas</title>
    <link rel="icon" type="image/png" href="<?= asset('img/atlas.fav.png') ;?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="search-box"><i class="fa-solid fa-magnifying-glass"></i>
            <form action="<?= url('/busca') ;?>" method="GET">
                <input type="hidden" name="url" value="busca">
                <input type="text" name="q" placeholder="Buscar notícias...">
            </form>
        </div>
        <div class="logo"><a href="<?= url('/') ;?>"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a></div>
        <div class="header-buttons">
            <a href="<?= url('/noticia/nova') ;?>" class="btn-cadastro"><i class="fa-solid fa-plus"></i> Nova Notícia</a>
            <a href="<?= url('/') ;?>" class="btn-login"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        </div>
    </header>
    <section class="secao" style="margin-top:30px;">
        <h2>Minhas Notícias</h2>
        <?php if (empty($noticias)): ?>
            <div class="card" style="padding:40px; max-width:600px; margin:0 auto; text-align:center;">
                <i class="fa-regular fa-newspaper" style="font-size:40px; color:var(--dourado); margin-bottom:15px; display:block;"></i>
                <p style="color:#777; font-size:16px; margin-bottom:15px;">Você ainda não publicou nenhuma notícia.</p>
                <a href="<?= url('/noticia/nova') ;?>" class="btn-enviar" style="text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border-radius:8px;">
                    <i class="fa-solid fa-plus"></i> Criar Primeira Noticia
                </a>
            </div>
        <?php else: ?>
            <div class="cards">
                <?php foreach ($noticias as $noticia): ?>
                <div class="card-wrapper">
                    <a href="<?= url('/noticia/' . $noticia->getId()) ;?>" class="card card-link">
                        <div class="card-img-wrapper">
                            <?php if ($noticia->getImagem()): ?>
                                <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                            <?php else: ?>
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f0f0f0;color:#ccc;"><i class="fa-regular fa-newspaper" style="font-size:32px;"></i></div>
                            <?php endif; ?>
                            <span class="card-status-badge card-status-<?= strtolower($noticia->getStatus()->value) ;?>">
                                <?= e($noticia->getStatus()->value) ;?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h3><?= e($noticia->getTitulo()) ;?></h3>
                            <p><?= e($noticia->getResumo()) ;?></p>
                        </div>
                    </a>
                    <div class="card-admin-footer">
                        <a href="<?= url('/noticia/' . $noticia->getId() . '/editar') ;?>" class="btn-card-manage"><i class="fa-solid fa-pen"></i> Editar</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <script src="<?= asset('js/script.js') ;?>"></script>
</body>
</html>