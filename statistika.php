
<?php
 include("db.php");
 if (isset($_GET['action']) && $_GET['action']=='delete'){
 $sql = "SELECT * FROM employees WHERE id=?";
 $stm=$pdo->prepare($sql);
 $stm->execute([$_GET['id']]);
 $employee=$stm->fetch(PDO::FETCH_ASSOC);
 
 $sql="DELETE FROM employees WHERE id=?";
 $pstm=$pdo->prepare($sql);
 $pstm->execute([$_GET['id']]);
}

//Darbuotojai
$sql = "SELECT * FROM employees";
//pstm - pre-statement
$pstm=$pdo->prepare($sql);
$pstm->execute();
$employees=$pstm->fetchAll(PDO::FETCH_ASSOC);

// Pareigos
$sql2 = "SELECT * FROM positions";

$pstm2=$pdo->prepare($sql2);
$pstm2->execute();
$positions=$pstm2->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Statistika</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
	 integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>

<!-- Darbuotojai -->
<div class="container-fluid">
   <div class="card mt-5 mb-3">
      <h5 class="card-header bg-primary">Visi įmonės darbuotojai:</h5>
      <?php if (count($employees) > 0):
         $i=1;
         ?>
         <div class="card-body">
            <a href="new.php" class="btn  btn-primary float-end">Pridėti naują darbuotoją</a>
            <table class="table table-striped table-hover mb-3">
               <thead>
                  <tr>
                     <td><strong>ID</strong></td>
                     <td><strong>Vardas</strong></td>
                     <td><strong>Pavardė</strong></td>
                     <td><strong>Lytis</strong></td>
                     <td><strong>Tel.nr.</strong></td>
                     <td><strong>Gimimo data</strong></td>
                     <td><strong>Išsilavinimas</strong></td>
                     <td><strong>Atlyginimas<br>(EUR)</strong></td>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($employees as $employee){ ?>
                  <tr>
                     <td><?= $employee['id'] ?></td>
                     <td><?= $employee['name'] ?></td>
                     <td><?= $employee['surname'] ?></td>
                     <td><?= $employee['gender'] ?></td>
                     <td><?= $employee['phone'] ?></td>
                     <td><?= $employee['birthday'] ?></td>
                     <td><?= $employee['education'] ?></td>
                     <td><?= ($employee['salary'])/100 ?></td>
                     <td><a href="darbuotojas.php?id=<?= $employee['id'] ?>" class="btn btn-warning">Plačiau</a></td>
                     <td><a href="update.php?id=<?=$employee['id']?>" class="btn btn-success">Redaguoti</a></td>
                     <td><a href="statistika.php?action=delete&id=<?=$employee['id']?>" class="btn btn-danger">Ištrinti</a></td>
                     <?php } ?>
                  </tr>
               </tbody>
            </table>
         </div>
      <?php endif; ?>
   </div>
</div>
   <!-- Pareigos -->
   <?php 
    include("darbuotojai_pareigos.php");
   ?>
</body>
</html>



