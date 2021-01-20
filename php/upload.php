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

if (isset($_POST['btn'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $type = $_POST['type'];

    if(empty($fileActualExt)){
        header("location:/sna/html/fichiers.php?msg=Veuiller choisir un fichier");
        exit();
    }

    if(empty($type)) {
        header("location:/sna/html/fichiers.php?msg=Veuiller choisir un type");
        exit();
    }

    if($type == "flash") {
        $url = "/sna/html/fichiers.php?flash=1&";
    }else{
        $url = "/sna/html/fichiers.php?tab=1&";
    }

    if ($fileError === 0) {

        $fileDestination = '../uploads/' . $_SESSION['service'] . '/' . $fileName;
        move_uploaded_file($fileTmpName, $fileDestination);
    }

    $row2 = mysqli_fetch_array(mysqli_query($conn, "select droit, nomService from login where cin = '" . $_SESSION['User'] . "'"));
    if ($row2['droit'] == 'v' || $row2['droit'] == 'x') {
        $etat = 'validé';
    } else {
        $etat = 'attente';
    }

    $date = date('Y-m-d H:i:s');

    $result1 = mysqli_query($conn, "select * from fichiers where nomFichier = '" . $fileName . "' and emplacement = '" . $fileDestination . "' and type = '". $type ."'") or die(mysqli_error($conn));
    $row2 = mysqli_fetch_array(mysqli_query($conn,"select droit from login where cin = '".$_SESSION['User']."'"));
    
    if ($row1 = mysqli_fetch_array($result1)) {
            $stmt = $conn->prepare("delete from fichiers where idFichier = ?");
            $stmt->bind_param("i", $row1['idFichier']);
            $stmt->execute();

            $stmt = $conn->prepare("insert into fichiers(nomFichier, emplacement, DateModif, etat, type, nomService, cin) values(?, ?, ?, ?, ?, ?, ?)") or die(mysqli_error($conn));
            $stmt->bind_param("sssssss", $fileName, $fileDestination, $date, $etat, $type, $_SESSION['service'], $_SESSION['User']);
            $stmt->execute();
            header("location:".$url."msg=Fichier téléchargé avec succès");
    } else {
            $stmt = $conn->prepare("insert into fichiers(nomFichier, emplacement, DatePub, etat, type, nomService, cin) values(?, ?, ?, ?, ?, ?, ?)") or die(mysqli_error($conn));
            $stmt->bind_param("sssssss", $fileName, $fileDestination, $date, $etat, $type, $_SESSION['service'], $_SESSION['User']);
            $stmt->execute();
            header("location:".$url."msg=Fichier téléchargé avec succès");
    }
}
?>
