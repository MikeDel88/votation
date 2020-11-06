<?
require_once 'inc/db-connect.inc.php';
require_once 'inc/debug.inc.php';
require_once 'inc/head.inc.php';
require_once 'inc/router.inc.php';

$reponse = $_GET['reponse'] ?? '';

$msg = [
    'errorWrong' => 'le mot de passe est incorrect ou le compte inactif',
    'errorNotFound' => 'aucun utilisateur trouvé !',
    'errorValidation' => 'merci de renseigner un utilisateur ou mot de passe valide',
    'error' => 'Une erreur est survenue',
    'propositionOk' => 'La proposition a bien été soumise',
    'compteConfirm' => 'Votre compte a bien été enregistré ! Vous pouvez vous connecter.',
    'userExist' => 'Ce pseudo ou ce mail est déjà pris',
    'mailSend' => 'Un mail vient de vous êtes envoyé !',
    'logout' => 'Déconnexion réussie',
]

?>


<header>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h1 class="center-align blue-text lighten-1">Démocratie 2.0</h1>
                <h2 class="center-align cyan-text darken-1">TP pour travailler la PDO en PHP</h2>
            </div>
        </div>
    </div>
</header>
<main>
    <section class="container">
        <article class="row">
            <form class="col s12 m6" method="POST" action="inc/connect.inc.php">
                <h3 class="col s12 blue-text heading h5">Connexion</h3>
                <div class="row">
                    <div class="input-field col s12 m9">
                        <i class="material-icons prefix blue-text">account_circle</i>
                        <input id="utilisateur" type="text" class="validate" name="user">
                        <label for="utilisateur">Utilisateur</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m9">
                    <i class="material-icons prefix blue-text">https</i>
                        <input id="password" type="password" class="validate" name="password">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row">
                <button type="submit" class="col waves-effect waves-light btn blue lighten-1"><i class="material-icons left">send</i>Se connecter</button>
                </div>
                <div>
                <!-- Message d'erreur en cas de mauvaise connexion ou champs vides -->
                    <?if (array_key_exists($reponse, $msg)) {?>
                        <div class="chip teal lighten-1 white-text">
                            <?=$msg[$reponse]?>
                            <i class="close material-icons">close</i>
                        </div>
                    <?}?>
                </div>
            </form>
            <aside class="col s12 m6">
                <div>
                    <img src="img/img-vote.jpg" class="responsive-img" alt="image de vote">
                </div>
                <div class="center-align">
                    <!-- Modal Trigger -->
                     <a class="waves-effect waves-light btn modal-trigger blue" href="#inscription">Pas encore inscrit ?</a>
                    <!-- Modal Structure -->
                    <form method="POST" id="inscription" class="modal modal-fixed-footer" action="inc/mail.inc.php">
                        <div class="modal-content">
                            <h4 class="blue-text">Inscription</h4>
                            <div class="input-field col s12">
                                <i class="material-icons prefix blue-text">email</i>
                                <input id="email_inline" type="email" class="validate" name="email">
                                <label for="email_inline">Email</label>
                                <span class="helper-text" data-error="saisir un mail valide" data-success="mail ok"></span>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix blue-text">account_circle</i>
                                <input id="icon_prefix" type="text" class="validate" name="pseudo">
                                <label for="icon_prefix">pseudo</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix blue-text">https</i>
                                <input id="password" type="password" class="validate" name="password">
                                <label for="password">Password</label>
                            </div>
                            <p class="col s12">Validation par confirmation d'email</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="modal-close waves-effect waves btn blue white-text z-depth-3">Envoyer</button>
                        </div>
                    </form>
                </div>
            </aside>
        </article>
    </section>
</main>

<?require 'inc/footer.inc.php';
