<?php
    if (isset($_POST['msg'])) {
        switch (true) {
            case $_POST['msg'] == 1:
                $msg = "Image invalide";
                $typeMsg = 'danger';
                break;
        }
        echo '
        <div class="alert alert-'.$typeMsg.' alert-dismissible fade show m-1" role="alert">
            '.$msg.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
    }
?>
<div class="container  mt-3">
    <div class='bloc ' id='coursdesurf'>
        <h2>Création d'un equipier</h2>
        <form action="index.php?action=E&crud=c&ce=<?php  echo $codeEq  ?>" enctype='multipart/form-data' method="post">
            <div class="form-group">
                <label for="codeEquipier">Code Equipier</label>
                <input type="text" class="form-control" id="codeEq" value='<?php  echo $codeEq  ?>' readonly>
            </div>
            <div class="form-group">
                <label for="surnom">Surnom</label>
                <input type="text" class="form-control" id="surnom" name='surnom' required>
            </div>
            <div class="form-group">
                <label for="nom">Nom Prénom</label>
                <input type="text" class="form-control" id="nom" name='nom' required>
            </div>
            <div class="form-group">
                <label for="fonction">Fonction</label>
                <input type="text" class="form-control" id="fonction" name='fonction' required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name='image' required>
            </div>
            <button type="submit" name= 'submitCreationEquipe' class="btn btn-primary">Créer equipier</button>
        </form>
    </div>
</div>