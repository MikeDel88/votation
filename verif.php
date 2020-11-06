<?
require_once 'inc/db-connect.inc.php';
require_once 'inc/router.inc.php';

$query = $db->prepare("SELECT id, password FROM users WHERE id = :id AND password = :password");
$query->execute(array(
    ':id' => $_GET['id'],
    ':password' => $_GET['confirm'],
));
$user = $query->fetch();

if ($query->rowCount() == 1) {
    if ($user->id == $_GET['id'] && $user->password == $_GET['confirm']) {
        $query = $db->query("UPDATE users SET actif = 1 WHERE id = $user->id");
        header('Location: index.php?reponse=compteConfirm');
    }
} else {
    header('Location: index.php?reponse=error');

}
