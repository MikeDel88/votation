<?
session_start();

if ($_SESSION['id']) {

    require 'inc/db-connect.inc.php';
    require 'inc/debug.inc.php';
    require 'inc/head.inc.php';
    require_once 'inc/router.inc.php';
    require 'inc/requetes.inc.php';

    $id = $_SESSION['id'];
    $pseudo = $_SESSION['pseudo'];
    $email = $_SESSION['email'];
    $reponse = $_GET['soumission'] ?? '';
    $vote = $_GET['vote'] ?? '';

    // Comptage du nombre de propositions utilisateur
    $query = $db->query("SELECT COUNT(id) AS nombre FROM proposition WHERE users_id = $id");
    $nombrePropositions = $query->fetch();

    // Tableau des propositions utilisateurs
    $query = $db->prepare("SELECT * FROM proposition WHERE users_id = :id");
    $query->execute(array(
        ':id' => $id,
    ));
    $propositions = $query->fetchAll();

    // Tableau propositions soumises au vote
    $query = $db->query("SELECT proposition.id, users.pseudo, proposition.titre, proposition.description, proposition.vote_pour, proposition.vote_contre FROM proposition, users WHERE proposition.soumis = 1 AND proposition.users_id = users.id");
    $propositionsSoumises = $query->fetchAll();

    require_once 'inc/header.inc.php';
    ?>
  <main>
    <section class="container">
      <h2>Vos Propositions</h2>
      <h5>Nombre de proposition : <?=$nombrePropositions->nombre?></h5>
      <table class="responsive-table">
           <thead>
          <tr>
              <th>#</th>
              <th>Titre</th>
              <th>Soumis au vote</th>
              <th>Pour</th>
              <th>Contre</th>
              <th>Modifier</th>
              <th>Supprimer</th>
          </tr>
        </thead>
        <tbody>

            <?foreach ($propositions as $proposition) {?>

              <tr>
                <td><strong><?=$proposition->id?></strong></td>
                <td><?=$proposition->titre?></td>
                <td><?=($proposition->soumis == '0') ? '<span class="red-text">non</span>' : '<span class="green-text">oui</span>'?></td>
                <td><?=$proposition->vote_pour?></td>
                <td><?=$proposition->vote_contre?></td>
                <td><?=($proposition->soumis == '0') ? "<a href='modifier.php?proposition=$proposition->id' class='btn blue'>Modifier</a>" : ''?></td>
                <td><?=($proposition->soumis == '0') ? "<a href='inc/supprimer.inc.php?proposition=$proposition->id' class='btn red'>Supprimer</a>" : ''?></td>
              </tr>

            <?}?>

        </tbody>
      </table>
      <div class="row section">
          <a href="ajouter.php" class="col btn teal lighten-2">Ajouter une proposition</a>
      </div>
      <?if ($reponse == 'ok') {?>
          <div class="chip teal lighten-1 white-text">
              La proposition a bien été soumise
              <i class="close material-icons">close</i>
          </div>
      <?}?>
    </section>
    <section class="container">
      <h2>Propositions sousmis au vote</h2>
      <table class="responsive-table">
           <thead>
          <tr>
              <th>#</th>
              <th>Utilisateur</th>
              <th>Titre</th>
              <th>Déjà voté</th>
              <th>Pour</th>
              <th>Contre</th>
              <th>Voir</th>
          </tr>
        </thead>
        <tbody>

            <?foreach ($propositionsSoumises as $proposition) {?>

              <tr>
                <td><strong><?=$proposition->id?></strong></td>
                <td><strong><?=$proposition->pseudo?><strong></td>
                <td><?=$proposition->titre?></td>
                <td><?=(dejaVote($proposition->id, $id) == true) ? 'oui' : ''?></td>
                <td><?=$proposition->vote_pour?></td>
                <td><?=$proposition->vote_contre?></td>
                <td><a href="proposition.php?proposition=<?=$proposition->id?>" class="btn teal lighten-2">Voir</a></td>
              </tr>

            <?}?>

        </tbody>
      </table>

      <?if ($vote == 'ok') {?>
      <div class="row section">
          <div class="chip teal lighten-1 white-text">
            Votre vote a bien été enregistré !
            <i class="close material-icons">close</i>
          </div>
      </div>
      <?}?>

    </section>
  </main>
<?} else {
    accueilSansReponse();
}
