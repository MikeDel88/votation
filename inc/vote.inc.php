<?
session_start();

if ($_SESSION['id']) {

    require 'db-connect.inc.php';
    require 'debug.inc.php';
    require 'head.inc.php';
    require_once 'router.inc.php';
    require 'requetes.inc.php';

    $propositionId = $_GET['proposition'] ?? '';
    $vote = $_GET['vote'] ?? '';
    $userId = $_SESSION['id'];

    if ($vote && $propositionId) {
        if ($vote == 'oui') {
            vote('vote_pour', $propositionId);
        } elseif ($vote == 'non') {
            vote('vote_contre', $propositionId);
        } else {
            dashboard($chemin);
        }
        ajoutVote($propositionId, $userId);
        header('Location: ../dashboard.php?vote=ok');

    } else {
        dashboard($chemin);
    }

} else {
    accueilSansReponse();
}
