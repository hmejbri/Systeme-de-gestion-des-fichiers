<?php
$user = 'root';
$pass = '';
$db = 'sna';

$conn = new mysqli('localhost', $user, $pass, $db);
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die('connection Failed : ' . $conn->connect_error);
}

session_start();

$services = '';

for($i=0;$i<$_POST['nb'];$i++) {
    $nomService = "service". $i;
    $services = $services . $_POST[$nomService] . ',';
}

$stmt = $conn->prepare("update login set nom = ? , prenom = ? , droit = ? , nomService = ? where cin = ?") or die(mysqli_error($conn));
$stmt->bind_param("sssss", $_POST['nom'], $_POST['prenom'], $_POST['droit'], $services, $_SESSION['recherche']);
$stmt->execute();

header("location: ../html/parametres.php")
?>