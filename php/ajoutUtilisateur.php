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


$stmt = $conn->prepare("insert into login(cin,nom,prenom,nomService) values(?, ?, ?, ?)") or die(mysqli_error($conn));
$stmt->bind_param("ssss", $_POST['cin'], $_POST['nom'], $_POST['prenom'], $services);
$stmt->execute();

header("location: ../html/parametres.php");
?>