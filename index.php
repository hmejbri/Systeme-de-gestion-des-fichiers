<?php
   session_start();
   session_unset();
   session_destroy();
   setcookie("service","", time() - 3600);
?>
<!DOCTYPE html>
<head>
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta charset="UTF-8">
</head>
<body>
   <nav class="navbar navbar-light bg-info">
      <a class="navbar-brand" href="#">
      <img src="images/sna.png" width="200" height="50" class="d-inline-block align-top" alt=""> &nbsp;&nbsp;
      </a>
   </nav>
   <div class="container">
      <br><br><br>
      <div class="row">
         <div class="col-sm-3"></div>
         <div class="col-sm-6" style="background-color:azure;"></div>
         <br>
      </div>
      <div class="row">
         <div class="col-sm-3"></div>
         <div class="col-sm-6" style="background-color:azure;">
            <div class="col">
               <?php 
                  if(@$_GET['Empty']==true)
                  {
               ?>
               <div class="alert-light text-danger text-center py-3"><?php echo $_GET['Empty'] ?></div>
               <?php
                  }
                  ?>
               <?php 
                  if(@$_GET['Invalid']==true)
                  {
                  ?>
               <div class="alert-light text-danger text-center py-3"><?php echo $_GET['Invalid'] ?></div>
               <?php
                  }
                  ?>
               <form action="php/connect.php" method="post">
                  <div class="form-group">
                     <label for="cin">Login</label>
                     <input type="text" class="form-control" id="cin" name="cin" aria-describedby="emailHelp">
                     <small id="emailHelp" class="form-text text-muted">Entrer votre CIN.</small>
                     <small id="emailHelp" class="form-text text-muted"></small>
                  </div>
                  <div class="form-group">
                     <label for="mdp">Mot de passe</label>
                     <input type="password" class="form-control" id="mdp" name="mdp">
                  </div>
                  <div class="form-group form-check">
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-sm-5"></div>
                     <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary" name="connexion">Connexion</button>
                     </div>
                     <button type="button" class="btn btn-primary" onclick="window.location.href='html/creerCompte.php'">Créer un compte</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-3"></div>
         <div class="col-sm-6" style="background-color:azure;"></div>
         <br><br>
      </div>
   </div>
</body>
</html>