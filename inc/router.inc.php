<?
function accueilAvecWarning($chemin, $reponse)
{
    header("Location: $chemin/index.php?reponse=$reponse");

}
function dashboard($chemin)
{
    header("Location: $chemin/dashboard.php");

}
function accueilSansReponse()
{
    header('Location: index.php');

}
function accueilAvecError($chemin, $info)
{
    header("Location: $chemin/index.php?reponse=$info");

}
