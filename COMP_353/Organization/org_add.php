<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("Location: ../index.php");
}

require_once '../database.php';
$db = $conn->prepare('SELECT MAX(updateID) FROM evc353_1.Update');
$db->execute();
$newrow = ($db->fetch())[0] + 1;

if (isset($_POST["addbtn"])) {
    $populationList = $conn->prepare('SELECT updPopulation
                                FROM evc353_1.Update');
    $populationList->execute();
    $loop = true;
    while ($loop && $row = $populationList->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        if (strcmp($_POST['pop'], $row['updPopulation']) == 0) {
            $loop = false;
            break;
        }
    }
    if ($loop) {
        $country = $conn->prepare('SELECT DISTINCT cName FROM evc353_1.ProStaTer
        WHERE ProStaTer.cName IN (SELECT citizenship FROM evc353_1.User WHERE User.uID=:userID)');
        $country->bindParam(":userID", $_SESSION["uID"]);
        $country->execute();
        $cName = $country->fetchColumn();

        $prostater = $conn->prepare('INSERT INTO evc353_1.Update
                                VALUES(:updateID,:prostater,:cName,:updateDate,:updPopuation,:updVaccinated,:updInfected,:updDeaths,:updVaccDied,:pfizerVacc,:pfizerDied,:AstraZenVacc,:AstraZenDied,:modernaVacc,:modernaDied,:jjVacc, :jjDied)');
        $date = date("Y-m-d");
        $prostater->bindParam(':updateID', $newrow);
        $prostater->bindParam(':prostater', $_POST["prostater"]);
        $prostater->bindParam(':cName', $cName);
        $prostater->bindParam(':updateDate', $date);
        $prostater->bindParam(':updPopuation', $_POST["updPopuation"]);
        $prostater->bindParam(':updVaccinated', $_POST["updVaccinated"]);
        $prostater->bindParam(':updDeaths', $_POST["updDeaths"]);
        $prostater->bindParam(':updVaccDied', $_POST["updVaccDied"]);
        $prostater->bindParam(':pfizerVacc', $_POST["pfizerVacc"]);
        $prostater->bindParam(':pfizerDied', $_POST["pfizerDied"]);
        $prostater->bindParam(':AstraZenVacc', $_POST["AstraZenVacc"]);
        $prostater->bindParam(':AstraZenDied', $_POST["AstraZenDied"]);
        $prostater->bindParam(':modernaVacc', $_POST["modernaVacc"]);
        $prostater->bindParam(':modernaDied', $_POST["modernaDied"]);
        $prostater->bindParam(':jjVacc', $_POST["jjVacc"]);
        $prostater->bindParam(':jjDied', $_POST["jjDied"]);

        $prostater->execute();

        $prostater2 = $conn->prepare('INSERT INTO ProStaTer 
                                VALUES(:prostater, :cName,
                                (SELECT rName from ProStaTer WHERE ProStaTer.cName = :cName GROUP BY cName),
                                (SELECT agencyName from ProStaTer WHERE ProStaTer.cName = :cName GROUP BY cName),
                                :updPopulation, :updVaccinated, :updDeaths, :updInfected, :updVaccDied)');

        $prostater2->bindParam(':prostater', $_POST["prostater"]);
        $prostater2->bindParam(':cName', $cName);
        $prostater2->bindParam(':updPopuation', $_POST["updPopuation"]);
        $prostater2->bindParam(':updVaccinated', $_POST["updVaccinated"]);
        $prostater2->bindParam(':updDeaths', $_POST["updDeaths"]);
        $prostater2->bindParam(':updInfected', $_POST["updInfected"]);
        $prostater2->bindParam(':updVaccDied', $_POST["updVaccDied"]);

        $prostater3 = $conn->prepare('INSERT INTO Vaccine VALUES 
        ("Pfizer",:prostater,:pfizerVacc,:updInfected,:pfizerDied),
        ("Moderna",:prostater,:modernaVacc,:updInfected,:modernaDied),
        ("AstraZeneca",:prostater,:AstraZenVacc,:updInfected,:AstraZenDied),
        ("Johnson & Johnson",:prostater,:jjVacc,:updInfected,:jjDied)');











        header("Location: organization.php");
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
                        <a class="navbar-name" aria-current="page" href="organization.php"> My Records <i class="bi bi-journal-text"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="researcher_add.php">Add Updates <i class="bi bi-plus-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="org_edit.php">Edit Records <i class="bi bi-pencil-square"></i></a>
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

    <div class="container">
        <h1 class="display-4 mt-3">ADD COVID-19 DATA</h1>
        <form class="form-inline" action="org_add.php" method="POST">
            <div class="row mt-3">
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="prostater" class="input-group-text"><i class="bi bi-geo"></i></label>
                    <input id="prostater" name="prostater" type="text" class="form-control" maxlength="25" placeholder="ProStaTer" autocomplete="off" required />
                </div>
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updPopuation" class="input-group-text"><i class="bi bi-people"></i></label>
                    <input id="updPopuation" name="updPopuation" type="number" class="form-control" maxlength="12" placeholder="Population" autocomplete="off" required />
                </div>
            </div>

            <div class="row">
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updVaccinated" class="input-group-text"><i class="bi bi-capsule-pill"></i></label>
                    <input id="updVaccinated" name="updVaccinated" type="number" class="form-control" maxlength="12" placeholder="Vaccinated" autocomplete="off" required />
                </div>

                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updInfected" class="input-group-text"><i class="bi bi-virus"></i></label>
                    <input id="updInfected" name="updInfected" type="number" class="form-control" maxlength="12" placeholder="Infected" autocomplete="off" required />
                </div>
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updDeaths" class="input-group-text"><i class="bi bi-droplet-half"></i></label>
                    <input id="updDeaths" name="updDeaths" type="number" class="form-control" maxlength="12" placeholder="Deaths" autocomplete="off" required />
                </div>
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="updVaccDied" class="input-group-text"><i class="bi bi-droplet-half"></i></label>
                    <input id="updVaccDied" name="updVaccDied" type="number" class="form-control" maxlength="12" placeholder="Vaccinated Deaths" autocomplete="off" />
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="input-group col-lg mt-2 my-md-none">
                        <label for="pfizerVacc" class="input-group-text"><i class="bi bi-capsule"></i></label>
                        <input id="pfizerVacc" name="pfizerVacc" type="password" class="form-control" maxlength="16" minlength="8" placeholder="Pfizer Vaccinated" autocomplete="off" />
                    </div>
                    <div class="input-group col-lg mt-2 my-md-none">
                        <label for="pfizerDied" class="input-group-text"><i class="bi bi-virus2"></i></label>
                        <input id="pfizerDied" name="pfizerVacc" type="password" class="form-control" maxlength="16" minlength="8" placeholder="Pfizer Deaths" autocomplete="off" />
                    </div>
                </div>
                <div class="col">
                    <div class="input-group col-lg mt-2 my-md-none">
                        <label for="AstraZenVacc" class="input-group-text"><i class="bi bi-capsule"></i></label>
                        <input id="AstraZenVacc" name="AstraZenVacc" type="password" class="form-control" maxlength="16" minlength="8" placeholder="AstraZeneca Vaccinated" autocomplete="off" />
                    </div>
                    <div class="input-group col-lg mt-2 my-md-none">
                        <label for="AstraZenDied" class="input-group-text"><i class="bi bi-virus2"></i></label>
                        <input id="AstraZenDied" name="AstraZenDied" type="password" class="form-control" maxlength="16" minlength="8" placeholder="AstraZeneca Deaths" autocomplete="off" />
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col">
                    <div class="input-group col-lg mt-2 my-md-none">
                        <label for="modernaVacc" class="input-group-text"><i class="bi bi-capsule"></i></label>
                        <input id="modernaVacc" name="modernaVacc" type="password" class="form-control" maxlength="16" minlength="8" placeholder="Moderna Vaccinated" autocomplete="off" />
                    </div>
                    <div class="input-group col-lg mt-2 my-md-none">
                        <label for="modernaDied" class="input-group-text"><i class="bi bi-virus2"></i></label>
                        <input id="modernaDied" name="modernaDied" type="password" class="form-control" maxlength="16" minlength="8" placeholder="Moderna Deaths" autocomplete="off" />
                    </div>
                </div>
                <div class="col">
                    <div class="input-group col-lg mt-2 my-md-none">
                        <label for="jjVacc" class="input-group-text"><i class="bi bi-capsule"></i></label>
                        <input id="jjVacc" name="jjVacc" type="password" class="form-control" maxlength="16" minlength="8" placeholder="Johnson & Johnson Vaccinated" autocomplete="off" />
                    </div>
                    <div class="input-group col-lg mt-2 my-md-none">
                        <label for="jjDied" class="input-group-text"><i class="bi bi-virus2"></i></label>
                        <input id="jjDied" name="jjDied" type="password" class="form-control" maxlength="16" minlength="8" placeholder="Johnson & Johnson Deaths" autocomplete="off" />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-dark mt-3" name="addbtn" id="submit">
                Add Data!
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>