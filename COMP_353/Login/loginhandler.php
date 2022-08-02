
<?php
require_once '../database.php';
session_start();
$_SESSION['loggedin'] = true;
$db = $conn->prepare('SELECT * 
                        FROM evc353_1.Special_User, evc353_1.User
                        WHERE Special_User.uID = User.uID');
$db->execute();
$check = true;
while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    if (
        strcmp($row["userName"], $_POST["username"]) == 0 &&
        strcmp($row["password"], $_POST["password"]) == 0 &&
        strcmp($row["userType"], "Regular") != 0 &&
        strcmp($row["accStatus"], "Suspended") != 0
    ) {
        $_SESSION["uID"] = $row["uID"];
        $check = false;
        if (strcmp($row["userType"], "Admin") == 0) {
            header("Location: ../Admin/admin.php");
        } else if (strcmp($row["userType"], "Researcher") == 0) {
            header("Location: ../Researcher/researcher.php");
        } else if (strcmp($row["userType"], "Delegate") == 0) {
            if (str_contains($row["organization"], "Government")) {
                header("Location: ../Organization/organization.php");
            } else {
                header("Location: ../Researcher/researcher.php");
            }
        }
    }
}
if ($check) {
    $_SESSION['loggedin'] = false;
    header("Location: login.php");
}
?>