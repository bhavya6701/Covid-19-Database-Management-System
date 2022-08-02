<?php require_once 'database.php';
$db = $conn->prepare('SELECT * FROM evc353_1.ProStaTer');
$db->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COVID-19 Pandemic Progress System</title>

  <link rel="stylesheet" href="style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="apple-touch-icon" sizes="180x180" href="/Icon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/Icon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/Icon/favicon-16x16.png">
  <link rel="manifest" href="/Icon/site.webmanifest">
</head>

<body class="bg-light">
  <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand navbar-organization" href="index.php">COVID-19 Pandemic Progress System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
          <li class="nav-item ps-5">
            <a class="navbar-name" aria-current="page" href="Login/login.php">Login <i class="bi bi-person-circle"></i></a>
          </li>
          <li class="nav-item ps-5">
            <a class="navbar-name" aria-current="page" href="sub_author.php">Author Subscription <i class="bi bi-person-plus"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container py-2 my-2">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" style="color: black !important;" aria-current="page" href="index.php">ProStaTer Statistics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="color: grey !important;" href="index_Vaccines.php">Vaccine Statistics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="color: grey !important;" href="index_Articles.php">Articles</a>
      </li>
    </ul>

    <form class="form-group d-flex pt-2" action="index.php" method="POST">
      <input id="searchprostater" name="searchprostater" class="form-control me-2 input-box" type="search" placeholder="Search By ProStaTer" aria-label="Search ProStaTer">
      <button id="btnprostater" name="btnprostater" class="btn btn-outline-dark" type="button"><i class="bi bi-search"></i></button>
    </form>

    <table class="table table-bordered my-4 align-middle">
      <thead>
        <tr class="text-center">
          <th>ProStaTer</th>
          <th>Country</th>
          <th>Region</th>
          <th>Agency</th>
          <th>Population</th>
          <th>Vaccinated Population</th>
          <th>Deaths</th>
          <th>Unvaccinated Infected</th>
          <th>Vaccinated Deaths</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
          <tr class="text-center" id="<?= $row['prostater'] ?>">
            <td><?= $row['prostater'] ?></td>
            <td><?= $row['cName'] ?></td>
            <td><?= $row['rName'] ?></td>
            <td><?= $row['agencyName'] ?></td>
            <td><?= $row['population'] ?></td>
            <td><?= $row['vaccPopulation'] ?></td>
            <td><?= $row['deaths'] ?></td>
            <td><?= $row['unvaccInfected'] ?></td>
            <td><?= $row['vacc_Died'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>


  <script src="index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>