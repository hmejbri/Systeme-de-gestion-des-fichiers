<?php
$user = 'root';
$pass = '';
$db = 'sna';

$conn = new mysqli('localhost', $user, $pass, $db);
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die('connection Failed : ' . $conn->connect_error);
}
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
            <button type="button" class="btn btn-primary" href="attente.php">
               Fichiers en attente <span class="badge badge-light">
               <?php
               session_start();
               $nb = 0;
               $result0 = mysqli_query($conn,"select * from fichiers where etat = 'attente'");
               while($row0 = mysqli_fetch_array($result0)){
                  $result = mysqli_query($conn, "select * from fichiers where etat = 'attente' and (select nomService from login where cin = '" . $_SESSION['User'] . "') LIKE '%".$row0['nomService']."%' and idFichier = '".$row0['idFichier']."'") or die(mysqli_error($conn));
                  while ($row = mysqli_fetch_array($result)) {
                     $nb = $nb + 1;
                  }
               }
               echo $nb;
               ?>
               </span>
            </button>
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
      
      <?php $i = 0; ?>

      <div class="row">
         <div class="col-2"></div>
         <div class="col-sm-9">
            <?php
            $result0 = mysqli_query($conn,"select * from fichiers where etat = 'attente'");
            while($row0 = mysqli_fetch_array($result0)){
               $result = mysqli_query($conn, "select * from fichiers where etat = 'attente' and (select nomService from login where cin = '" . $_SESSION['User'] . "') LIKE '%".$row0['nomService']."%' and idFichier = '".$row0['idFichier']."'") or die(mysqli_error($conn));
            if ($nb == 0) {
                echo "<center><h6>Aucun fichier</h6></center>";
            }
            while ($row = mysqli_fetch_array($result)) { ?>
    
            <form if="<?php echo $i; ?>" action="../php/validerFichier.php" method="post">

            <div class="row">
               <div class="col-1">
                  <img src="
                     <?php
                     $fileExt = explode('.', $row['nomFichier']);
                     $fileActualExt = strtolower(end($fileExt));
                     if ($fileActualExt == "xls" || $fileActualExt == "xml" || $fileActualExt == "xlsx") {
                         echo "../images/excel.png";
                     } elseif ($fileActualExt == "ppt" || $fileActualExt == "pptx") {
                         echo "../images/powerpoint.png";
                     } elseif ($fileActualExt == "docx" || $fileActualExt == "doc") {
                         echo "../images/word.png";
                     } else {
                         echo "../images/file.png";
                     }
                     ?>
                  " href="" width="35" height="35">
               </div>

               <input type="text" value="<?php echo $row['idFichier']; ?>" name="idF" hidden>

               <div class="col-2">
                  <a href="<?php echo $row['emplacement']; ?>" class="alert-link" name="nomF" id="nomF" download><?php echo $row['nomFichier']; ?></a>
               </div>
               <div class="col-2">
                  <small>
                     Publiée par :
                     <input type="text" value="<?php echo $row['idFichier']; ?>" name="idF" hidden>
                     <?php
                     $result2 = mysqli_query($conn, "select * from login where cin = '" . $row['cin'] . "'");
                     $row2 = mysqli_fetch_array($result2);
                     echo $row2['nom'];
                     echo " ";
                     echo $row2['prenom'];
                     ?>
                  </small>
               </div>
               <div class="col-3">
                  <div class="badge badge-primary text-wrap" style="width: 13rem;">
                     <?php
                     $result1 = mysqli_query($conn, "select * from fichiers where idFichier = '" . $row['idFichier'] . "'");
                     $row1 = mysqli_fetch_array($result1);
                     if ($row1['DateModif'] == null) {
                         echo "Date Publication : " . $row1['DatePub'];
                     } else {
                         echo "Date Modification : " . $row1['DateModif'];
                     }
                     ?>
                  </div>
               </div>
               <div class="col-2">
                  <span class="badge badge-warning">En attente</span>
               </div>
               <div class="col-1">
                  <button type="submit" class="btn btn-success btn-sm" name="valider">Valider</button>
               </div>
               
               <div class="col-1">
               <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#staticBackdrop">
                Réfuser
               </button>

               <!-- Modal -->
               <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                     <h5 class="modal-title" id="staticBackdropLabel">Commentaire</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                     </div>
                     <div class="modal-body">
                     <textarea rows="7" cols="50" name="comm"></textarea>
                     </div>
                     <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                     <button type="vaider" name="refuser" class="btn btn-primary">Valider</button>
                     </div>
                  </div>
               </div>
               </div>
               </div>

               <input type="text" name="id" value="<?php echo $row['idFichier']; ?>" hidden>

               <?php $i = $i + 1; ?>

               <hr>

            </div>
            </form>
            <hr>
            <?php }}
            ?>
         </div>
      </div>
   </div>
   <script src="../js/script.js"></script>
   <script src="../js/jquery-3.5.1.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
</body>
</html>