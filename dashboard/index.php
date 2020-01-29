<?php 
include 'header.php';

$sqleleve = "SELECT * FROM sta_etudiant etu,sta_demande d, sta_etat eta, sta_periode p,sta_classe c WHERE etu.idclasse=c.idclasse AND etu.idetudiant = d.idetudiant AND d.idetat =eta.idetat AND p.idperiode = d.idperiode and eta.idetat not in (4) GROUP BY etu.idetudiant ORDER BY etu.nom asc, p.idperiode asc";
$q = $connection->query($sqleleve);
$reponse2 = $q->fetchAll();

$sqlsio1 = "SELECT count(idetudiant) as nbsio1 FROM sta_etudiant e,sta_classe c where e.idclasse=c.idclasse AND e.idclasse=1 AND e.idclasse not in (3,4)";
$q11 = $connection->query($sqlsio1);
$reponse11 = $q11->fetch();
$nbsio1 = $reponse11['nbsio1'];

$sqlsio2 = "SELECT count(idetudiant) as nbsio2 FROM sta_etudiant e,sta_classe c where e.idclasse=c.idclasse AND e.idclasse=2 AND e.idclasse not in (3,4)";
$q22 = $connection->query($sqlsio2);
$reponse22 = $q22->fetch();
$nbsio2 = $reponse22['nbsio2'];
?>

<section class="dashboard-counts section-padding">
    <div class="container-fluid">
        <div class="row">
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-user"></i></div>
                    <div class="name"><strong class="text-uppercase">SIO1</strong>
                        <div class="count-number"><?php echo $nbsio1;?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-user"></i></div>
                    <div class="name"><strong class="text-uppercase">SIO2</strong>
                        <div class="count-number"><?php echo $nbsio2;?></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="">
    <div class="container-fluid">
        <header>
        </header>

        <div class="card">
            <div class="card-header">
                <h4>Etudiants sans stage</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Etudiant</th>
                                <th>Classe</th>
                                <th>Etat</th>
                                <th>Rappel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($reponse2 as $affiche){
                              $idEtudiant = $affiche['idetudiant'];
                              $nomEtudiant = $affiche['nom']." ".$affiche['prenom'];
                              $photoEtudiant = $affiche["photo"]; 
                              $classeEtudiant = $affiche["libelle_classe"];
                              $etatStage = $affiche["libelle_etat"];
                            ?>
                            <tr>
                                <td><img src="../images/<?php echo $photoEtudiant?>"> <?php echo $nomEtudiant;?></td>
                                <td><?php echo $classeEtudiant;?></td>
                                <td><?php echo $etatStage;?></td>
                                <td><a class="btn btn-primary" data-toggle="modal"
                                        data-target="#supp<?php echo $idPeriode?>" style="color: white"><i
                                            class="fas fa-bell"></i></a></td>

                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>

<?php include 'footer.php' ?>