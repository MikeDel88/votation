<?
require_once 'db-connect.inc.php';
require_once 'debug.inc.php';
require_once 'router.inc.php';

session_start();

if ($_SESSION['id']) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $titre = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $texte = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $propositionId = $_GET['id'] ?? '';

        if ($titre && $texte) {
            $query = $db->prepare("UPDATE proposition SET titre = :titre, description = :texte WHERE id = :id");
            $query->execute(array(
                ':titre' => $titre,
                ':texte' => $texte,
                ':id' => $propositionId,
            ));
            // $query->debugDumpParams();

            if ($query->errorCode() == '00000') {
                header("Location: $chemin/modifier.php?retour=modification ok&proposition=$propositionId");
            } else {
                header("Location: $chemin/modifier.php?retour='erreur'");
                // debug($query->errorInfo());
            }

        }
    }

} else {
    accueilSansReponse();
}
