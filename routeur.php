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

    // echo '<br>';
    // print_r($pathExplode);
    // echo '<br>';
    // print_r($_SESSION);
    // echo '<br>';
    // echo '<br>'.$section.'<br>';
    // echo '<br>'.$action.'<br>';
    // print_r($_POST);
    // echo '<br>';

    if ($_SESSION == null && $section != 'connexion-inscription'){
        header('Location: http://localhost/SAE3012/connexion-inscription' );
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

    else if ($section == 'commentaires'){

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['messageId']) && isset($_POST['texte'])){
            $idMsg = $_POST['messageId'];
            $idUser = $_SESSION['utilisateur']['IdUser'];
            $texte = $_POST['texte'];
            publier_commentaire($idMsg, $idUser, $texte);
            return afficher_page_commentaire($idMsg);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $messageId = $_POST['messageId'];
            afficher_page_commentaire($messageId);        
        }
    
        
    }

    else if ($section == 'commentaires'){

    }

    else if ($section == 'jeux%20video'){  
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tri'])) {
            if ($_POST['tri'] === 'Plus récent') {
                return afficher_page_categorie_trier_par_date(1);
            } 
            else if ($_POST['tri'] === 'Plus de Likes') {
                return afficher_page_categorie_trier_par_likes(1);
            }
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $messageId = $_POST['messageId'];
            $userId = $_SESSION['utilisateur']['IdUser'];
            if (isset($_POST['like'])){
                like_message($messageId, $userId);
            }
            else if (isset($_POST['dislike'])){
                dislike_message($messageId, $userId);
            }
        }
        return afficher_page_categorie(1);
    }

    else if ($section == 'musique'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus récent'){
            return afficher_page_categorie_trier_par_date(2);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus de Likes'){
            return afficher_page_categorie_trier_par_likes(2);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $messageId = $_POST['messageId'];
            $userId = $_SESSION['utilisateur']['IdUser'];
            if (isset($_POST['like'])){
                like_message($messageId, $userId);
            }
            else if (isset($_POST['dislike'])){
                dislike_message($messageId, $userId);
            }
        }
        afficher_page_categorie(2);
    }

    else if ($section == 'films'){
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus récent'){
            return afficher_page_categorie_trier_par_date(3);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus de Likes'){
            return afficher_page_categorie_trier_par_likes(3);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $messageId = $_POST['messageId'];
            $userId = $_SESSION['utilisateur']['IdUser'];
            if (isset($_POST['like'])){
                like_message($messageId, $userId);
            }
            else if (isset($_POST['dislike'])){
                dislike_message($messageId, $userId);
            }
        }
        afficher_page_categorie(3);
    }

    else if ($section == 'livres'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus récent'){
            return afficher_page_categorie_trier_par_date(4);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus de Likes'){
            return afficher_page_categorie_trier_par_likes(4);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $messageId = $_POST['messageId'];
            $userId = $_SESSION['utilisateur']['IdUser'];
            if (isset($_POST['like'])){
                like_message($messageId, $userId);
            }
            else if (isset($_POST['dislike'])){
                dislike_message($messageId, $userId);
            }
        }
        afficher_page_categorie(4);
    }

    else if ($section == 'sport'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus récent'){
            return afficher_page_categorie_trier_par_date(5);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus de Likes'){
            return afficher_page_categorie_trier_par_likes(5);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $messageId = $_POST['messageId'];
            $userId = $_SESSION['utilisateur']['IdUser'];
            if (isset($_POST['like'])){
                like_message($messageId, $userId);
            }
            else if (isset($_POST['dislike'])){
                dislike_message($messageId, $userId);
            }
        }
        afficher_page_categorie(5);
    }

    else if ($section == 'peinture%20et%20dessin'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus récent'){
            return afficher_page_categorie_trier_par_date(6);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus de Likes'){
            return afficher_page_categorie_trier_par_likes(6);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $messageId = $_POST['messageId'];
            $userId = $_SESSION['utilisateur']['IdUser'];
            if (isset($_POST['like'])){
                like_message($messageId, $userId);
            }
            else if (isset($_POST['dislike'])){
                dislike_message($messageId, $userId);
            }
        }
        afficher_page_categorie(6);
    }

    else if ($section == 'photographie'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus récent'){
            return afficher_page_categorie_trier_par_date(7);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus de Likes'){
            return afficher_page_categorie_trier_par_likes(7);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $messageId = $_POST['messageId'];
            $userId = $_SESSION['utilisateur']['IdUser'];
            if (isset($_POST['like'])){
                like_message($messageId, $userId);
            }
            else if (isset($_POST['dislike'])){
                dislike_message($messageId, $userId);
            }
        }
        afficher_page_categorie(7);
    }

    else if ($section == 'series'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus récent'){
            return afficher_page_categorie_trier_par_date(8);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tri'] == 'Plus de Likes'){
            return afficher_page_categorie_trier_par_likes(8);
        }

        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $messageId = $_POST['messageId'];
            $userId = $_SESSION['utilisateur']['IdUser'];
            if (isset($_POST['like'])){
                like_message($messageId, $userId);
            }
            else if (isset($_POST['dislike'])){
                dislike_message($messageId, $userId);
            }
        }
        afficher_page_categorie(8);
    }

    else if ($section == 'publier'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $idCat = $_POST['idCat'];
            $idUser = $_SESSION['utilisateur']['IdUser'];
            $texte = $_POST['texte'];
            header('Location: http://localhost/SAE3012' );
            return publier_message($idCat, $idUser, $texte);
        }
        $utilisateur = $_SESSION['utilisateur'];
        afficher_page_publier($utilisateur);
    }

    else if ($section == 'profil'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $messageId = $_POST['messageId'];
            supprimer_message($messageId);
        }
        $utilisateur = $_SESSION['utilisateur'];
        afficher_page_profil($utilisateur);
    }

    else if ($section == 'parametre'){        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            session_destroy();
            return afficher_page_deconnexion();
        }
        else{
            afficher_page_parametre();
        }
        
    }

    else if ($section == 'deconnexion'){        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            session_destroy();
            return afficher_page_deconnexion();
    }}

    else if ($section == 'biographie'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $idUser = $_SESSION['utilisateur']['IdUser'];
            $biographie = $_POST['biographie'];
            $utilisateur = $_SESSION['utilisateur'];
            return update_bio($idUser, $biographie, $utilisateur);
        }
        return afficher_page_modifier_biographie();
    }
    else if ($section == 'identifiant'){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $idUser = $_SESSION['utilisateur']['IdUser'];
            $identifiant = $_POST['identifiant'];
            $utilisateur = $_SESSION['utilisateur'];
            update_pseudo($idUser, $identifiant, $utilisateur);
        }
        return afficher_page_modifier_identifiant();
    }

    else if ($section == null || $section == 'accueil'){
        return afficher_page_accueil();
    }
    
    else{
        $option = "ERREUR : page non trouvée";
        afficher_page_erreur($option);
    }

?>