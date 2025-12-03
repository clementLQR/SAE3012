<?php
    require_once 'modele/modele.php';
    require_once __DIR__.'/bootstrap.php';

    function afficher_page_connexion_inscription(){
        global $twig;
        echo $twig->render('enfant-connexion-inscription.twig.html');
    }

    function inscription_utilisateur($identifiant, $mdp){
        $success = insert_utilisateur($identifiant, $mdp);
        if ($success) {
            connecte_utilisateur($identifiant, $mdp);
            header('Location: http://localhost/SAE3012' );
            return afficher_page_accueil();
        } else {
            $option = "Erreur d'inscription";
            afficher_page_erreur($option);
        }
    }

    function connexion_utilisateur($identifiant, $mdp){
        $success = connecte_utilisateur($identifiant, $mdp);
        if ($success) {
            header('Location: http://localhost/SAE3012' );
            return afficher_page_accueil();
        } else {
            $option = "Erreur de connexion";
            afficher_page_erreur($option);
        }
    }

    function afficher_page_accueil(){
        global $twig;
        $categories = get_all_categorie();
        echo $twig->render('enfant-accueil.twig.html', ['categories' => $categories]);
    } 
    
    function afficher_page_categorie($idCat){
        global $twig;
        print_r(get_messages_par_categorie($idCat));
        echo $twig -> render('enfant-categorie.twig.html', 
        ['categorie' => get_categorie($idCat),
        "messages" => get_messages_par_categorie($idCat),
        "utilisateur" => get_all_utilisateur(),
        "commentaires" => get_all_commentaire(),
        "reactions" => get_all_reaction()
        ]);
    }

    function afficher_page_publier($utilisateur){
        global $twig;
        echo $twig -> render('enfant-publier.twig.html',
         ['categories'=> get_all_categorie(),
         "utilisateur"=> $utilisateur]);
    }

    function publier_message($idCat, $idUser, $texte) { /* surment à mettre dans le routeur */
        insert_message_avec_image($idCat, $idUser, $texte);
    }

    function afficher_page_profil($utilisateur){
        global $twig;
        echo $twig -> render('enfant-profil.twig.html',
        ["utilisateur"=> $utilisateur]);
    }

    function afficher_page_parametre(){
        global $twig;
        echo $twig -> render('enfant-parametre.twig.html');
    }

    function afficher_page_modifier_biographie(){
        global $twig;
        echo $twig -> render('enfant-biographie.twig.html');
    }

    function update_bio($idUser, $biographie, $utilisateur){
        $success = update_biographie($idUser, $biographie);
        if ($success) {
            header('Location: http://localhost/SAE3012/profil' );
            reload_session_user($idUser);
            return afficher_page_profil($utilisateur);
        } else {
            echo "Erreur lors de la modification";
        }
    }

    function update_pseudo($idUser, $identifiant, $utilisateur){
        $success = update_identifiant($idUser, $identifiant);
        if ($success) {
            header('Location: http://localhost/SAE3012/profil' );
            reload_session_user($idUser);
            return afficher_page_profil($utilisateur);
        } else {
            $option = "Erreur de la modification";
            afficher_page_erreur($option);
        }
    }

    function afficher_page_modifier_identifiant(){
        global $twig;
        echo $twig -> render('enfant-identifiant.twig.html');
    }

    function afficher_page_deconnexion(){
        global $twig;
        header('Location: http://localhost/SAE3012' );
        echo $twig -> render('enfant-connexion-inscription.twig.html');
    }

    function afficher_page_erreur($option=null){
        global $twig;
        echo $twig -> render('enfant-erreur.twig.html', 
        ['option' => $option]);
    }

// insert_message('test', 1, 1, 'test de texte');
?>