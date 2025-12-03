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
                return inscription_utilisateur($identifiant, $mdp);
            }
            else if ($action == 'connexion'){
                $identifiant = $_POST['identifiant'];
                $mdp = $_POST['mdp'];
                return connexion_utilisateur($identifiant, $mdp);
            }             
        }

        afficher_page_connexion_inscription();
        
    }

    else if ($section == 'categorie'){
        if ($action == null){
            return afficher_page_accueil();
        }
        else if ($action == 'commenter'){
            //
        }
        else if (is_numeric($action)){
            return afficher_page_categorie($action);
        }
        else{
            return afficher_page_erreur($option);
        }
    }

    else if ($section == 'publier'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $idCat = $_POST['idCat'];
            $idUser = $_SESSION['utilisateur']['IdUser'];
            $texte = $_POST['texte'];
            return publier_message($idCat, $idUser, $texte);
        }
        $utilisateur = $_SESSION['utilisateur'];
        afficher_page_publier($utilisateur);
    }

    else if ($section == 'profil'){
        $utilisateur = $_SESSION['utilisateur'];
        afficher_page_profil($utilisateur);
    }

    else if ($section == 'parametre'){        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if ($action == 'deconnexion'){
                session_destroy();
                return afficher_page_deconnexion();
            }
        }
        if ($action == 'biographie'){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $idUser = $_SESSION['utilisateur']['IdUser'];
                $biographie = $_POST['biographie'];
                $utilisateur = $_SESSION['utilisateur'];
                return update_bio($idUser, $biographie, $utilisateur);
            }
            return afficher_page_modifier_biographie();
        }
        if ($action == 'identifiant'){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $idUser = $_SESSION['utilisateur']['IdUser'];
                $identifiant = $_POST['identifiant'];
                $utilisateur = $_SESSION['utilisateur'];
                update_pseudo($idUser, $identifiant, $utilisateur);
            }
            return afficher_page_modifier_identifiant();
        }
        else{
            afficher_page_parametre();
        }
        
    }


    else if ($section == null || $section == 'accueil'){
        afficher_page_accueil();
    }
    
    else{
        $option = "ERREUR : page non trouvée";
        afficher_page_erreur($option);
    }

?>