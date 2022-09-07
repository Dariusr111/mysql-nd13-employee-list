<?php

include("db.php");


$darbuotojasID = $_GET['id'];

$sql = "SELECT * FROM employees WHERE id = $darbuotojasID";


//pstm - pre-statement
$pstm = $pdo->prepare($sql);
$pstm->execute();
$employees = $pstm->fetchAll(PDO::FETCH_ASSOC);



?>


   <!DOCTYPE html>
   <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Darbuotojai</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   </head>



   <body>
      <div class="container" id="content" tabindex="-1">
         <div class="row">
            <?php foreach ($employees as $employee){ ?>
            <div class="col-md-12">

               <div class="page-header">
              
                  <h1><?= $employee['name'] ?> <?= $employee['surname'] ?></h1>
               </div>
            </div>
            <div class="col-md-6">
               <p>
                  <b>Išsilavinimas: </b> <br /> <?= $employee['education'] ?>
               </p>
               <p>
                  <b>Mėnesinė alga: </b> <br /><?= ($employee['salary'])/100 ?> EUR
               </p>
            </div>
            <div class="col-md-6">
               <p>
                  <b>Telefonas: </b> <br /><?= $employee['phone'] ?>
               </p>
            </div>
            <?php } ?>
         </div>
      </div>

<?php
$alga = $employee['salary'] / 100;

if ($alga <= 1704) {
    $npd = 540 - 0.34 * ($alga - 730);
} else {
    $npd = 400 - 0.18 * ($alga - 642);
}

$gpm = ($alga - $npd) * 0.2;
$psd = $alga * 0.0698;
$soc = $alga * 0.1252;
$irankas = $alga - $gpm - $psd - $soc;
$darbdavioSodra = $alga * 0.0177;
$darbGarantFondas = $alga * 0.0016;
$sodra = $psd + $soc + $darbdavioSodra;
$viso = $gpm + $sodra;

?>
      <div class="container col-5">
        <div class="card">
            <div class="card-header">
                Darbuotojo atlyginimo išrašas
            </div>
            <div class="card-body">
                <h5 class="card-title">Darbuotojas: <?= $employee['name'] . ' ' . $employee['surname'] ?></h5>
                <p class="mt-3"> Taikytinas NPD (Pritaikytas NPD): <strong><?= $npd ?></strong> EUR</p>
                <p> Gyventojų pajamų mokestis GPM - 20.00% : <strong><?= $gpm ?></strong> EUR</p>
                <p> Privalomasis sveikatos draudimas PSD - 6.98% : <strong><?= $psd ?></strong> EUR</p>
                <p> Valstybinis socialinis draudimas VSD - 12.52% : <strong><?= $soc ?></strong> EUR</p>
                <p> Atlyginimas į rankas : <strong><?= $irankas ?></strong> EUR</p>
                <p> Darbdavio mokesčiai - Viso : <strong><?= $darbdavioSodra ?></strong> EUR</p>
                <p> Sodrai. Įmokos kodas - 252 : <strong><?= $sodra ?></strong> EUR</p>
                <p> Įmoka į Garantinį fondą : <strong><?= $darbGarantFondas ?></strong> EUR</p>
                <p> VISO MOKĖSČIŲ : <strong><?= $viso ?></strong> EUR</p>
                <a href="statistika.php" class="btn btn-primary">Atgal</a>
            </div>
        </div>
    </div>
   </body>
   </html>