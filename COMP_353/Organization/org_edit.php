<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("Location: ../index.php");
}

require_once '../database.php';
$db = $conn->prepare('SELECT * 
                        FROM evc353_1.ProStaTer
                        WHERE ProStaTer.cName IN (SELECT citizenship 
                                                    FROM evc353_1.User 
                                                    WHERE User.uID=:userID)');
$db->bindParam(":userID", $_SESSION["uID"]);
$db->execute();
if (isset($_POST['org-edit-btn'])) {
    $proStaTerList = $conn->prepare('SELECT prostater 
                                        FROM evc353_1.ProStaTer
                                        WHERE ProStaTer.cName IN (SELECT citizenship 
                                                                    FROM evc353_1.User 
                                                                    WHERE User.uID=:userID)');
    $proStaTerList->bindParam(":userID", $_SESSION["uID"]);
    $proStaTerList->execute();
    $loop = true;
    while ($loop && $row = $proStaTerList->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
        if ($_POST['proStaTer'] == $row['prostater'])
            $loop = false;
    if (!$loop) {
        $prostater = $conn->prepare('UPDATE evc353_1.ProStaTer 
                                    SET population = :pop , vaccPopulation = :vaccpop , deaths = :died, unvaccInfected = :unvinf, vacc_Died = :vaccdied 
                                    WHERE prostater = :proStaTer');
        $prostater->bindParam(':proStaTer', $_POST['proStaTer']);
        $prostater->bindParam(':pop', $_POST["pop"]);
        $prostater->bindParam(':vaccpop', $_POST["vaccpop"]);
        $prostater->bindParam(':died', $_POST["died"]);
        $prostater->bindParam(':unvinf', $_POST["unvinf"]);
        $prostater->bindParam(':vaccdied', $_POST["vaccdied"]);

        $prostater->execute();

        header("Location: Organization.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19 Pandemic Progress System</title>

    <link rel="stylesheet" href="../style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../Icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Icon/favicon-16x16.png">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand navbar-organization" href="../index.php">COVID-19 Pandemic Progress System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="organization.php">My Records <i class="bi bi-journal-text"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="org_add.php">Add Updates <i class="bi bi-plus-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="org_edit.php">Edit Records <i class="bi bi-pencil-square"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="org_delete.php">Delete Records <i class="bi bi-dash-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="../Login/login.php">Logout <i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pt-3">
        <h1 class="display-4 mt-3">EDIT COVID-19 DATA</h1>
        <form class="form-inline" action="org_edit.php" method="POST">
            <div class="row mt-3">
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="prostater" class="input-group-text"><i class="bi bi-geo"></i></label>
                    <input id="prostater" name="proStaTer" type="text" class="form-control" maxlength="25" placeholder="ProStaTer" autocomplete="off" required />
                </div>
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updPopulation" class="input-group-text"><i class="bi bi-people"></i></label>
                    <input id="updPopulation" name="pop" type="number" class="form-control" maxlength="12" placeholder="Population" autocomplete="off" required />
                </div>
            </div>

            <div class="row">
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updVaccinated" class="input-group-text"><i class="bi bi-capsule-pill"></i></label>
                    <input id="updVaccinated" name="vaccpop" type="number" class="form-control" maxlength="12" placeholder="Vaccinated" autocomplete="off" required />
                </div>
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updInfected" class="input-group-text"><i class="bi bi-virus"></i></label>
                    <input id="updInfected" name="unvinf" type="number" class="form-control" maxlength="12" placeholder="Unvaccinated Infected" autocomplete="off" required />
                </div>
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updDeaths" class="input-group-text"><i class="bi bi-droplet-half"></i></label>
                    <input id="updDeaths" name="died" type="number" class="form-control" maxlength="12" placeholder="Deaths" autocomplete="off" required />
                </div>
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updVaccDied" class="input-group-text"><i class="bi bi-droplet-half"></i></label>
                    <input id="updVaccDied" name="vaccdied" type="number" class="form-control" maxlength="12" placeholder="Vaccinated Deaths" autocomplete="off" />
                </div>
            </div>

            <button type="submit" class="btn btn-outline-dark mt-3" name="org-edit-btn" id="submit">
                Edit Data!
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>