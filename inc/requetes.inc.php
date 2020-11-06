<?
// Fonction pour vérifier si l'utilisateur en cours a déjà voté pour une proposition en cours de soumission
function dejaVote($propositionId, $userId)
{
    global $db;
    $query = $db->prepare("SELECT * FROM votes WHERE proposition_id = :id AND users_id = :user");
    $query->execute(array(
        ':id' => $propositionId,
        'user' => $userId,
    ));
    $vote = $query->fetch();
    if ($query->rowCount() == 1) {
        return true;
    } else {
        return false;
    }
}
function ajoutVote($propositionId, $userId)
{
    global $db;
    $query = $db->prepare("INSERT INTO votes(proposition_id, users_id) VALUES (:proposition, :user)");
    $query->execute(array(
        ':proposition' => $propositionId,
        ':user' => $userId,
    ));
}
function vote($vote, $propositionId)
{
    global $db;
    $query = $db->prepare("UPDATE proposition SET $vote = $vote + 1 WHERE id = :id");
    $query->execute(array(
        ':id' => $propositionId,
    ));

}
