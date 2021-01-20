<?php
$user = 'root';
$pass = '';
$db = 'sna';

$conn = new mysqli('localhost', $user, $pass, $db);
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die('connection Failed : ' . $conn->connect_error);
}

$result = mysqli_query($conn,"delete from fichiers where idFichier = '".$_POST['idF']."'");
unlink($_POST['emplacementF']);
header("location: ../html/vosFichiers.php");
?>