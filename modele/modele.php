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
        // Dossier des uploads
        $upload_dir = "images-upload/";
        // Création du dossier si absent
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $imageSrc = "";
        // Si une image est envoyée
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            // Nettoyage du nom du fichier
            $originalName = basename($_FILES['image']['name']);
            $originalName = str_replace(" ", "-", $originalName); // remplace les espaces
            $originalName = strtolower($originalName);
            // Création du nom final
            $timestamp = time();
            $newName = "$timestamp-$originalName";
            // Chemin complet pour sauvegarde
            $imagePath = $upload_dir . $newName;
            // Upload du fichier
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $imageSrc = $imagePath; // ce qui sera enregistré en BDD
            }
        }
        $query = "INSERT INTO message (date, texte, imageSrc, nbrLike, nbrDislike, nbrCom, IdCat, IdUser)
            VALUES (NOW(), '$texte', '$imageSrc', 0, 0, 0, $idCat, $idUser)";
        $result = mysqli_query($mysqli, $query);

        return $result ? true : false;
    }  

    /* paramètre */

    function update_biographie($idUser, $biographie){
        global $mysqli;
        $biographie = mysqli_real_escape_string($mysqli, $biographie);
        $query = "UPDATE utilisateur SET biographie = '$biographie' WHERE IdUser = $idUser";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            return true; // succès
        } else {
            return false; // échec
        }
    }

    function update_identifiant($idUser, $identifiant){
        global $mysqli;
        $queryCheck = "SELECT idUser FROM utilisateur WHERE identifiant = '$identifiant' LIMIT 1";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_fetch_assoc($resultCheck)) {
            return false; // L'identifiant existe déjà
        }
        $query = "UPDATE utilisateur SET identifiant = '$identifiant' WHERE IdUser = $idUser";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            return true; // succès
        } else {
            return false; // échec
        }
    }

    function reload_session_user($idUser){
        global $mysqli;

        $query = "SELECT * FROM utilisateur WHERE IdUser = $idUser LIMIT 1";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $utilisateur = mysqli_fetch_assoc($result);

            // Recharge les données de session
            $_SESSION['utilisateur'] = $utilisateur;

            return true;
        }
        return false;
    }

    // réaction


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

    function insert_reaction_like($messageId, $userId){
        global $mysqli;

        // Vérifie si l'utilisateur a déjà liké le message
        $queryCheck = "SELECT * FROM reaction WHERE IdMsg = $messageId AND IdUser = $userId AND IdType = 1 LIMIT 1";
        $resultCheck = mysqli_query($mysqli, $queryCheck);

        // Si oui, on supprime le like
        if (mysqli_fetch_assoc($resultCheck)) {
            $queryDelete = "DELETE FROM reaction WHERE IdMsg = $messageId AND IdUser = $userId AND IdType = 1";
            mysqli_query($mysqli, $queryDelete);
            $updateQuery = "UPDATE message SET nbrLike = nbrLike - 1 WHERE idMsg = $messageId";
            mysqli_query($mysqli, $updateQuery);
            return true; // succès
        }

        // Vérifie si l'utilisateur a déjà disliké le message
        $queryCheckDislike = "SELECT * FROM reaction WHERE IdMsg = $messageId AND IdUser = $userId AND IdType = 2 LIMIT 1";
        $resultCheckDislike = mysqli_query($mysqli, $queryCheckDislike);
        // Si oui, on supprime le dislike
        if (mysqli_fetch_assoc($resultCheckDislike)) {
            $queryDeleteDislike = "DELETE FROM reaction WHERE IdMsg = $messageId AND IdUser = $userId AND IdType = 2";
            mysqli_query($mysqli, $queryDeleteDislike);
            $updateQueryDislike = "UPDATE message SET nbrDislike = nbrDislike - 1 WHERE idMsg = $messageId";
            mysqli_query($mysqli, $updateQueryDislike);
        }

        // Insère le like
        $query = "INSERT INTO reaction (IdMsg, IdUser, IdType)
            VALUES ($messageId, $userId, 1)";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            // Met à jour le nombre de likes dans la table message
            $updateQuery = "UPDATE message SET nbrLike = nbrLike + 1 WHERE idMsg = $messageId";
            mysqli_query($mysqli, $updateQuery);

            return true; // succès
        } else {
            return false; // échec
        }
    }
    
    function insert_reaction_dislike($messageId, $userId){
        global $mysqli;
        // Vérifie si l'utilisateur a déjà disliké le message
        $queryCheck = "SELECT * FROM reaction WHERE IdMsg = $messageId AND IdUser = $userId AND IdType = 2 LIMIT 1";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        // Si oui, on supprime le dislike
        if (mysqli_fetch_assoc($resultCheck)) {
            $queryDelete = "DELETE FROM reaction WHERE IdMsg = $messageId AND IdUser = $userId AND IdType = 2";
            mysqli_query($mysqli, $queryDelete);
            $updateQuery = "UPDATE message SET nbrDislike = nbrDislike - 1 WHERE idMsg = $messageId";
            mysqli_query($mysqli, $updateQuery);
            return true; // succès
        }
        // Vérifie si l'utilisateur a déjà liké le message
        $queryCheckLike = "SELECT * FROM reaction WHERE IdMsg = $messageId AND IdUser = $userId AND IdType = 1 LIMIT 1";
        $resultCheckLike = mysqli_query($mysqli, $queryCheckLike);
        // Si oui, on supprime le like
        if (mysqli_fetch_assoc($resultCheckLike)) {
            $queryDeleteLike = "DELETE FROM reaction WHERE IdMsg = $messageId AND IdUser = $userId AND IdType = 1";
            mysqli_query($mysqli, $queryDeleteLike);
            $updateQueryLike = "UPDATE message SET nbrLike = nbrLike - 1 WHERE idMsg = $messageId";
            mysqli_query($mysqli, $updateQueryLike);
        }
        // Insère le dislike
        $query = "INSERT INTO reaction (IdMsg, IdUser, IdType)
            VALUES ($messageId, $userId, 2)";
        $result = mysqli_query($mysqli, $query);
        if ($result) {
            // Met à jour le nombre de dislikes dans la table message
            $updateQuery = "UPDATE message SET nbrDislike = nbrDislike + 1 WHERE idMsg = $messageId";
            mysqli_query($mysqli, $updateQuery);
            return true; // succès
        } else {
            return false; // échec
        }
    }
    
?>


