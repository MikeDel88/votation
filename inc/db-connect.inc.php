<?
require 'env.inc.php';

try {
    $db = new PDO("mysql:host=$host;dbname=$dataname;charset=UTF8", $login, $password);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo 'Erreurs :' . $e->getMessage() . '<br>';
}
