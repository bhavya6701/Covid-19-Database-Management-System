<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
  header("Location: ../index.php");
}

require_once '../database.php';
$db = $conn->prepare('SELECT * FROM evc353_1.User');
$db->execute();
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
            <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="admin.php">Admin Page <i class="bi bi-lock"></i></a>
          </li>
          <li class="nav-item ps-5">
            <a class="navbar-name" aria-current="page" href="admin_add.php">Add Users <i class="bi bi-plus-circle"></i></a>
          </li>
          <li class="nav-item ps-5">
            <a class="navbar-name" aria-current="page" href="admin_edit.php">Edit Users <i class="bi bi-pencil-square"></i></a>
          </li>
          <li class="nav-item ps-5">
            <a class="navbar-name" aria-current="page" href="admin_suspend.php">Suspend Users <i class="bi bi-dash-circle"></i></a>
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
    <h1 class="display-4">Users:</h1>
    <div class="d-flex pt-2">
      <input id="searchID" class="form-control me-2 input-box" type="search" placeholder="Search User (By User ID)" aria-label="Search User">
      <button id="searchUser" class="btn btn-outline-dark" type="button"><i class="bi bi-search"></i></button>
    </div>

    <table class="table table-bordered my-4 align-middle">
      <thead>
        <tr class="text-center">
          <th>User ID</th>
          <th>User Type</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Citizenship</th>
          <th>Email Address</th>
          <th>Phone Number</th>
          <th>Organization</th>
          <th>Date of Birth</th>
          <th>Status</th>
          <th>Suspension Date</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
          <tr class="text-center" id="<?= $row['uID'] ?>">
            <td><?= $row['uID'] ?></td>
            <td><?= $row['userType'] ?></td>
            <td><?= $row['fName'] ?></td>
            <td><?= $row['lName'] ?></td>
            <td><?= $row['citizenship'] ?></td>
            <td><?= $row['emailAddress'] ?></td>
            <td><?= $row['phoneNumber'] ?></td>
            <td><?= $row['organizationName'] ?></td>
            <td><?= $row['dateOfBirth'] ?></td>
            <td><?= $row['accStatus'] ?></td>
            <td><?= $row['suspensionDate'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script src="admin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>