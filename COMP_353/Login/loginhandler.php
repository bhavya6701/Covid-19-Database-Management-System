
<?php
session_start();
// $_SESSION['loggedin'] = true;
// $db = $conn->prepare('SELECT * 
//                         FROM testdbms.special_user, testdbms.user
//                         WHERE testdbms.special_user.uID = testdbms.user.uID');
// $db->execute();
// while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
//     if (
//         strcmp($row["emailAddress"], $_POST["email"]) == 0 &&
//         strcmp($row["password"], $_POST["password"]) == 0 &&
//         strcmp($row["userType"], "Regular") != 0 &&
//         strcmp($row["accStatus"], "Suspended") != 0
//     ) {
//         if (strcmp($row["userType"], "Admin") == 0) {
//             header("Location: Admin/admin.php");
//         } else if (strcmp($row["userType"], "Researcher") == 0) {
//             header("Location: Researcher/researcher.php");
//         } else if (strcmp($row["userType"], "Delegate") == 0) {
//             if (str_contains($row["organization"], "Government")) {
//                 header("Location: Organization/organization.php");
//             } else {
//                 header("Location: Researcher/researcher.php");
//             }
//         }
//     }
// }
$_SESSION['loggedin'] = false;
header("Location: login.php");
?>