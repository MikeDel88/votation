<?
session_start();

if ($_SESSION['id']) {

    require 'db-connect.inc.php';
    require 'debug.inc.php';
    require 'head.inc.php';
    require_once 'router.inc.php';

    $propositionId = $_GET['proposition'] ?? '';
    $userId = $_SESSION['id'];
    $commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($propositionId != '' && $commentaire) {
            $query = $db->prepare("INSERT INTO commentaire(proposition_id, users_id, commentaire) VALUES (:id, :user, :commentaire)");
            $query->execute(array(
                ':id' => $propositionId,
                ':user' => $userId,
                ':commentaire' => $commentaire,
            ));

            if ($query->errorCode() == '00000') {
                header("Location: $chemin/proposition.php?proposition=$propositionId#commentaires");
            } else {
                header("Location: $chemin/proposition.php?retour='erreur'");
                // debug($query->errorInfo());
            }
        }
    }

} else {
    accueilSansReponse();
}
