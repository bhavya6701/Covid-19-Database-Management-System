<?php
require_once 'database.php';
$db = $conn->prepare('SELECT authID, CONCAT(fName, " ", lName) AS author
                      FROM evc353_1.Author, evc353_1.Researcher, evc353_1.User
                      WHERE Author.rID = Researcher.rID AND Researcher.uID = User.uID
                      UNION
                      SELECT authID, CONCAT(fName, " ", lName) AS author
                      FROM evc353_1.Author, evc353_1.Organization, evc353_1.User
                      WHERE Author.oID = Organization.oID AND Organization.delegateUID = User.uID');
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
      <a class="navbar-brand navbar-organization" href="../COMP_353/index.php">COVID-19 Pandemic Progress System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
          <li class="nav-item ps-5">
            <a class="navbar-name" aria-current="page" href="Login/login.php">Login <i class="bi bi-person-circle"></i></a>
          </li>
          <li class="nav-item ps-5">
            <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="../COMP_353/sub_author.php">Author Subscription <i class="bi bi-person-plus"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container pt-3">
    <h1 class="display-5">Receive Email Notification</h1>

    <form class="pt-2" action="subscribed.php" method="GET">
      <div class="row d-flex">
        <div class="col d-flex">
          <input id="emailID" name="emailID" class="form-control me-2 input-box" type="email" placeholder="abcd1234@email.com" required>
          <button id="btnEmail" name="btnEmail" class="btn btn-outline-dark" type="submit"><i class="bi bi-forward-fill"></i></button>
        </div>
      </div>
      <h1 class="display-6 pt-3">Authors:</h1>
      <?php while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
        <div class="form-check py-2">
          <input class="form-check-input" name="auth[]" type="checkbox" value="<?= $row['authID'] ?>" id="<?= $row['authID'] ?>">
          <label class="form-check-label" for="<?= $row['authID'] ?>">
            <?= $row['author'] ?>
          </label>
        </div>
      <?php } ?>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>