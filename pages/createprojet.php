<?php
session_start();
include_once(__DIR__ . '/../template/head.php');
include_once(__DIR__ . '/../template/header.php');
if (isset($_SESSION['id'])) {
    var_dump($_SESSION['id']);
?>

    <form action="formulaire.php" method="post">

        <label for="nomProjet">Nom du projet : </label>
        <input type="text" id="nomProjet" name="nomProjet">

        <label for="description">Description: </label>
        <textarea id="description" name="description"></textarea>

        <label for="nbCategorie">nombre de Categories: </label>
        <input type="text" id="nbCategorie" name="nbCategorie" value="1">

        <div id="containerCategorie">
            <label for="nomCategorie">Nom de la categorie : </label>
            <input type="text" id="nomCategorie" name="nomCategorie">
        </div>

        <input type="submit" name="submit" value="creer">

    </form>

<?php
    include_once(__DIR__ . '/../template/footer.php');
} else {
    header('location: ./../');
}
?>