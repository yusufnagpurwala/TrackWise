<?php 

$db = new mysqli('localhost:3307', 'root', '', 'track_wise');

if($db->connect_error) {
    die("Connection Failed: ". $db->connect_error);
}

?>