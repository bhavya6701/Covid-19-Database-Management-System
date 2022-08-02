<?php
require_once 'database.php';
$user_id;
if (isset($_GET['emailID'])) {
    $db = $conn->prepare('SELECT uID FROM evc353_1.User WHERE emailAddress = :email');
    $db->bindParam(':email', $_GET['emailID']);
    $db->execute();
    $user_id = $db->fetchColumn();
    if ($user_id == null) {
        header("Location: regular_user.php");
    }
}
if (isset($_GET['auth'])) {
    $author = $_GET['auth'];
    foreach ($author as $authID) {
        $db = $conn->prepare('INSERT INTO evc353_1.Author_Subs VALUES(:authID, :userID)');
        $db->bindParam(':authID', $authID);
        $db->bindParam(':userID', $user_id);
        $db->execute();
    }
} else {
    header("Location: regular_user.php");
}
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
                        <a class="navbar-name" style="color: white !important;" aria-current="page" href="../COMP_353/sub_author.php">Author Subscription <i class="bi bi-person-plus"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pt-5 w-50 text-center">
        <h1 class="display-5 pt-3">Subscription Successful! <i class="bi bi-emoji-smile"></i></h1>
        <h2 class="Lead pt-3">You will receive notification to the given email address whenever there is a new article published by the author/s subscribed.</h2>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>