<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("Location: ../index.php");
}

require_once '../database.php';
if (isset($_POST["suspendbtn"])) {
    $idlist = $conn->prepare('SELECT uID, userType 
                                FROM evc353_1.User');
    $idlist->execute();
    $loop = false;
    while ($row = $idlist->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        if (strcmp($_POST['userid'], $row['uID']) == 0 && strcmp($row['userType'], "Admin") != 0) {
            $loop = true;
            break;
        }
    }
    if ($loop) {

        if (strcmp($_POST["statusType"], "Suspended") == 0) {
            $user = $conn->prepare('UPDATE evc353_1.User 
                                    SET suspensionDate = :dateNow, accStatus = "Suspended"
                                    WHERE uID = :userid');
            $date = date("Y-m-d");
            $user->bindParam(':userid', $_POST["userid"]);
            $user->bindParam(':dateNow', $date);
            $user->execute();
        } else {
            $user = $conn->prepare('UPDATE evc353_1.User 
                                    SET  suspensionDate = null, accStatus = "Active"
                                    WHERE uID = :userid');
            $user->bindParam(':userid', $_POST["userid"]);
            $user->execute();
        }
        header("Location: admin.php");
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
                        <a class="navbar-name" aria-current="page" href="admin.php">Admin Page <i class="bi bi-lock"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="admin_add.php">Add Users <i class="bi bi-plus-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="admin_edit.php">Edit Users <i class="bi bi-pencil-square"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="admin_suspend.php">Suspend Users <i class="bi bi-dash-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="../sub_author.php">Author Subscription <i class="bi bi-person-plus"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="../Login/logout.php">Logout <i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pt-3">
        <h1 class="display-5">SUSPEND/ACTIVE USER</h1>
        <form class="form-inline" action="admin_suspend.php" method="POST">
            <div class="row mt-4">
                <div class="input-group my-md-none w-25">
                    <label for="userid" class="input-group-text"><i class="bi bi-hash"></i></label>
                    <input id="userid" name="userid" type="number" class="form-control texthover" maxlength="50" placeholder="User ID" autocomplete="off" required />
                </div>
                <div class="w-25">
                    <select class="form-select col d-sm-inline" name="statusType" id="statusType">
                        <option value="Active">Active</option>
                        <option value="Suspended">Suspend</option>
                    </select>
                </div>
                <div class="input-group col-lg  my-md-none">
                    <button type="submit" class="btn btn-outline-dark" name="suspendbtn" id="submit">
                        Suspend/Active User!
                    </button>
                </div>

            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>