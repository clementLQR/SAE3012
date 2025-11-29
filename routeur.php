<?php
    require 'controler.php';
    require 'vendor/autoload.php';

    // Récupérer l'URL et découper le chemin
    $url = parse_url($_SERVER['REQUEST_URI']);
    $path = $url['path'];
    $pathExplode = explode('/', trim($path, '/')); // enlève les / inutiles


    $section = $pathExplode[1] ?? null;  
    $action  = $pathExplode[3] ?? null; 

    print_r($pathExplode);
    // echo '<br>'.$section.'<br>';
    // echo '<br>'.$action.'<br>';


    if ($section === 'connexion-inscription'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($action === 'inscription'){
                $identifiant = $_POST['nouvel_identifiant'];
                $mdp = $_POST['nouveau_mdp'];
                inscription_utilisateur($identifiant, $mdp);
            }
            else if ($action === 'connexion'){
                $identifiant = $_POST['identifiant'];
                $mdp = $_POST['mdp'];

                connexion_utilisateur($identifiant, $mdp);
            }             
        }
        afficher_page_connexion_inscription();
    }
    

?>