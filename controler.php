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
            return afficher_page_accueil();
        } else {
            echo "Erreur lors de l'insertion";
        }
    }

    function connexion_utilisateur($identifiant, $mdp){
        $success = connecte_utilisateur($identifiant, $mdp);
        if ($success) {
            return afficher_page_accueil();
        } else {
            echo "Erreur lors de l'insertion";
        }
    }

    function afficher_page_accueil(){
        global $twig;
        $categories = get_all_categorie();
        echo $twig->render('enfant-accueil.twig.html', ['categories' => $categories]);
    } 
    
    function afficher_page_categorie($idCat){
        global $twig;
        echo $twig -> render('enfant-categorie.twig.html', ['categorie' => get_categorie($idCat),
        "messages" => get_messages_par_categorie($idCat),
        "utilisateur" => get_all_utilisateur(),
        "commentaires" => get_all_commentaire(),
        "reactions" => get_all_reaction()
        ]);
    }




?>