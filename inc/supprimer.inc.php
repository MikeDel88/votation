<?

session_start();

if ($_SESSION['id']) {

    require 'db-connect.inc.php';
    require 'debug.inc.php';
    require 'head.inc.php';
    require_once 'router.inc.php';

    $propositionId = $_GET['proposition'] ?? '';

    function delete($propositionId, $table, $champ)
    {
        global $db;
        $query = $db->prepare("DELETE FROM $table WHERE $champ = :id");
        $query->execute(array(
            ':id' => $propositionId,
        ));

    }

    if ($propositionId != '') {

        delete($propositionId, 'votes', 'proposition_id');
        delete($propositionId, 'commentaire', 'proposition_id');
        delete($propositionId, 'proposition', 'id');

        dashboard($chemin);

    } else {
        dashboard($chemin);
    }

} else {
    dashboard($chemin);

}
