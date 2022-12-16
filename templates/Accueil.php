<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
  crossorigin="anonymous"
></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href="/certification3/css/style.scss" rel="stylesheet">
<link rel="stylesheet" href="../css/iziToast.css">

<?php
require_once '../vendor/autoload.php';

$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

echo $twig->render('connexion.html.twig');


