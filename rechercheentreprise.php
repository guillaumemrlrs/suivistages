<?php
include 'header.php';
// si une methode de recherche est selectionnée alors;
    if (isset($_REQUEST['selectR'])) {
    //init variable
    $rech = $_REQUEST['selectR'];
    $car = $_REQUEST['termeR'];

    // la requete est selectionnée en fonction de la methode de recherche
    if ($rech == "nom") {

        $sql = "SELECT * FROM sta_entreprise WHERE nom LIKE '%" . $car . "%'";
    } else if ($rech == "naf") {

        $sql = "SELECT * FROM sta_entreprise WHERE code_NAF LIKE '%" . $car . "%'";
    } else if ($rech == "secteur") {

        $sql = "SELECT * FROM sta_entreprise WHERE cpville LIKE '%" . $car . "%'";
    }
}
?>
<br><br><br>
<div class="container_recherche">
    <div class="row d-flex justify-content-center">
    <form action="" method=" GET" >
        <select class="form-control" name="selectR" id="selectR" onchange="cacherInput()">
            <option value="nom" id="nom">Nom</option>
            <option value="naf" id="naf" >Libellé NAF</option>
            <option value="secteur" id="CP1">Secteur géographique</option>
        </select>

        <br>
        <input type="text" class="form-control" id="recherche" placeholder="Saississez votre recherche..." name="termeR">
        

        
        <select  class="hidden" name="libelleNAF" id="libelNaf">
        <?php
            $sql2 = "SELECT * FROM sta_naf order by libelle_NAF asc";
            $q = $connection->query($sql2);
            while ($ligne = $q->fetch()) {
                if ($row['code_NAF'] == $ligne[0])
                    echo "<option value=" . $ligne[0] . " selected='selected'>" . $ligne[1] . "</option>";
                else
                    echo "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                } 
            ?>
        </select>

        

        <select class="hidden" name="codePostal" id="CP" >
            
        </select>

        <br>

        <input class="btn btn-primary" type="submit" name="s" value="Rechercher" />
        </form>
    </div>

    <br><br><br>
    <div class="row">
        <table class="table">
            <tbody>
                <th data-column-id="SIRET"> SIRET</th>
                <th data-column-id="nom">Nom</th>
                <th data-column-id="code_NAF">Libellé NAF</th>
                <th data-column-id="telephone">Téléphone</th>
                <th data-column-id="mail">E-mail</th>
                <th data-column-id="ville">Ville</th>
                <?php
            if(isset($_SESSION['nom'])){
                if (isset($_GET["s"]) AND $_GET["s"] == "Rechercher")
                {
                    $_GET["termeR"] = htmlspecialchars($_GET["termeR"]); //pour sécuriser le formulaire contre les failles html
                    $terme = $_GET["termeR"];
                    $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                    $terme = strip_tags($terme); //pour supprimer les balises html dans la requête
                };
                if (isset($sql)){
                    $reponse = $connection->query($sql);
                    $nombre=$reponse->rowCount();
                    if ($car == ''){
                        if($rech=="nom"){
                            echo "Il n'existe aucune entreprise de ce nom dans la base de données";                                       
                        }elseif($rech == "naf"){
                            echo "Il n'existe aucune entreprise ayant pour libellé NAF ".$car." dans la base de données";
                        }elseif($rech == "secteur"){
                            echo "Il n'existe aucune entreprise dans ce secteur  dans la base de donnée";
                        }
                    }else{
                        while ($donnees = $reponse->fetch()) {
                            $don = '<tr>
                                <td>' . $donnees['SIRET'] . '</td>
                                <td>' . $donnees['nom'] . '</td>
                                <td>' . $donnees['code_NAF'] . '</td>
                                <td>' . $donnees['tel'] . '</td>
                                <td>' . $donnees['Mail'] . '</td>
                                <td>' . $donnees['cpville'].'</td></tr><br/>';
                            echo $don;
                        }
                    }
                    $reponse->closeCursor();
                }
            }else{
                header("Location: log.php?err=1");
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>