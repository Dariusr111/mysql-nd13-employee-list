
<?php
 include("db.php");
 //Delete opcija
 if (isset($_GET['action']) && $_GET['action']=='delete'){
 $sql = "SELECT * FROM employees WHERE id=?";
 $stm=$pdo->prepare($sql);
 $stm->execute([$_GET['id']]);
 $employee=$stm->fetch(PDO::FETCH_ASSOC);
 

 $sql="DELETE FROM employees WHERE id=?";
 $pstm=$pdo->prepare($sql);
 $pstm->execute([$_GET['id']]);

}

//Darbuotojai + pareigos
$sql = "SELECT employees.*, positions.name as position_name FROM `employees` LEFT JOIN positions ON employees.pareigos_id=positions.id ORDER BY id ASC";
//pstm - pre-statement
$pstm=$pdo->prepare($sql);
$pstm->execute();
$employees=$pstm->fetchAll(PDO::FETCH_ASSOC);

// Visų darbuotojų skaičius
$sql= "SELECT count(*) as darb_skaicius FROM `employees`";
$pstm=$pdo->prepare($sql);
$pstm->execute();
$darb_sk=$pstm->fetchAll(PDO::FETCH_ASSOC);


// Vidutinis darbo užmokestis
$sql= "SELECT ROUND((AVG(e.salary)/100),0) as vid FROM `employees` e";
$pstm=$pdo->prepare($sql);
$pstm->execute();
$vid_alg=$pstm->fetchAll(PDO::FETCH_ASSOC);

// Minimalus darbo užmokestis
$sql= "SELECT ROUND((MIN(e.salary)/100),0) as vid FROM `employees` e";
$pstm=$pdo->prepare($sql);
$pstm->execute();
$min_alg=$pstm->fetchAll(PDO::FETCH_ASSOC);

// Maksimalus darbo užmokestis
$sql= "SELECT ROUND((MAX(e.salary)/100),0) as vid FROM `employees` e";
$pstm=$pdo->prepare($sql);
$pstm->execute();
$max_alg=$pstm->fetchAll(PDO::FETCH_ASSOC);

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
                     <td><strong>Pareigos</strong></td>
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
                     <td><?= $employee['position_name'] ?></td>
                     <td><a href="add_proj.php?id=<?=$employee['id']?>" class="btn btn-secondary">Projektas</a></td>
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
   <div>
      <!-- Pareigos -->
      <?php
       include("darbuotojai_pareigos.php");
      ?>
   </div>
   <!-- Įmonės statistika -->
   <div class="container">
      <div class="row">
               <div class="col-md-2">
               </div>   
               <div class="col-md-8">
                  <div class="card mt-5 mb-5">
                     <h5 class="card-header bg-primary">Įmonės statistika:</h5>
                     <div class="container">
                        <table class="table table-striped table-hover ms-1 mb-3">
                           <tbody>
                              <tr>
                                 <td><strong>Įmonėje dirbančių žmonių skaičius</strong></td>
                                 <td><?php echo $darb_sk[0]["darb_skaicius"]?></td>
                              </tr>
                              <tr>
                                 <td><strong>Vidutinis darbo užmokestis</strong></td>
                                 <td><?php echo $vid_alg[0]["vid"]." EUR" ?></td>
                              </tr>
                              <tr>
                                 <td><strong>Minimalus darbo užmokestis</strong></td>
                                 <td><?php echo $min_alg[0]["vid"]." EUR" ?></td>
                              </tr>
                              <tr>
                                 <td><strong>Maksimalus darbo užmokestis</strong></td>
                                 <td><?php echo $max_alg[0]["vid"]." EUR" ?></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="col-md-2">
               </div> 
            
         </div>
   </div>




</body>
</html>



