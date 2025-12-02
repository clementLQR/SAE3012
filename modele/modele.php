<?php
    require 'connection.php';

    function get_all_utilisateur(){
        global $mysqli;
        $query = "SELECT * FROM utilisateur";
        $result = mysqli_query($mysqli, $query);
        $utilisateur = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $utilisateur;
    }

    /* connexion - inscription */

    function insert_utilisateur($identifiant, $mdp) {
        global $mysqli;
        // Vérifier si identifiant existe
        $queryCheck = "SELECT idUser FROM utilisateur WHERE identifiant = '$identifiant' LIMIT 1";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_fetch_assoc($resultCheck)) {
            return false; // L'identifiant existe déjà
        }
        // Insertion
        $query = "INSERT INTO utilisateur (identifiant, mdp) VALUES ('$identifiant', '$mdp')";
        $result = mysqli_query($mysqli, $query);
        
        if ($result) {
            return true; // succès
        } else {
            return false; // échec
        }
    }

    function connecte_utilisateur($identifiant, $mdp) {
        global $mysqli;

        $query = "SELECT * FROM utilisateur WHERE identifiant = '$identifiant' LIMIT 1";
        $result = mysqli_query($mysqli, $query);
        $utilisateur = mysqli_fetch_assoc($result);
        if (!$utilisateur) { // Utilisateur introuvable
            return false;
        }
        if ($utilisateur['mdp'] !== $mdp) { // Vérification du mot de passe (en clair dans ta BDD)
            return false;
        }
        $_SESSION['utilisateur'] = $utilisateur;// Connexion : on enregistre dans la session
        return true;
    }


    /* acceuil + categorie */

    function get_all_categorie(){
        global $mysqli;
        $query = "SELECT * FROM categorie";
        $result = mysqli_query($mysqli, $query);
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $categories;
    }

    function get_categorie($idCat) {
        global $mysqli;
        $result = mysqli_query($mysqli, "SELECT * FROM categorie WHERE idCat = $idCat");
        return mysqli_fetch_assoc($result);
    }

    function get_all_commentaire(){
        global $mysqli;
        $query = "SELECT * from commentaire";
        $result = mysqli_query($mysqli, $query);
        $commentaire = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $commentaire;
    }

    function get_all_reaction(){
        global $mysqli;
        $query = "SELECT * FROM reaction";
        $result = mysqli_query($mysqli, $query);
        $reaction = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $reaction;
    }

    function get_messages_par_categorie($idCat){
        global $mysqli;

        $query = "
            SELECT message.*, utilisateur.identifiant AS auteur
            FROM message
            JOIN utilisateur ON message.IdUser = utilisateur.IdUser
            WHERE message.IdCat = $idCat
            ORDER BY message.date DESC
        ";

        $result = mysqli_query($mysqli, $query);

        if (!$result) {
            die("Erreur SQL : " . mysqli_error($mysqli));
        }

        $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $messages;
    }


    /* publier */

    function insert_message_avec_image($idCat, $idUser, $texte) {
        global $mysqli;

        // Vérifier que le dossier existe
        $upload_dir = "images_upload";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Gestion de l'image
        $imageSrc = "";

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

            $imageName = time() . "_" . basename($_FILES['image']['name']);
            $imagePath = $upload_dir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $imageSrc = $imagePath;  // chemin sauvegardé en BDD
            } 
        }

        // Insertion SQL
        $query = "
            INSERT INTO message (date, texte, imageSrc, nbrLike, nbrDislike, nbrCom, IdCat, IdUser)
            VALUES (NOW(), '$texte', '$imageSrc', 0, 0, 0, $idCat, $idUser)
        ";

        $result = mysqli_query($mysqli, $query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /* paramètre */



?>


