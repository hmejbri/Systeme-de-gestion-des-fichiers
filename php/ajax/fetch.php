<?php
$user = 'root';
$pass = '';
$db = 'sna';

$conn = new mysqli('localhost', $user, $pass, $db);
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die('connection Failed : ' . $conn->connect_error);
}
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "
	SELECT * FROM login 
	WHERE cin LIKE '%".$search."%'
	";
}

$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
$row = mysqli_fetch_array($result);
session_start();
$_SESSION['recherche'] = $row['cin'];
?>
<form action="../php/modifierUtilisateur.php" method="post" id="form">
<div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" placeholder="Nom" name="nom" id="nom" value="<?php echo $row['nom'] ?>">
                        </div>
                        <div class="col">
                        <label for="prenom">Prenom</label>
                        <input type="text" class="form-control" placeholder="Prenom" name="prenom" id="prenom" value="<?php echo $row['prenom'] ?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                    <label for="droit">Droit d'accés</label>
                        <select name="droit" class="form-control">
                            <option value="i" <?php if($row['droit'] == 'i'){ echo "selected";} ?>>Insertion</option>
                            <option value="v" <?php if($row['droit'] == 'v'){ echo "selected";} ?>>Validation</option>                
                            <option value="x" <?php if($row['droit'] == 'x'){ echo "selected";} ?>>Consultation</option>  
                            <option value="a" <?php if($row['droit'] == 'a'){ echo "selected";} ?>>Administrateur</option>                      
                        </select>
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
            </div>
        </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <button type="submit" class="btn btn-outline-primary" style="width:95%" id="valider">Valider</button>
            </div>
        </div>
</form>
<br><br>
        <?php
}
else
{
    ?>
    <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" placeholder="Nom" name="nom" id="nom" disabled>
                            </div>
                            <div class="col">
                            <label for="prenom">Prenom</label>
                            <input type="text" class="form-control" placeholder="Prenom" name="prenom" id="prenom" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                        <label for="droit">Droit d'accés</label>
                            <select name="droit" class="form-control" disabled></select>
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="nb ">Nombre de services</label>
                            <input type="text" class="form-control" name="nb" id="nb" disabled>
                        </div>
                        <div class="col">
                            <label for="service">Nom de service</label>
                            <select class="form-control" id="service" name="service" disabled> 
                            </select>
                            <div id="service1" name="service1"></div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <button type="submit" class="btn btn-outline-primary" style="width:95%" id="valider">Valider</button>
                </div>
            </div>
<br><br>
            <?php
}
?>

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