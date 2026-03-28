<?php

$host         = "127.0.0.1";
$username     = "vacancy";
$password     = "H!TME0n3mORET!M#977*";
$dbname       = "vacancy_test1";

try {
    $dbconn = new PDO('mysql:host=172.16.39.18;port=3306;dbname=vacancy_test1', $username, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
