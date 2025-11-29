<?php
require 'connection.php';

function get_all_categorie(){
    global $mysqli;
    $query = "Select * from categorie";
    $result = mysqli_query($mysqli, $query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $categories;
}
?>