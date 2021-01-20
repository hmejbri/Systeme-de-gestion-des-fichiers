<?php
    $user = 'root';
    $pass = '';
    $db = 'sna';
                        
    $conn = new mysqli('localhost', $user, $pass, $db);
    if($conn->connect_error){
        echo "$conn->connect_error";
        die('connection Failed : '.$conn->connect_error);
    }else {
        session_start();
        if(isset($_POST['valider'])) {
            $stmt = $conn->prepare("update fichiers set etat='validé' where idFichier = ?") or die(mysqli_error($conn));
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt_result = $stmt->get_result();
        }else{
            $row = mysqli_fetch_array(mysqli_query($conn,"select emplacement from fichiers where idFichier = '".$_POST['id']."'"));
            unlink($row['emplacement']);
            $stmt = $conn->prepare("update fichiers set etat='refusé' where idFichier = ?") or die(mysqli_error($conn));
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt1 = $conn->prepare("update fichiers set commentaire = ? where idFichier = ?") or die(mysqli_error($conn));
            $stmt1->bind_param("si", $_POST['comm'], $_POST['id']);
            $stmt1->execute();
        }
        header("location:/sna/html/attente.php");
    }
?>