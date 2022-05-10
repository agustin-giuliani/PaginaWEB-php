<?php 

    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location:index-admin.php");
    }
    else{
        if($_SESSION['usuario']=="OK"){
            $nobreUsuario=$_SESSION['nobreUsuario'];
            $nobreContraseña=$_SESSION['nobreContraseña'];
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Enfermeros Especializados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet"   href="../../css/bootstrap.min.css">
    <!-- Bootstrap CSS v5.0.2 -->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
            
  <body>
      <!--El codigo en php es para realizar la navegacion dentro de la pagina-->

      <?php $url="http://".$_SERVER['HTTP_HOST']."/SitioWeb" ?>
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <ul class="nav navbar-nav">
              <li class="nav-item active">
                  <a class="nav-link" href="<?php echo $url;?>">Sitio Web<span class="visually-hidden">(current)</span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="<?php echo $url;?>/administrador/seccion/productos.php">Cursos</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="<?php echo $url;?>/administrador/seccion/perfil.php">Perfil</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="<?php echo $url;?>/administrador/seccion/salir.php">Salir</a>
              </li>
          </ul>
      </nav>
      <div class="container">
            </br>
          <div class="row">



       