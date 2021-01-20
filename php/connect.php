<?php
$cin = $_POST['cin'];
$mdp = $_POST['mdp'];

$user = 'root';
$pass = '';
$db = 'sna';

$conn = new mysqli('localhost', $user, $pass, $db);
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die('connection Failed : ' . $conn->connect_error);
} else {
    session_start();
    setcookie("service", "", time() - 3600);
    if (isset($_POST['connexion'])) {
        if (empty($cin) || empty($mdp)) {
            header("location:/sna/index.php?Empty= veuillez saisir vos informations");
        } else {
            $stmt = $conn->prepare("select * from login where cin = ? and mdp = ?");
            $stmt->bind_param("ss", $cin, $mdp);
            $stmt->execute();
            $stmt_result = $stmt->get_result();
            if ($stmt_result->num_rows > 0) {
                $_SESSION['User'] = $cin;
                header("location:/sna/html/fichiers.php");
            } else {
                header("location:/sna/index.php?Invalid=Login ou mot de passe incorrecte");
            }
        }
    }
}

?>
