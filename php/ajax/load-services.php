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
   $srv = $_POST['srv'];
?>
            <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
               <a class="nav-link disabled" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true" aria-disabled="false">Les services : </a>
               <hr>
               <?php
               $result = mysqli_query($conn, "select * from services");
               while ($row = mysqli_fetch_array($result)) {
                   $result1 = mysqli_query($conn, "select * from login where cin = '" . $_SESSION['User'] . "'");
                   $row1 = mysqli_fetch_array($result1);
                   ?>
               <a class="nav-link 
                    <?php
                    if($row1['droit'] == "v" || $row1['droit'] == "i" || empty($row1['droit'])) {
                        if (strpos(strtolower($row1['nomService']), strtolower($row['nomService'])) === false) {
                    ?>
                        disabled
                    <?php }else{ 
                        if ($srv == $row['nomService']) { 
                            $_SESSION['service'] = $srv;
                    ?>
                        active
                    <?php
                    }}
                    }else{
                        if ($srv == $row['nomService']) { 
                            $_SESSION['service'] = $srv; 
                    ?>
                        active
                    <?php } }?>

                  " data-toggle="pill" href="fichiers.php" role="tab" aria-controls="v-pills-profile" aria-selected="false" id="<?php echo $row['nomService']; ?>" onclick="reply_click(this.id)"><?php echo $row['nomService']; ?></a>
               <?php
               }
               ?>
            </div>
        

<script>

$(document).ready(function(){
    <?php
        $result0 = mysqli_query($conn, "select * from services");
        while($row0 = mysqli_fetch_array($result0)) {
    ?>
         $('#<?php echo $row0['nomService'] ?>').click(function(e){
            e.preventDefault();
            $.ajax({
                  url: '../php/ajax/load-services.php',
                  type: 'post',
                  data: {srv: "<?php echo $row0['nomService'] ?>"},
                  success: function(result) {
                     $("#services").html(result);
                  }
            }); 
         });
        <?php } ?>

        $.ajax({
            url: '../php/ajax/load-files.php',
            type: 'post',
            data: {type: 'flash'},
            success: function(result) {
               $("#files").html(result);
            }
         });
});

</script>