<?
require 'db-connect.inc.php';
require_once 'router.inc.php';

// Si envoi du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Filtre des inputs en htmlspecialchars
    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Si l'utilisateur et le mdp est renseigné
    if ($user && $password) {

        // Interrogation de la BDD ou l'utilisateur est renseigné
        $query = $db->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
        $query->execute(array(
            ':pseudo' => $user,
        ));
        $user = $query->fetch();

        // Si le nombre de ligne est égal à 1, j'enregistre la session
        if ($query->rowCount() == 1) {

            // Si le mot de passe correspond
            if (password_verify($password, $user->password) && $user->actif == true) {

                session_start();
                $_SESSION['id'] = $user->id;
                $_SESSION['email'] = $user->email;
                $_SESSION['pseudo'] = $user->pseudo;

                // Redirection vers le dashboard
                dashboard($chemin);

            } else {
                $reponse = 'errorWrong';
                accueilAvecWarning($chemin, $reponse);

            }

        } else {
            $reponse = 'errorNotFound';
            accueilAvecWarning($chemin, $reponse);

        }

    } else {
        $reponse = "errorValidation";
        accueilAvecWarning($chemin, $reponse);

    }

}
