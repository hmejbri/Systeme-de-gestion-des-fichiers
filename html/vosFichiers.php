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
   <script src="../js/script.js"></script>
   <script src="../js/jquery-3.5.1.min.js"></script>
   <script src="../js/popper.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
<body>
   <!-- nav bar -->
   <nav id="navbar" class="navbar navbar-light bg-info">
      <a id="logo" class="navbar-brand" href="fichiers.php">
      <img src="../images/sna.png" width="200" height="50" class="d-inline-block align-top" alt="SNA logo">
      </a>
      <ul id="navbar-right" class="nav justify-content-end">
         <li class="nav-item">
            <button type="button" class="btn btn-primary" onclick="window.location.href='vosFichiers.php'">
            Vos fichiers <span class="badge badge-light">
                  <?php
                  session_start();
                  $_SESSION['nbFile'] = 0;

                  ($result = mysqli_query($conn, "select * from fichiers where cin = '" . $_SESSION['User'] . "'")) or die(mysqli_error($conn));
                  $nb = 0;
                  while ($row = mysqli_fetch_array($result)) {
                      $nb = $nb + 1;
                  }
                  echo $nb;
                  ?>
               </span>&nbsp;
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
            $result = mysqli_query($conn, "select * from fichiers where cin = '" . $_SESSION['User'] . "' order by idFichier DESC;") or die(mysqli_error($conn));
            if ($nb == 0) {
                echo "<center><h6>Aucun fichier</h6></center>";
            }
            while ($row = mysqli_fetch_array($result)) { ?>

            <form id="<?php echo $i ?>" action="../php/deleteFile.php" method="post">
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
                  <input type="text" value="<?php echo $row['emplacement']; ?>" name="emplacementF" hidden>

                  <div class="col-3">
                     <a href="
                     <?php
                     $result1 = mysqli_query($conn, "select * from fichiers where idFichier = '" . $row['idFichier'] . "'");
                     $row1 = mysqli_fetch_array($result1);
                     if ($row1['etat'] != 'refusé') {
                        echo $row['emplacement'];
                     }
                     ?>" class="alert-link" name="nomF" id="nomF" 
                     <?php if ($row1['etat'] != 'refusé') {
                        echo "download";
                     } ?>><?php echo $row['nomFichier']; ?></a>
                  </div>
                  <div class="col-4">
                     <div class="badge badge-primary text-wrap" style="width: 13rem;">
                        <?php if ($row1['DateModif'] == null) {
                           echo "Date Publication : " . $row1['DatePub'];
                        } else {
                           echo "Date Modification : " . $row1['DateModif'];
                        } ?>
                     </div>
                  </div>
                  <div class="col-2">
                     <?php if ($row1['etat'] == 'attente') { ?>
                        <span class="badge badge-warning">En attente</span>
                     <?php } else if($row1['etat'] == 'refusé'){ ?>
                        <span class="badge badge-danger" style="width:60%">Refusé</span>
                     <?php }else{ ?>
                        <span class="badge badge-success" style="width:60%">Validé</span>
                     <?php } ?>
                  </div>
                  <?php if ($row1['etat'] == 'refusé') { ?>
                  <div class="col-1">
                     <button type="button" class="btn btn-dark btn-sm" data-toggle="popover" title="raison : " data-content="<?php echo $row1['commentaire']; ?>">Raison</button>               
                  </div>
                     <?php } ?>
                  <?php if($row1['etat'] != 'refusé') { ?>
                     <div class="col-1"></div>
                  <?php } ?>
                  <div class="col-1">
                     <a href="javascript: submitform()" id="submit"><img src="../images/delete.png" width="70%" height="70%" onclick="submittheform(<?php echo $i ?>)"></a>
                  </div>
                  <?php if (isset($_POST['delete'])) {
                     $rs = mysqli_query($conn, "delete from fichiers where idFichier = '" . $row1['idFichier'] . "'");
                  } ?>

                  <input type="text" name="id" value="<?php echo $row['idFichier']; ?>" hidden>

                  <?php $i = $i + 1; ?>

                  <hr>

               </div>
               <hr>
            </form>
            <?php }
            ?>
         </div>
      </div>
   </div>

   <script>
      $(document).ready(function(){
         $('[data-toggle="popover"]').popover();   
      });

      function submittheform(id) {
         document.getElementById(id).submit();
      }
   </script>
</body>
</html>