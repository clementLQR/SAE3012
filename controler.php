<?php
    require_once 'modele/modele.php';
    require_once __DIR__.'/bootstrap.php';

    function afficher_page_connexion_inscription(){
        global $twig;
        echo $twig->render('enfant-connexion-inscription.twig.html');
    }

    function inscription_utilisateur($identifiant, $mdp){
        global $twig;
        $success = insert_utilisateur($identifiant, $mdp);
        if ($success) {
            connecte_utilisateur($identifiant, $mdp);
            return afficher_page_accueil();
        } else {
            echo $twig->render("enfant-erreur-inscription.twig.html");
        }
    }

    function connexion_utilisateur($identifiant, $mdp){
        global $twig;
        $success = connecte_utilisateur($identifiant, $mdp);
        if ($success) {
            echo $twig->render("enfant-connexion-reussit.twig.html");
        } else {
            echo $twig->render("enfant-erreur-connexion.twig.html");
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

    function afficher_page_publier(){
        global $twig;
        echo $twig -> render('enfant-publier.twig.html',
         ['categories'=> get_all_categorie(),
         "utilisateurs"=> $_SESSION['IdUser'] ?? null]);
    }

    function publier_message($idCat, $idUser, $texte) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $ok = insert_message_avec_image($idCat, $idUser, $texte);

            if ($ok) {
                header("Location: /categorie/$idCat");
                exit;
            } else {
                echo "Erreur lors de l'envoi du message.";
            }
        }
    }

    function afficher_page_profil(){
        global $twig;
        echo $twig -> render('enfant-profil.twig.html');
    }

    function afficher_page_parametre(){
        global $twig;
        echo $twig -> render('enfant-parametre.twig.html');
    }

    function afficher_page_deconnexion(){
        global $twig;
        echo $twig -> render('enfant-connexion-inscription.twig.html');
    }

    function afficher_page_erreur(){
        global $twig;
        echo $twig -> render('enfant-erreur.twig.html');
    }

// insert_message('test', 1, 1, 'test de texte');
?>