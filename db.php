<?php
// Configuración de la base de datos
$host = "sql209.infinityfree.com";
$dbname = "if0_37779120_libreria";
$username = "if0_37779120";
$password = "JADR012305";
$port = 3306;

try {
    
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);


    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
