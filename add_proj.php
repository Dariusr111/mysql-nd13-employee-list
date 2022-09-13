<?php
include("db.php");
if (isset($_POST['action']) && $_POST['action'] == 'insert') {

// rekia pridėti patikrinimą, kad nebūtų galima priskirti to pačio projekto
    $sql = "INSERT INTO empl_projects (project_id, employee_id) VALUES (?, ?)";
    $stm = $pdo->prepare($sql);
    $stm->execute([$_POST['project_id'], $_GET['id']]);

    header("location:statistika.php");
    die();
}


$darbuotojasID = $_GET['id'];
$sql = "SELECT * FROM employees WHERE id = $darbuotojasID";
//pstm - pre-statement
$pstm = $pdo->prepare($sql);
$pstm->execute();
$employees = $pstm->fetchAll(PDO::FETCH_ASSOC);


// prijungiam project_id ir projects[name]
$sql = "SELECT ep.project_id, p.name FROM `empl_projects` ep LEFT JOIN employees e ON e.id=ep.employee_id LEFT JOIN projects p ON ep.project_id=p.id WHERE e.id = $darbuotojasID ORDER BY ep.project_id ASC";
$pstm = $pdo->prepare($sql);
$pstm->execute();
$employee_projects = $pstm->fetchAll(PDO::FETCH_ASSOC);




if (isset($_GET['id'])) {

    $sql = "SELECT * FROM projects";
    $stm = $pdo->prepare($sql);
    $stm->execute([]);
    $projects = $stm->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("location:statistika.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projektų priskyrimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5 mb-5">
                    <div class="card-header">
                        <strong>Parinkti projektą</strong>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($klaida)) {
                        ?>
                            <div class="alert alert-danger"><?= $klaida ?></div>

                        <?php
                        }
                        ?>
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="insert">
                            <div class="mb-3">
                                <label for="" class="form-label">Projektai: </label>
                                <select name="project_id" class="form-control mb-3">
                                    <?php foreach ($projects as $project) { ?>

                                        <option value="<?= $project['id'] ?>"><?= $project['name'] ?></option>
                                    <?php } ?>
                                </select>
                                <button class="btn btn-success">Pridėti</button>
                                <a href="statistika.php" class="btn btn-info float-end">Atgal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="card mt-5">
                            <div class="card-header bg-light ms-4 me-4">
                                <?php foreach ($employees as $employee) { ?>
                                    <h1><?= $employee['name'] ?> <?= $employee['surname'] ?></h1>
                                <?php } ?>
                                
                            </div>
                            <div class="card-body">
                                <div class="ms-2">
                                    <p>Dirba prie šių projektų:</p>
                                </div>
                                <table class="table table-striped table-hover mb-3">
                                    <thead>
                                        <tr>
                                            <td><strong>Projekto Nr.</strong></td>
                                            <td><strong>Projekto pavadinimas</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td>
                                                <?php foreach ($employee_projects as $employee_project) { ?>
                                                    <p> <?= $employee_project['project_id'] ?></p>
                                                <?php } ?>
                                            </td>
                                            <td>
                                            <?php foreach ($employee_projects as $employee_project) { ?>
                                                    <p> <?= $employee_project['name'] ?></p>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>