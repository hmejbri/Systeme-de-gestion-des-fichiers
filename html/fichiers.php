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
   <script src="../js/jquery-3.5.1.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
</head>
<body>
   <!-- nav bar -->
   <nav id="navbar" class="navbar navbar-light bg-info">
      <a id="logo" class="navbar-brand" href="#">
      <img src="../images/sna.png" width="200" height="50" class="d-inline-block align-top" alt="sna logo">
      </a>
      <ul class="nav justify-content-end" id="navbar-right">
         <?php
            session_start();
            ($result = mysqli_query($conn, "select droit from login where cin = '" . $_SESSION['User'] . "'")) or die(mysqli_error($conn));
            $droit = mysqli_fetch_array($result);
            if ($droit['droit'] == "i") { ?>
         <li class="nav-item">
            <button type="button" class="btn btn-primary" onclick="window.location.href='vosFichiers.php'">
               Vos fichiers <span class="badge badge-light">
               <?php
                  $result = mysqli_query($conn, "select * from fichiers where cin = '" . $_SESSION['User'] . "'") or die(mysqli_error($conn));
                  $nb = 0;
                  while ($row = mysqli_fetch_array($result)) {
                      $nb = $nb + 1;
                  }
                  echo $nb;
                  ?>
               </span>&nbsp;
         </li>
         <?php } else if($droit['droit'] == 'v') { ?>
         <li class="nav-item">
         <button type="button" class="btn btn-primary" onclick="window.location.href='attente.php'">
         Fichiers en attente
         <span class="badge badge-light">
         <?php
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
         <?php }else if($droit['droit'] == 'a') { ?>
            <li class="nav-item">
               <button type="button" class="btn btn-primary" onclick="window.location.href='parametres.php'">Paramétres des utilisateurs</button>
            </li>
         <?php } ?>
         &nbsp;&nbsp;&nbsp;
         <li class="nav-item">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='../'">Deconnexion</button>
         </li>
      </ul>
   </nav>
   <div class="container">
      <br><br><br><br><br>
      <!-- nom et prenom -->
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
      <br>
      <?php
         if (empty($_COOKIE['service'])) {
            $_SESSION['service'] = $row['nomService'];
         } else {
            $_SESSION['service'] = $_COOKIE['service'];
         } 
         if($droit['droit'] == 'i' || $droit['droit'] == 'v') {
         ?>
      <!-- Upload -->
      <div class="row">
         <div class="col-sm-2"></div>
         <div class="col-sm-3">
            <label for="file" style="display: inline;">Déposer/Modifier un fichier :</label>
            <p class="text-danger" style="font-size :11px;">(Télécharger le fichier avec le même nom pour le modifier)</p>
         </div>
         <div class="col-sm-7" style="display:inline;">
            <form action="../php/upload.php" method="POST" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-5">
                     <input type="file" name="file" class="form-control-file" id="file">
                  </div>
                  <div class="col-3">
                     <div class="dropdown">
                        <select name="type" class="form-control">
                           <option selected disabled>Type</option>
                           <option value="flash" >Flash</option>
                           <option value="tableau de bord">Tableau de bord</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-4">
                     <button type="submit" name="btn" class="btn btn-info">Confirmer</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <?php if (@$_GET['msg'] == true) { ?>
      <div class="alert-light text-danger text-center py-3"><?php echo $_GET['msg']; ?></div>
      <?php } else { ?>
      <br>
      <?php }} ?>
      <!-- Services -->
      <div class="row">
         <div class="col-3">
            <div id="services"></div>
         </div>

         <!-- les fichiers -->
            <div class="col-9">
               <div id="files"></div>
            </div>
      </div>
   </div>
   <br><br><br><br><br>
   <script>     
      function reply_click(clicked_id){
         document.cookie = "service = " + clicked_id;
      }

      $(document).ready(function(){
         $.ajax({
            url: '../php/ajax/load-files.php',
            type: 'post',
            data: {type: 'flash'},
            success: function(result) {
               $("#files").html(result);
            }
         });

         $.ajax({
            url: '../php/ajax/load-services.php',
            type: 'post',
            data: {srv: "<?php echo $_SESSION['service'] ?>"},
            success: function(result) {
                $("#services").html(result);
            }
        });
       
      });

   </script>
   <script src="../js/fichiers.js"></script>
   <script src="../js/script.js"></script>
</body>
</html>