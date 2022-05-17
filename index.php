<?php

require_once 'vendor/autoload.php';

use App\Common\Ambiente;

Ambiente::carregar(__DIR__);

session_start();

$template = file_get_contents('App/Template/estrutura.html');

ob_start();

    $core = new App\Core\Core();

    $core->start($_GET);

    $saida = ob_get_contents();

ob_end_clean();

ob_start();

    $carregarNavbar = new App\Utils\CarregarNavbar();

    $carregarNavbar->carregar();

    $saidaNavbar = ob_get_contents();

ob_end_clean();


$templatePronto = str_replace('{{estrutura}}', $saida, $template);

$templatePronto = str_replace('{{navbar}}', $saidaNavbar, $templatePronto);

echo $templatePronto;

