<?
session_start();

if ($_SESSION['id']) {

    require 'inc/db-connect.inc.php';
    require 'inc/debug.inc.php';
    require 'inc/head.inc.php';
    require_once 'inc/header.inc.php';
    require_once 'inc/router.inc.php';

    $propositionId = $_GET['proposition'] ?? '';
    $reponse = $_GET['retour'] ?? '';

    // Récupérer la proposition à modifier
    $query = $db->prepare("SELECT * FROM proposition WHERE id = :id");
    $query->execute(array(
        ':id' => $propositionId,
    ));
    $proposition = $query->fetch();
    $titre = $proposition->titre ?? '';
    $texte = $proposition->description ?? '';
    ?>

    <main>
        <section class="container">
            <h2>Modifier une proposition</h2>
            <div class="row">
                    <form method="POST" class="col s12" action="inc/modif.inc.php?id=<?=$propositionId?>">
                      <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">title</i>
                                <input id="title" type="text" class="validate" name="title" required>
                                <label for="title"><?=$titre?></label>
                            </div>
                      </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">mode_edit</i>
                                <textarea id="proposition" class="materialize-textarea" name="text" required></textarea>
                                <label for="proposition"><?=$texte?></label>
                            </div>
                        </div>
                        <div class="row">
                            <small><?=$reponse?></small>
                        </div>
                        <div class="row">
                            <button type="submit" class="waves-effect waves-light btn blue">Modifier la proposition</button>
                        </div>
                        <div class="row">
                            <a href="dashboard.php">Retournez au dashboard</a>
                        </div>
                    </form>
                    <form method="POST" class="col s12" action="inc/soumettre.inc.php?id=<?=$propositionId?>">
                        <div class="row">
                            <button type="submit" class="waves-effect waves-light btn yellow darken-2">Soumettre la proposition</button>
                        </div>
                    </form>
                </div>
        </section>
    </main>

<?} else {
    accueilSansReponse();
}
