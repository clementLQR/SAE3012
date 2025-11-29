<?php
    // on charge les paquets installés avec Composer
    require_once 'vendor/autoload.php';
    // on charge les templates (gabarit de la vue)
    // un objet de class FilesystemLoader est créé et stocké dans la variable $loader;
    $loader = new \Twig\Loader\FilesystemLoader('./template');
    // on initialise l'environnement Twig
    // en créant un objet de classe Environment qui sera stocké dans la variable $twig
    $twig = new \Twig\Environment($loader);
    ////////////////////////
    // on aurait pu utiliser des options si besoin
    // $options = array(
    // debug => false,
    // cache => true,
    // );
    //$twig = new \Twig\Environment($loader, $options);
?>