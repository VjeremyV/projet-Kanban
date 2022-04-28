


<h2>Vos <?php if (isset($_GET['terminer_projet'])) {
            echo "Projets terminés :";
        } else {
            echo "Projets en cours :";
        } ?></h2>

    <?php
    try {

        $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
        if (!$projets = $dbh->query('select nom_projet, date_creation_projet, description_projet from projet', $fetchMode = PDO::FETCH_NAMED)->fetchall()) {
            echo "<p>Il y a eu une erreur lors de la connexion avec la base de donnée.</p>";
        } else {
            foreach ($projets as $projet) {
    ?>
                <div>
                    <span><?= $projet['nom_projet'] ?></span>
                    <span><?= $projet['date_creation_projet'] ?></span>
                    <span><?= $projet['description_projet'] ?></span>
                </div>

    <?php
            }
            if (isset($_GET['terminer_projet'])) {
            }
        }
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

    ?>
