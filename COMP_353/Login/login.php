<?php
session_start();
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
  <link rel="apple-touch-icon" sizes="180x180" href="/Icon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/Icon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/Icon/favicon-16x16.png">
  <link rel="manifest" href="/Icon/site.webmanifest">
</head>

<body>
  <div class="container-fluid background"></div>
  <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand navbar-organization" href="../index.php">COVID-19 Pandemic Progress System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
          <li class="nav-item ps-5">
            <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="../COMP_353/login.php">Login <i class="bi bi-person-circle"></i></a>
          </li>
          <li class="nav-item ps-5">
            <a class="navbar-name" aria-current="page" href="../sub_author.php">Author Subscription <i class="bi bi-person-plus"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container w-25 my-5 py-5 px-5 bg-light text-dark">
    <h1 class="display-6 text-center">COVID-19 Pandemic Progress System</h1>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false) {
      echo '<div class="lead" style="color:red;">Login Failed, try again!</div>';
      session_unset();
    }
    ?>
    <form action="loginhandler.php" type="POST">
      <label for="email" class="col-sm-2 col-form-label">Email</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="abcd1234@email.com" required />
      <label for="password" class="col-sm-2 col-form-label">Password</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="********" required />
      <div class="row my-3">
        <div class="col text-center">
          <button class="btn btn-outline-dark btn-login" type="submit">Login!</button>
        </div>
      </div>
    </form>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>