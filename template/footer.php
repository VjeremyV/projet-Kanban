</main>
<footer>
    © 2022 - Projet Kanban - Réalisé par : Farah, Charles, Christopher, Jérémy, Mika - <a href="https://github.com/VjeremyV/projet-Kanban">GitHub</a>
</footer>
<?php if (isset($_GET['creation']) && $_GET['creation'] == "0"): ?>
    <script src="./../script/createprojet.js"></script>
    <?php endif ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<script src="../script/drag-drop.js"></script>

</html>