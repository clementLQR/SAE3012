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

        $mdp = password_hash($mdp, PASSWORD_DEFAULT);

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
        if (!password_verify($mdp, $utilisateur['mdp'])) { // Vérification du mot de passe (en clair dans ta BDD)
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

    function get_messages_par_categorie_trier_par_date($idCat){
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

    function get_messages_par_categorie_trier_par_like($idCat){
        global $mysqli;
        /* Récupère les messages d'une catégorie triés par nombre de likes */
        $query = "
            SELECT message.*, utilisateur.identifiant AS auteur
            FROM message
            JOIN utilisateur ON message.IdUser = utilisateur.IdUser
            WHERE message.IdCat = $idCat
            ORDER BY message.nbrLike DESC
        ";
        $result = mysqli_query($mysqli, $query);
        if (!$result) {
            die("Erreur SQL : " . mysqli_error($mysqli));
        }
        $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $messages;
    }

    function get_messages_par_utilisateur($idUser){
        global $mysqli;
        /* Récupère les messages d'un utilisateur */
        $query = "
            SELECT message.*, categorie.nom AS categorieNom
            FROM message
            JOIN categorie ON message.IdCat = categorie.idCat
            WHERE message.IdUser = $idUser
            ORDER BY message.date DESC
        ";
        $result = mysqli_query($mysqli, $query);
        if (!$result) {
            die("Erreur SQL : " . mysqli_error($mysqli));
        }
        $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $messages;
    }

    function get_messages_par_id($messageId){
        global $mysqli;
        /* Récupère un message par son ID */
        $query = "
            SELECT message.*, utilisateur.identifiant AS auteur
            FROM message
            JOIN utilisateur ON message.IdUser = utilisateur.IdUser
            WHERE message.idMsg = $messageId
        ";
        $result = mysqli_query($mysqli, $query);

        if (!$result) {
            die("Erreur SQL : " . mysqli_error($mysqli));
        }
        $message = mysqli_fetch_assoc($result);
        return $message;
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

        if ($result) {
            return true; // succès
        } else {
            return false; // échec
        }
    }  

    /* Supprimer message */

    function delete_message($messageId){
        global $mysqli;
        /* Supprime un message par son ID */
        $queryReactions = "DELETE FROM reaction WHERE IdMsg = $messageId";
        mysqli_query($mysqli, $queryReactions);
        /* Supprime les commentaires associés */
        $queryCommentaires = "DELETE FROM commentaire WHERE IdMsg = $messageId";
        mysqli_query($mysqli, $queryCommentaires);
        /* Supprime le message */
        $query = "DELETE FROM message WHERE idMsg = $messageId";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            return true; // succès
        } else {
            return false; // échec
        }
    }


    /* paramètre */

    function update_biographie($idUser, $biographie){
        global $mysqli;
        /*  Met à jour la biographie d'un utilisateur */
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
        /*  Met à jour l'identifiant d'un utilisateur */
        $queryCheck = "SELECT idUser FROM utilisateur WHERE identifiant = '$identifiant' LIMIT 1";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_fetch_assoc($resultCheck)) {
            return false; // L'identifiant existe déjà
        }
        /* Met à jour l'identifiant */
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
        /* Recharge les données de l'utilisateur dans la session */
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


    function get_all_commentaire_par_message($messageId){
        global $mysqli;
        /* Récupère tous les commentaires d'un message */
        $query = 'SELECT *,utilisateur.identifiant AS auteur
        FROM commentaire INNER JOIN utilisateur 
        ON commentaire.IdUser = utilisateur.IdUser WHERE IdMsg = $messageId
        ORDER BY dateCom ASC';
        $result = mysqli_query($mysqli, $query);
        $commentaire = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $commentaire;
    }

    function get_all_reaction(){
        global $mysqli;
        /* Récupère toutes les réactions */
        $query = "SELECT * FROM reaction";
        $result = mysqli_query($mysqli, $query);
        $reaction = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $reaction;
    }

    function insert_commentaire($idMsg, $idUser, $texte) {
        global $mysqli;
        /* Insère un commentaire */
        $query = "INSERT INTO commentaire (texte, dateCom, IdMsg, IdUser)
            VALUES ('$texte', NOW(), $idMsg, $idUser)";
        $result = mysqli_query($mysqli, $query);
        if ($result) {
            // Met à jour le nombre de commentaires dans la table message
            $updateQuery = "UPDATE message SET nbrCom = nbrCom + 1 WHERE idMsg = $idMsg";
            mysqli_query($mysqli, $updateQuery);
            return true; // succès
        } else {
            return false; // échec
        }
        
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


