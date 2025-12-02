<?php
    session_start();
    require 'controler.php';
    require 'vendor/autoload.php';

    // Récupérer l'URL et découper le chemin
    $url = parse_url($_SERVER['REQUEST_URI']);
    $path = $url['path'];
    $pathExplode = explode('/', trim($path, '/')); // enlève les / inutiles


    $section = $pathExplode[1] ?? null;  
    $action  = $pathExplode[2] ?? null; 

    echo '<br>';
    print_r($pathExplode);
    echo '<br>';
    print_r($_SESSION);
    echo '<br>';
    // echo '<br>'.$section.'<br>';
    // echo '<br>'.$action.'<br>';

    if ($_SESSION == null && $section != 'connexion-inscription'){
        afficher_page_connexion_inscription();
    }


    else if ($section == 'connexion-inscription'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($action == 'inscription'){
                $identifiant = $_POST['nouvel_identifiant'];
                $mdp = $_POST['nouveau_mdp'];
                inscription_utilisateur($identifiant, $mdp);
                $path = [];
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
            $idCat = $_POST['idCat'];
            $idUser = $_SESSION['utilisateur']['IdUser'];
            $texte = $_POST['texte'];
            publier_message($idCat, $idUser, $texte);
        }
        $utilisateur = $_SESSION['utilisateur'];
        afficher_page_publier($utilisateur);
    }

    else if ($section == 'profil'){
        afficher_page_profil();
    }

    else if ($section == 'parametre'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if ($action == 'deconnexion'){
                session_destroy();
                afficher_page_deconnexion();
            }
            else if ($action == 'biographie'){
                afficher_page_modifier_biographie();
            }
        }
        afficher_page_parametre();
    }


    else if ($section == null || $section == 'accueil'){
        afficher_page_accueil();
    }
    
    else{
        afficher_page_erreur();
    }

?>