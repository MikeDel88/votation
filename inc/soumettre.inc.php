<?
require_once 'db-connect.inc.php';
require_once 'debug.inc.php';
require_once 'router.inc.php';

session_start();

if ($_SESSION['id']) {

    $propositionId = $_GET['id'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo $propositionId;

        $query = $db->prepare("UPDATE proposition SET soumis = 1 WHERE id = :id");
        $query->execute(array(
            ':id' => $propositionId,
        ));
        // $query->debugDumpParams();

        if ($query->errorCode() == '00000') {
            header("Location: $chemin/dashboard.php?soumission=ok");
        } else {
            header("Location: $chemin/modifier.php?retour='erreur'");
            // debug($query->errorInfo());
        }

    }

} else {
    accueilSansReponse();
}
