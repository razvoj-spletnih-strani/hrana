<!DOCTYPE html>
<html lang="sl">
  <head>
    <title>Hrana - prijava/odjava na prehrano</title>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="template/css/hrana.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
      <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
          <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                  <a class="nav-link" href="index.php"><i class="fas fa-home"></i></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="index.php?stran=jedilnik">Jedilnik</a>
              </li>
          </ul>
      </div>
      <div class="mx-auto order-0">
          <a class="navbar-brand mx-auto" href="#"><i class="fas fa-utensils"></i> HRANA</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
              <span class="navbar-toggler-icon"></span>
          </button>
      </div>
      <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
          <ul class="navbar-nav ml-auto">
              <?php
              if (isset($_SESSION['eposta'])){
                if ($_SESSION['nivo'] == "administrator"){
                  echo "<li class='nav-item'><a class='nav-link' href='index.php?stran=admin'><i class='fas fa-cogs'></i> Administracija</a></li>";
                }
                echo "<li class='nav-item'><a class='nav-link' href='index.php?stran=odjava'>Odjava <small>(" . $_SESSION['eposta']. ")</small></a></li>";
              } else {
                echo "<li class='nav-item'><a class='nav-link' href='index.php?stran=prijava'>Prijava</a></li>";
                echo "<li class='nav-item'><a class='nav-link' href='index.php?stran=registracija'>Registracija</a></li>";
              }
              
              ?>
          </ul>
      </div>
  </nav>

      <?php
      echo $vsebina;
       ?>
  </body>
</html>
