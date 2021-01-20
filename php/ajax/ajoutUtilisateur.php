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

<br><br>
<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <form action="../php/ajoutUtilisateur.php" method="post">
        <div class="form-group">
            <label for="cin">CIN</label>
            <input type="text" class="form-control" id="cin" name="cin" placeholder="01234567">
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" placeholder="Nom" name="nom" id="nom">
                </div>
                <div class="col">
                <label for="prenom">Prenom</label>
                <input type="text" class="form-control" placeholder="Prenom" name="prenom" id="prenom">
                </div>
            </div>
        </div>
        <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="nb">Nombre de services</label>
                            <input type="text" class="form-control" name="nb" id="nb">
                        </div>
                        <div class="col">
                            <label for="service">Nom de service</label>                          
                            <div id="service1" name="service1"></div>
                        </div>
                    </div>
                </div>
        <button type="submit" class="btn btn-outline-primary" style="width:100%" id="valider">Valider</button>
        </form>
    </div>
</div>

<br><br><br>

<script>
$(document).ready(function(){
    var services = '';
    $("#nb").keyup(function() {
        var text = '';
        for(i=0;i<$("#nb").val();i++) {
            text += '<div class="form-group"><select class="form-control" id="service" name="service'+ i +'">';
                        <?php 
                            $result1 = mysqli_query($conn,"select nomService from services");
                            while($row1 = mysqli_fetch_array($result1)) {
                        ?>
                            var text1 = "<?php echo $row1['nomService'] ?>";
                            text += '<option value="' + text1 + '">' + text1 + '</option>';  
                        <?php } ?>   
                        text += '</select><div id="service" name="service1"></div></div>';
        }
        $("#service1").empty();
        $("#service1").append(text);
    });
});
</script>