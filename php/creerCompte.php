<?php
$cin = $_POST['cin'];
$mdp = $_POST['mdp1'];
$mdp2 = $_POST['mdp2'];


if($mdp == $mdp2) {
    $user = 'root';
    $pass = '';
    $db = 'sna';

    $conn = new mysqli('localhost', $user, $pass, $db);
    if($conn->connect_error){
        echo "$conn->connect_error";
        die('connection Failed : '.$conn->connect_error);
    }else {
        $stmt1 = $conn->prepare("select * from login where cin = ?");
        $stmt1->bind_param("s", $cin);
        $stmt1->execute();
        $stmt1_result = $stmt1->get_result();
        if($stmt1_result->num_rows > 0){
            $data = $stmt1_result->fetch_assoc();

            if($data['mdp'] != null) {
                header("location:/sna/html/creerCompte.php?cree=Compte deja crée");
            } else {
            $stmt = $conn->prepare("update login set mdp = ? where cin = ?");
            $stmt->bind_param("ss", $mdp, $cin);
            $stmt->execute();
            header("location:/sna/html/creerCompte.php?succes=Compte a été crée avec succès");
            $stmt->close();
            $conn->close();
            }
        }else {
            header("location:/sna/html/creerCompte.php?erreur=Utilisateur non reconnu");
        }
    }
}else {
    header("location:/sna/html/creerCompte.php?erreur=Vérifiez vos informations");
}

?>