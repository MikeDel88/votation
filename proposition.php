<?
session_start();

if ($_SESSION['id']) {

    require 'inc/db-connect.inc.php';
    require 'inc/debug.inc.php';
    require 'inc/head.inc.php';
    require_once 'inc/header.inc.php';
    require_once 'inc/router.inc.php';
    require_once 'inc/requetes.inc.php';

    $propositionId = $_GET['proposition'] ?? '';

    // Récupérer les infos sur la proposition
    $query = $db->prepare("SELECT * FROM proposition WHERE id = :id");
    $query->execute(array(
        ':id' => $propositionId,
    ));
    $proposition = $query->fetch();

    // Récupérer les commentaires
    $query = $db->prepare("SELECT commentaire.commentaire, DATE_FORMAT(commentaire.date_commentaire, 'Message du : %d/%m/%Y à %H:%i:%s') AS date, users.pseudo FROM commentaire, users WHERE commentaire.proposition_id = :id AND commentaire.users_id = users.id ORDER BY commentaire.date_commentaire DESC LIMIT 5");
    $query->execute(array(
        ':id' => $propositionId,
    ));
    $commentaires = $query->fetchAll();

    ?>

    <main>
        <section id="proposition" class="container">
            <h2>Proposition n° <?=$propositionId?></h2>
            <div class="divider"></div>
            <div class="row section">
                <div class="col s12 right-align">
                    <a href="dashboard.php">Retournez au tableau de bord</a>
                </div>
            </div>
            <div class="row section">
                <div class="col s12 center-align">
                    <h3 class="blue-text"><?=$proposition->titre?></h3>
                    <p><i class="material-icons prefix">format_quote</i><?=$proposition->description?></p>
                    <div class="divider container"></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Votes :</h4>
                    <ul class="collapsible">
                        <li>
                          <div class="collapsible-header">
                            <i class="material-icons green-text">thumb_up</i>
                            Pour
                            <span class="badge"><?=$proposition->vote_pour?></span></div>
                        </li>
                        <li>
                          <div class="collapsible-header">
                            <i class="material-icons red-text">thumb_down</i>
                            Contre
                            <span class="badge"><?=$proposition->vote_contre?></span></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">

                    <?if (dejaVote($propositionId, $_SESSION['id'])) {?>

                        <p class="red-text">Vous avez déjà voté !</p>

                   <?} else {?>
                        <a href="inc/vote.inc.php?vote=oui&proposition=<?=$propositionId?>" class="btn blue">Voter Oui</a>
                        <a href="inc/vote.inc.php?vote=non&proposition=<?=$propositionId?>" class="btn red">Voter Non</a>
                    <?}?>

                </div>

        </section>
        <div class="divider container"></div>
        <section id="add_commentaire" class="container">
            <h5>Ajouter un commentaire</h5>
            <div class="row">
                <form method="POST" class="col s12" action="inc/commentaire.inc.php?proposition=<?=$propositionId?>">
                  <div class="row">
                    <div class="input-field col s12">
                      <textarea id="commentaire" class="materialize-textarea" name="commentaire"></textarea>
                      <label for="commentaire">Votre commentaire</label>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn blue">Publier</button>
                    </div>
                  </div>
                </form>
            </div>
        </section>
        <div class="divider container"></div>
        <section id="commentaires" class="container">
                <h5>Liste des commentaires</h5>
                <?=(empty($commentaires)) ? '<p>Aucun commentaire' : '';?>
                <?foreach ($commentaires as $commentaire) {?>
                    <div class="row section">
                        <div class="col s12 m5">
                          <div class="card-panel z-depth-4">
                            <h6 class="blue-text"><strong><?=$commentaire->pseudo?></strong></h6>
                            <p class=""><em><?=$commentaire->date?></em></p>
                            <div class="divider"></div>
                            <p class=""><?=$commentaire->commentaire?></p>
                          </div>
                        </div>
                    </div>
                <?}?>

        </section>
    </main>

<?} else {
    accueilSansReponse();
}