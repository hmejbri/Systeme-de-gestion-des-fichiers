<?php
   $user = 'root';
   $pass = '';
   $db = 'sna';
   
   $conn = new mysqli('localhost', $user, $pass, $db);
   if ($conn->connect_error) {
       echo "$conn->connect_error";
       die('connection Failed : ' . $conn->connect_error);
   }
   
   $type = $_POST['type'];
   
   session_start();
   ?>
            <br>
            <ul class="nav nav-tabs nav-justified justify-content-center">
               <li class="nav-item">
                  <a class="nav-link
                     <?php
                        if($type != "tableau de bord") {
                        ?>
                     active
                     <?php } ?>
                     " name="flash" id="flash" href="javascript:;">Flash</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link
                     <?php
                        if($type == "tableau de bord") {
                        ?>
                     active
                     <?php } ?>
                     " name="tab" id="tab" href="javascript:;">Tableau de bord</a>
               </li>
            </ul>
            <br>
   <?php
      if (empty($_SESSION['service'])) {
         $result = mysqli_query($conn, "select * from fichiers where etat='validé' and type = '".$type."' and nomService like '%(select nomService from login where cin = '" . $_SESSION['User'] . "')%' order by idFichier DESC;");
      } else {
         $result = mysqli_query($conn, "select * from fichiers where etat='validé' and type = '".$type."' and nomService = '" . $_SESSION['service'] . "' order by idFichier DESC");
      }
      while ($row = mysqli_fetch_array($result)) {
      ?>
   <div class="row">
      <div class="col-1">
         <img src="
            <?php
               $fileExt = explode('.', $row['nomFichier']);
               $fileActualExt = strtolower(end($fileExt));
               if ($fileActualExt == "xls" || $fileActualExt == "xml" || $fileActualExt == "xlsx") {
                   echo "../images/excel.png";
               } else if ($fileActualExt == "ppt" || $fileActualExt == "pptx") {
                   echo "../images/powerpoint.png";
               } else if ($fileActualExt == "docx" || $fileActualExt == "doc") {
                   echo "../images/word.png";
               } else {
                   echo "../images/file.png";
               }
               ?>
            " href="" width="35" height="35">
      </div>
      <div class="col-4">
         <a href="<?php echo $row['emplacement']; ?>" class="alert-link" style="word-wrap: break-word;" download><?php echo $row['nomFichier']; ?></a>
      </div>
      <div class="col-4">
         <small style="word-wrap: break-word;" >
         Publiée par :
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
         <div class="badge badge-primary text-wrap" style="width: 100%;">
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
   </div>
   <hr>
   <?php } ?>
<script>
   $("#flash").click(function() {
          $.ajax({
             url: '../php/ajax/load-files.php',
             type: 'post',
             data: {type: 'flash'},
             success: function(result) {
                $("#files").html(result);
             }
          });
   
       });
   
       $("#tab").click(function() {
          $.ajax({
             url: '../php/ajax/load-files.php',
             type: 'post',
             data: {type: 'tableau de bord'},
             success: function(result) {
                $("#files").html(result);
             }
          });
   
       });
</script>