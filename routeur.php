<?php
    require 'controler.php';
    require 'vendor/autoload.php';

    // Récupérer l'URL et découper le chemin
    $url = parse_url($_SERVER['REQUEST_URI']);
    $path = $url['path'];
    $pathExplode = explode('/', trim($path, '/')); // enlève les / inutiles


    $section = $pathExplode[1] ?? null;  
    $action  = $pathExplode[2] ?? null; 

    print_r($pathExplode);
    // echo '<br>'.$section.'<br>';
    // echo '<br>'.$action.'<br>';


    if ($section == 'connexion-inscription'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($action == 'inscription'){
                $identifiant = $_POST['nouvel_identifiant'];
                $mdp = $_POST['nouveau_mdp'];
                inscription_utilisateur($identifiant, $mdp);
            }
            else if ($action == 'connexion'){
                $identifiant = $_POST['identifiant'];
                $mdp = $_POST['mdp'];

                connexion_utilisateur($identifiant, $mdp);
            }             
        }
        afficher_page_connexion_inscription();
    }

    else if ($section == 'categorie'){
        if ($action == null){
            afficher_page_accueil();
        }
        else if ($action == 'commenter'){
            //
        }
        else if (is_numeric($action)){
            afficher_page_categorie($action);
        }
        else{
            afficher_page_erreur();
        }
    }

    else if ($section == 'publier'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $imageSrc = $_POST['imageSrc'];
            $idCat = $_POST['idCat'];
            $idUser = $_POST['idUser'];
            $texte = $_POST['texte'];
            ajouter_message($imageSrc, $idCat, $idUser, $texte);
        }
        afficher_page_publier();
    }

    else if ($section == 'profil'){
        afficher_page_profil();
    }


    else if ($section == null || $section == 'accueil'){
        afficher_page_accueil();
    }
    
    else{
        afficher_page_erreur();
    }

?>