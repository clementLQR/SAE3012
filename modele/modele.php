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

    function connecte_utilisateur($identifiant, $mdp){
        global $mysqli;
        $query = "SELECT * FROM utilisateur WHERE identifiant = '$identifiant' AND mdp = '$mdp'";
        $result = mysqli_query($mysqli, $query);
        if ($result){
            return true; // connexion réussie
        } else {
            return false; // échec de la connexion
        }

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

    function insert_message($imageSrc, $idCat, $idUser, $texte){
        global $mysqli;
        $query = "INSERT INTO message(date, texte, imageSrc, nbrLike, nbrDislike, nbrCom, IdCat, IdUser) VALUES (NOW(), '$texte', '$imageSrc', 0, 0, 0, $idCat, $idUser)";
        $result = mysqli_query($mysqli, $query);
        
        if ($result) {
            return true; // succès
        } else {
            return false; // échec
        }
    }




?>


