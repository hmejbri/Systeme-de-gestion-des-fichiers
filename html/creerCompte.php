<?php
   session_start();
   session_unset();
   session_destroy();
   ?>
<html>
   <head>
      <link rel="stylesheet" href="../css/bootstrap.min.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="UTF-8">
   </head>
   <body>
      <nav class="navbar navbar-light bg-info">
         <a class="navbar-brand" href="#">
         <img src="../images/sna.png" width="200" height="50" class="d-inline-block align-top" alt=""> &nbsp;&nbsp;
         </a>
      </nav>
      <div class="container">
         <br>
         <a href="../index.php"><img src="../images/back.png" width="50" height="40"></a>
         <br><br><br>
         <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6" style="background-color:#f0ffff;"></div>
            <br>
         </div>
         <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6" style="background-color:azure;">
               <div class="col" style="background-color:azure;">
                  <?php
                     if(@$_GET['cree']==true)
                     {
                  ?>
                  <div class="alert-light text-danger text-center py-3"><?php echo $_GET['cree'] ?></div>
                  <?php
                     }
                  ?>
                  <?php
                     if(@$_GET['succes']==true)
                     {
                  ?>
                  <div class="alert-light text-danger text-center py-3"><?php echo $_GET['succes'] ?></div>
                  <?php
                     }
                  ?>
                  <?php
                     if(@$_GET['erreur']==true)
                     {
                  ?>
                  <div class="alert-light text-danger text-center py-3"><?php echo $_GET['erreur'] ?></div>
                  <?php
                     }
                  ?>

                  <form action="../php/creerCompte.php" method="POST">
                     <div class="form-group row">
                        <label for="cin" class="col-sm-4 col-form-label">CIN</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" id="cin" name="cin">
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="mdp1" class="col-sm-4 col-form-label">Mot de passe</label>
                        <div class="col-sm-8">
                           <input type="password" class="form-control" id="mdp1" name="mdp1" pattern=".{6,}" title="mot de passe doit contenir plus que 5 caractères">
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="mdp2" class="col-sm-4 col-form-label">Confirmer votre mot de passe</label>
                        <div class="col-sm-8">
                           <input type="password" class="form-control" id="mdp2" name="mdp2">
                        </div>
                     </div>
                     <div class="form-group row">
                        <div class="col-6"></div>
                        <button type="submit" id="btn" class="btn btn-primary">Créer votre compte</button>
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