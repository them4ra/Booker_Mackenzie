<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=DBNAME', 'DBUSER', 'DBPASSWORD');
} catch (PDOException $e) {
	exit('Database error.');
}

?>
