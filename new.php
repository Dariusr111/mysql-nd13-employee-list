

<?php
 include ("db.php");
  if (isset($_POST['action']) && $_POST['action']=='insert'){
    try{
        
        $sql="INSERT INTO employees (name, surname, gender, phone, birthday, education, salary) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stm=$pdo->prepare($sql);
        $stm->execute([ $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['phone'], $_POST['birthday'], $_POST['education'], $_POST['salary']]);
        header("location:statistika.php");
        die();
    }catch(Exception $e){
        
        $klaida="Įvyko klaida: ".$e->getMessage();
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header"><strong>Pridėti naują darbuotoją</strong></div>
                    <div class="card-body">
                        <?php
                            if (isset($klaida)){
                                ?>
                                <div class="alert alert-danger"><?=$klaida?></div>
                                
                                <?php
                            }
                        ?>
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="insert"> 
                            <div class="mb-3">
                                <label for="" class="form-label">Vardas</label>
                                <input name="name" type="text" class="form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Pavardė</label>
                                <input name="surname" type="text" class="form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Lytis</label>
                                <select id="gender" name="gender" class="form-control" required> 
                                    <option value="" disabled selected>Pasirinkite</option>
                                    <option value="vyras">Vyras</option>
                                    <option value="moteris">Moteris</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Telefono nr.</label>
                                <input name="phone" type="text" class="form-control"  >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Gimimo data</label>
                                <input name="birthday" type="text" class="form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Išsilavinimas</label>
                                <select id="education" name="education" class="form-control"> 
                                    <option value="" disabled selected>Pasirinkite</option>
                                    <option value="Aukštasis išsilavinimas">Aukštasis išsilavinimas</option>
                                    <option value="Aukštasis universitetinis išsilavinimas">Aukštasis universitetinis išsilavinimas</option>
                                    <option value="Aukštasis koleginis išsilavinimas">Aukštasis koleginis išsilavinimas</option>
                                    <option value="Aukštesnysis išsilavinimas">Aukštesnysis išsilavinimas</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Atlyginimas</label>
                                <input name="salary" type="text" class="form-control"  >
                            </div>
                            <button class="btn btn-success">Pridėti</button>
                            <a href="statistika.php" class="btn btn-info float-end">Atgal</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>