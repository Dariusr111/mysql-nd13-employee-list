<?php
include("db.php");




// Positions lentelė + darbuotojų skaičius pareigose
$sql= "SELECT p.id, p.name, p.base_salary, COUNT(e.id) AS sk FROM `positions` p  LEFT JOIN employees e ON e.pareigos_id=p.id GROUP BY p.id";
$pstm=$pdo->prepare($sql);
$pstm->execute();
$positions=$pstm->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pareigos</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
   <div class="container mb-4">
      <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <div class="card mt-5 mb-5">
               <h5 class="card-header bg-primary">Baziniai darbo užmokesčiai:</h5>
               <?php if (count($positions) > 0): ?>
               <div class="container">
                  <table class="table table-striped table-hover mb-2">
                     <thead>
                        <tr>
                           <td><strong>ID</strong></td>
                           <td><strong>Pareigos</strong></td>
                           <td><strong>Atlyginimas</strong></td>
                           <td><strong>Darbuotojų sk.</strong></td>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($positions as $position){ ?>
                        <tr>
                           <td><?= $position['id'] ?></td>
                           <td><?= $position['name'] ?></td>
                           <td><?= ($position['base_salary'])/100 ?></td>
                           <td><?= $position['sk'] ?></td>
                           <td><a href="#" class="btn btn-secondary float-end">Rodyti darbuotojus</a></td>
                           <?php } ?>
                        </tr>
                     </tbody>
                  </table>
                  <?php endif; ?>
               </div>
            </div>
         </div>
         <div class="col-md-2"></div>
      </div>
   </div>
</body>

</html>