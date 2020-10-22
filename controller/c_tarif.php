<?php



/* Dictionnaire de données
CREATE
POST
1 = Prix invalide


UPDATE
POST
1 = Modification effectué
2 = Prix invalide

READ +
GET
1 = Duree invalide
2 = Categorie de produit invalide
3 = Suppression effectué
4
5 = Tarif déja existant
6 = Ajout effectué
7 = Tarif inexistant




*/
include "model/m_tarif.php";

if (isset($_SESSION['user'])) {
    if (isset($_GET['crud'])) {
        $getCrud = htmlspecialchars($_GET['crud']);
        switch (true) {
            /* CRUD valide */
            case $getCrud == 'c' || $getCrud == 'r' || $getCrud == 'u' || $getCrud == 'd':

                $codeDureeInput = htmlspecialchars($_GET['cd']);
                $categoProdInput = htmlspecialchars($_GET['cp']);
                
                if (verifcodeDureeValide($codeDureeInput) && verifCategoProdValide($categoProdInput)) {
                    switch (true) {
                        case $getCrud == 'c':
                            if (!verifTarifExiste($codeDureeInput, $categoProdInput)) {
                                if (isset($_POST['prix'])) {
                                    $prixOutput = htmlspecialchars($_POST['prix']);
                                    if (verifPrix($prixOutput)) {
                                        ajoutTarif($codeDureeInput, $categoProdInput, $prixOutput);
                                        /* Msg = Ajout effectué */
                                        header("location: index.php?action=T&msg=6");        
                                    } else {
                                        /* Msg = Prix invalide */
                                        $_POST['msg'] = 1;        
                                    }   
                                }                            
                            } else {
                                /* Msg = Tarif déjà existant */
                                header("location: index.php?action=T&msg=5");   
                            }                          
                            break;
                        case $getCrud == 'r' ||  $getCrud == 'u' || $getCrud == 'd':
                            if (verifTarifExiste($codeDureeInput, $categoProdInput)) {
                                switch (true) {
                                    case $getCrud == 'r':
                                        $resultat = getTarif($codeDureeInput,$categoProdInput);
                                        break;
                                    case $getCrud == 'u':
                                        if (isset($_POST['prix'])) {                
                                            $prixOutput = htmlspecialchars($_POST['prix']);                                   
                                            if (verifPrix($prixOutput)) {
                                                updateTarif($codeDureeInput, $categoProdInput, $prixOutput);
                                                /* Msg = Modification effectué */
                                                $_POST['msg'] = 1;        
                                            } else {
                                                /* Msg = Prix invalide */
                                                $_POST['msg'] = 2;                     
                                            }                                           
                                        }
                                        $resultat = getTarif($codeDureeInput, $categoProdInput);                                    
                                        break;
                                    case $getCrud == 'd':
                                        deleteTarif($codeDureeInput,$categoProdInput);
                                        /* Msg = Suppression effectué */
                                        header("location: index.php?action=T&msg=3");                                     
                                        break;
                                }                            
                            } else {
                                /* Msg = Ce tarif n'existe pas */
                                header("location: index.php?action=T&msg=7");                                    
                            }                            
                        break;    
                    }
                    $view = 'tarif';                 
                }     
                break;
            /* CRUD invalide */ 
            default:
                $view = '404';
                break;
        }
    } else {       /* Read + */
        $listeTarification = getListeTarification();
        $htmlTarif = '';
        
        function definitionBoutonCrud($prixLocation,$codeDuree,$colonne) {
            $crud = '';
            if($prixLocation == null) {
                $crud = '
                <a class="btn btn-primary align-middle btn-sm" href="index.php?action=T&crud=c&cd='.$codeDuree.'&cp='.$colonne.'" role="button"><i class="fas fa-plus"></i></a>';
            } else {
                $crud = '
                <div class="btn-group" role="group">
                    <a class="btn btn-primary btn-sm align-middle" href="index.php?action=T&crud=u&cd='.$codeDuree.'&cp='.$colonne.'" role="button"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-primary btn-sm align-middle" href="index.php?action=T&crud=r&cd='.$codeDuree.'&cp='.$colonne.'" role="button"><i class="far fa-eye"></i></a>
                    <a class="btn btn-danger btn-sm align-middle" href="index.php?action=T&crud=d&cd='.$codeDuree.'&cp='.$colonne.'" role="button"><i class="fas fa-times"></i></a>
                </div>';
            } 
            return $crud;           
        }
        foreach ($listeTarification as $tarification) {

            $crudPS = definitionBoutonCrud($tarification['prixLocationPS'],$tarification["codeDuree"],'PS');
            $crudBB = definitionBoutonCrud($tarification['prixLocationBB'],$tarification["codeDuree"],'BB');
            $crudCO = definitionBoutonCrud($tarification['prixLocationCO'],$tarification["codeDuree"],'CO');

            $htmlTarif.= '
            <tr>
                <td class="align-middle">'.$tarification["libDuree"].'</td>
                <td class="align-middle">'.$tarification["prixLocationPS"].' €</td>
                <td class="align-middle">'.$crudPS.'</td>
                <td class="align-middle">'.$tarification["prixLocationBB"].' €</td>
                <td class="align-middle">'.$crudBB.'</td>
                <td class="align-middle">'.$tarification["prixLocationCO"].' €</td>
                <td class="align-middle">'.$crudCO.'</td>
            </tr>
            ';
            
        }  
        $view = 'tarif';        
    }
} else {
    $view = '403';
}
?>
