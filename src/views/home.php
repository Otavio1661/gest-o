<?php 
    include __DIR__ . '/../../core/config.php';

    // $teste = $_GET['SucessoAddC'];

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistema - Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./public/css/home2.css">

</head>

<body>
<!-- 
<div>
    <h1><?php print_r($teste); ?></h1>
</div> -->

    <!-- Navbar (topo) -->
    <?php include __DIR__ . '/partials/navTopo.php'; ?>

    <!-- Menu lateral -->
    <?php include __DIR__ . '/partials/navLateral.php' ?>

    <div class="content-area">
    <?php include __DIR__ . '/partials/acoesRapidas.php'; ?>
    <!-- Conteúdo -->
    <?php include __DIR__ . '/section/clientes.php' ?>
    <?php include __DIR__ . '/section/relatorios.php' ?>
    <?php include __DIR__ . '/section/pagamentos.php' ?>
    <?php include __DIR__ . '/section/caixa.php' ?>
    <?php include __DIR__ . '/partials/footer.php' ?>





<!-- <script src="./../../public/js/estilo.js"></script> -->

    <script>
        const toggleBtn = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebarMenu');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
        

          // Fecha o menu ao clicar em um link (somente se a tela for pequena)
        document.querySelectorAll('#sidebarMenu .menu-link').forEach(link => {
            link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                sidebar.classList.remove('show');
            }
            });
        });
    </script>

</body>

</html>