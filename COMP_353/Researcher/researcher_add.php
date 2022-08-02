<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("Location: ../index.php");
}

require_once '../database.php';
$db = $conn->prepare('SELECT MAX(artID) FROM evc353_1.Article');
$db->execute();
$newrow = ($db->fetch())[0] + 1;

if (isset($_POST['art-sub-btn'])) {
    $summaryList = $conn->prepare('SELECT summary 
                                    FROM evc353_1.Article');
    $summaryList->execute();
    $loop = true;
    while ($loop && $row = $summaryList->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
        if (strcmp($_POST['summ'], $row['summary']) == 0)
            $loop = false;
    if ($loop) {
        $query = $conn->prepare('SELECT COUNT(*) 
                                    FROM evc353_1.Organization
                                    WHERE delegateUID = :userID');
        $query->bindParam(":userID", $_SESSION["uID"]);
        $query->execute();
        $uType = $query->fetchColumn();
        $userType = "Researcher";
        if ($uType == 1) {
            $userType = "Organization";
        }
        $db = $conn->prepare('SELECT authID 
                                FROM evc353_1.Author, evc353_1.Researcher
                                WHERE Author.rID = Researcher.rID AND Researcher.uID = :userID');
        $db->bindParam(":userID", $_SESSION["uID"]);
        $db->execute();
        $row = $db->fetchColumn();
        $article = $conn->prepare('INSERT INTO evc353_1.Article 
                                VALUES(:articleID, :pubDate, :majorTop, :minorTop, :summ, :article, :utype, :authid, "displayed", null)');
        $date = date("Y-m-d");
        $article->bindParam(':articleID', $newrow);
        $article->bindParam(':pubDate', $date);
        $article->bindParam(':majorTop', $_POST["majorTop"]);
        $article->bindParam(':minorTop', $_POST["minorTop"]);
        $article->bindParam(':summ', $_POST["summ"]);
        $article->bindParam(':article', $_POST["article"]);
        $article->bindParam(':utype', $userType);
        $article->bindParam(':authid', $row);

        $article->execute();

        $emailList = $conn->prepare('SELECT emailAddress 
                                    FROM evc353_1.User
                                    WHERE User.uID IN (SELECT Author_Subs.uID 
                                                        FROM evc353_1.Author_Subs, evc353_1.Researcher, evc353_1.Author
                                                        WHERE Researcher.rID = Author.rID AND Author.authID = Author_Subs.authID)');
        $emailList->execute();

        $to = "";
        while ($row = $emailList->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
            $to .= $row['emailAddress'] . ",";

        if (strlen($to) > 0)
            substr($to, 0, strlen($to) - 1);

        $rName = $conn->prepare('SELECT CONCAT(User.fName," ", User.lName) AS rName
                                            FROM evc353_1.User, evc353_1.Researcher
                                            WHERE User.uID = Researcher.uID AND Researcher.rID = Researcher.rID');
        $rName->execute();
        $researcherName = $rName->fetchColumn();

        $subject = "New Article Added";
        $txt = "Check out the new article added by the researcher " . $researcherName . ".";
        $headers = "From: bhavyaruparelia@gmail.com";

        mail($to, $subject, $txt, $headers);

        $UIDList = $conn->prepare('SELECT uID 
                                    FROM evc353_1.User
                                    WHERE User.uID IN (SELECT Author_Subs.uID 
                                                        FROM evc353_1.Author_Subs, evc353_1.Researcher, evc353_1.Author
                                                        WHERE Researcher.rID = Author.rID AND Author.authID = Author_Subs.authID)');
        $UIDList->execute();

        if ($uType == 1) {
            $oName = $conn->prepare('SELECT organizationName 
                                        FROM evc353_1.User
                                        WHERE User.uID = $_SESSION["uID"]');
            $oName->execute();
            $orgName = $oName->fetchColumn();
            $researcherName = "[" . $orgName . "]";
        } else {
            $researcherName = "[" . $researcherName . "]";
        }

        $subject = $researcherName . " " . $_POST["majorTop"];

        while ($tuple = $UIDList->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $sentEmail = $conn->prepare('INSERT INTO evc353_1.Sent_Emails 
                                            VALUES(":artid, :curDate, :receiverUid, :sub)');
            $date = date("Y-m-d") . " " . date("H:i:sa");
            $sentEmail->bindParam(':artid', $newrow);
            $sentEmail->bindParam(':curDate', $date);
            $sentEmail->bindParam(':receiverUid', $tuple["uID"]);
            $sentEmail->bindParam(':sub', $subject);
        }

        header("Location: researcher.php");
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
                        <a class="navbar-name" aria-current="page" href="researcher.php">My Articles <i class="bi bi-journal-text"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="researcher_add.php">Add Articles <i class="bi bi-plus-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="researcher_edit.php">Edit Articles <i class="bi bi-pencil-square"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="researcher_delete.php">Delete Articles <i class="bi bi-dash-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="../Login/login.php">Logout <i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pt-3">
        <h1 class="display-4">ADD ARTICLE</h1>
        <form class="form-inline" action="researcher_add.php" method="POST">
            <div class="row mt-2">
                <label for="majorTop" class="col-form-label mt-2">Major Topic:</label>
                <div class="input-group col-lg my-md-none">
                    <textarea id="majorTop" name="majorTop" type="text" class="form-control" rows="2" autocomplete="off" required></textarea>
                </div>
            </div>
            <div class="row">
                <label for="minorTop" class="col-form-label  mt-2">Minor Topic:</label>
                <div class="input-group col-lg my-md-none">
                    <textarea id="minorTop" name="minorTop" type="text" class="form-control" rows="2" autocomplete="off" required></textarea>
                </div>
            </div>

            <div class="row">
                <label for="summ" class="col-form-label mt-2">Summary:</label>
                <div class="input-group col-lg my-md-none">
                    <textarea id="summ" name="summ" type="text" class="form-control texthover" maxlength="100" rows="3" autocomplete="off" required></textarea>
                </div>
            </div>

            <div class="row">
                <label for="article" class="col-form-label mt-2">Article:</label>
                <div class="input-group col-lg my-md-none">
                    <textarea id="article" name="article" type="text" class="form-control texthover" rows="6" autocomplete="off" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-dark my-3" name="art-sub-btn" id="submit">
                Add Article!
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>