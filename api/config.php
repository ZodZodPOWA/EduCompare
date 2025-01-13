<?php
// config.php
$host = 'localhost';
$dbname = 'EduCompare';
$username = 'votre_username'; // Remplacez par votre utilisateur MySQL
$password = 'votre_modp';     // Remplacez par votre mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
