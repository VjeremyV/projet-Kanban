<form action="" method="post" id="setUpdatePosition">
            <input type="hidden" value="" id="UpdatePosition" name="UpdatePosition">
            <input type="hidden" value="" id="idCatInputPosition" name="idCatInputPosition">
            <input type="hidden" value="" id="UpdateSiblingPosition" name="UpdateSiblingPosition">
            <input type="hidden" value="" id="idCatUpdateSiblingPosition" name="idCatUpdateSiblingPosition">
        </form>
<?php

if (isset($_POST['UpdatePosition']) && isset($_POST['idCatInputPosition']) && isset($_POST['UpdateSiblingPosition']) && isset($_POST['idCatUpdateSiblingPosition'])) {
    $UpdatePosition = htmlentities($_POST['UpdatePosition']);
    $idCatInputPosition = htmlentities($_POST['idCatInputPosition']);

    $UpdateSiblingPosition = htmlentities($_POST['UpdateSiblingPosition']);
    $idCatUpdateSiblingPosition = htmlentities($_POST['idCatUpdateSiblingPosition']);
    $stmt = $dbh->prepare('update categories set `ordre`=:ordre WHERE `id_categorie_categories`= :idCat');
    if ($stmt->execute(['ordre' => $UpdatePosition, 'idCat' => $idCatInputPosition])) {
        if (!$stmt->execute(['ordre' => $UpdateSiblingPosition, 'idCat' => $idCatUpdateSiblingPosition])) {
            echo '<p> un problème est survenu avec la synchronisation avec la base de données </p>';
        }
    } else {
        echo '<p> un problème est survenu avec la synchronisation avec la base de données </p>';
    }
}
