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
?>
<!DOCTYPE html>
<head>
   <link rel="stylesheet" href="../css/bootstrap.min.css">
   <link rel="stylesheet" href="../css/style.css">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta charset="UTF-8">
</head>
<body>
   <!-- nav bar -->
   <nav id="navbar" class="navbar navbar-light bg-info">
      <a id="logo" class="navbar-brand" href="fichiers.php">
      <img src="../images/sna.png" width="200" height="50" class="d-inline-block align-top" alt="SNA logo">
      </a>
      <ul class="nav justify-content-end" id="navbar-right">
        <li class="nav-item">
            <button type="button" class="btn btn-primary" onclick="window.location.href='parametres.php'">Paramétres des utilisateurs</button>
        </li>
         &nbsp;&nbsp;&nbsp;
         <li class="nav-item">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='../'">Deconnexion</button>
         </li>
      </ul>
   </nav>
   <div class="container">
   <br><br><br><br><br>

      <div class="row">
         <div class="col-sm-1"><img src="" height="85" width="85"></div>
         <div class="col-sm-3">
            <?php
            if (!isset($_SESSION['User'])) {
                die(header("location:/sna/index.php"));
            }

            $stmt = $conn->prepare("select nom,prenom,nomService from login where cin = ?");
            $stmt->bind_param("s", $_SESSION['User']);
            $stmt->execute();
            $stmt_result = $stmt->get_result();
            $row = $stmt_result->fetch_array();
            if ($stmt_result->num_rows > 0) { ?>
            <br>
            <h4 id="pre" style="display: inline;color: darkblue;">
               <?php echo $row['prenom']; ?>
            </h4>
            <h5 id="nom" style="color: darkblue;">
               <?php echo $row['nom']; ?>
            </h5>
            <?php }
            ?>
         </div>
      </div>
      
      <br><br>

      <div class="row">
            <div class="col-2"></div>
            <div class="col-4">
                <button type="button" class="btn btn-outline-primary" style="width:90%" id="modifier">Modifier un utilisateur</button>
            </div>
            <div class="col-4">
                <button type="button" class="btn btn-outline-primary" style="width:90%" id="ajout">ajouter un utilisateur</button>
            </div>
      </div>
      
      <div id="contenu"></div>


   <script src="../js/script.js"></script>
   <script src="../js/jquery-3.5.1.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>

   <script>
$(document).ready(function(){
    $("#modifier").click(function() {
          $.ajax({
             url: '../php/ajax/modifier.php',
             type: 'post',
             data: {},
             success: function(result) {
                $("#contenu").html(result);
             }
          });
   
       });
   
       $("#ajout").click(function() {
          $.ajax({
             url: '../php/ajax/ajoutUtilisateur.php',
             type: 'post',
             data: {},
             success: function(result) {
                $("#contenu").html(result);
             }
          });
   
       });

});
   </script>
</body>
</html>