<?php
    require 'connection.php';

    function get_all_utilisateur(){
        global $mysqli;
        $query = "Select * from utilisateur";
        $result = mysqli_query($mysqli, $query);
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $users;
    }

    function insert_utilisateur($identifiant, $mdp) {
        global $mysqli;
        $query = "INSERT INTO utilisateur (identifiant , mdp) VALUES ('$identifiant','$mdp')";
        $identifiantExiste = get_all_utilisateur();
        foreach($identifiantExiste as $utilisateur){
            print_r($utilisateur);
            if($utilisateur[1] === $identifiant){
                return false; // L'utilisateur existe déjà
            }
        }
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


    // function get_all_categorie(){
    //     global $mysqli;
    //     $query = "Select * from categorie";
    //     $result = mysqli_query($mysqli, $query);
    //     $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //     return $categories;
    // }
?>