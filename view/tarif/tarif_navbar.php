<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href=""><img src="media/logo.png" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    Gestion Tarif
                </li>
            </ul>
        </div>
        <?php
            if (isset($_GET['crud'])) {
                echo'<a class="btn btn-primary" href="index.php?action=T" role="button">Retour</a>';
            } else {
                echo '<a class="btn btn-primary" href="index.php?action=AD" role="button">Retour</a>';
            }
        ?>
    </div>
</nav>