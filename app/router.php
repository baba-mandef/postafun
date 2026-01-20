<?php 
$route = $_SERVER["REQUEST_URI"];

$route = explode("?", $route)[0];

if($route === "/"){
    require_once "app/views/home.php";
}
elseif($route === "/inscription"){
    require_once "app/views/inscription.php";
}
elseif($route === "/connexion"){
    require_once "app/views/connexion.php";
}
else{
    echo "404 Vous etes perdu :(";
}
?>
