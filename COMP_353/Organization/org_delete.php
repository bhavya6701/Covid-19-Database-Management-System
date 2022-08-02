<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("Location: ../index.php");
}

require_once '../database.php';
$db = $conn->prepare('SELECT * FROM evc353_1.ProStaTer');
$db->execute();
if (isset($_POST['art-del-btn'])) {
    $artIDList = $conn->prepare('SELECT prostater 
                                    FROM evc353_1.ProStaTer, evc353_1.Organization
                                    WHERE ProStaTer.cName = Organization.cName AND Organization.delegateUID = :userID');
    $artIDList->bindParam(":userID", $_SESSION["uID"]);
    $artIDList->execute();
    $loop = true;
    while ($loop && $row = $artIDList->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
        if ($_POST['area'] == $row['prostater'])
            $loop = false;
    if (!$loop) {
        $article = $conn->prepare('DELETE FROM evc353_1.Prostater 
                                WHERE prostater = :area');
        $article->bindParam(':area', $_POST["area"]);
        $article->execute();
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
                        <a class="navbar-name" aria-current="page" href="organization.php">My Records <i class="bi bi-journal-text"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="org_add.php">Add Updates <i class="bi bi-plus-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="org_edit.php">Edit Records <i class="bi bi-pencil-square"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="org_delete.php">Delete Records <i class="bi bi-dash-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="../Login/login.php">Logout <i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pt-3">
        <h1 class="display-4">DELETE A RECORD</h1>
        <form class="form-inline" action="org_delete.php" method="POST">
            <div class="row mt-2">
                <div class="input-group col-lg mt-2 my-md-none">
                    <label for="area" class="input-group-text"><i class="bi bi-geo"></i></label>
                    <input id="area" type="text" name="area" class="form-control texthover" maxlength="25" placeholder="Area (to be deleted)" autocomplete="off" required />
                </div>
                <div class="input-group col-lg mt-2 my-md-none">
                    <button type="submit" class="btn btn-outline-dark" name="art-del-btn">
                        Delete Record!
                    </button>
                </div>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>