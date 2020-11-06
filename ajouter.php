<?
session_start();

if ($_SESSION['id']) {

    require_once 'inc/db-connect.inc.php';
    require_once 'inc/debug.inc.php';
    require_once 'inc/head.inc.php';
    require_once 'inc/header.inc.php';
    require_once 'inc/router.inc.php';

    $reponse = 'Lorsque vous créez une proposition, vous votez forcement pour elle.';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $titre = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user = $_SESSION['id'];

        if ($titre && $text) {
            $query = $db->prepare("INSERT INTO proposition(users_id, titre, description) VALUES (:user, :titre, :texte)");
            $query->execute(array(
                ':user' => $user,
                ':titre' => $titre,
                ':texte' => $text,
            ));
            if ($query->errorCode() == '00000') {
                $reponse = 'ok';
                $id = $db->lastInsertId();

                // Ajout dans la table vote
                $query = $db->prepare("INSERT INTO votes(proposition_id, users_id) VALUES (:id, :user)");
                $query->execute(array(
                    ':id' => $id,
                    ':user' => $user,
                ));

            } else {
                $reponse = 'Une erreur est survenue, merci de réessayer';
            }
        }
    }

    ?>

    <main>
        <section class="container">
            <h2>Soumettre une proposition</h2>
                <div class="divider"></div>
                <div class="row">
                    <form method="POST" class="col s12">
                      <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">title</i>
                                <input id="title" type="text" class="validate" name="title" required>
                                <label for="title">Entrez le titre votre proposition</label>
                            </div>
                      </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">mode_edit</i>
                                <textarea id="proposition" class="materialize-textarea" name="text" required></textarea>
                                <label for="proposition">Entrez votre proposition</label>
                            </div>
                        </div>
                        <div class="row">

                            <?if ($reponse == 'ok') {?>

                                <div class="chip teal lighten-1 white-text">
                                    La proposition a bien été ajouté
                                    <i class="close material-icons">close</i>
                                </div>

                            <?} else {?>

                                <small><?=$reponse?></small>

                            <?}?>

                        </div>
                        <div class="row">
                            <button type="submit" class="waves-effect waves-light btn blue">Créer la proposition</button>
                        </div>
                        <div class="row">
                            <a href="dashboard.php">Retournez au dashboard</a>
                        </div>
                    </form>
                </div>
        </section>
    </main>

<?} else {
    accueilSansReponse();
}
