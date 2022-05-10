<?php
    session_start();

    include("./config/db.php");
    if($_POST){
        
        //comprobacion del usuario y contraseña
        $usuario=(isset($_POST['usuario']))?$_POST['usuario']:"";
        $contraseña=(isset($_POST['contraseña']))?$_POST['contraseña']:"";

        $sentenciaSQL=$conexion->prepare("SELECT * FROM user WHERE usuario='".$usuario."'AND contraseña='".$contraseña."'");
        $sentenciaSQL->execute();
        $use=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        //pregunta si el array no esta basio ingresa a inicio sino tira error
        if(!empty($use)){
            $_SESSION['usuario']="OK";
            $_SESSION['nobreUsuario']=$usuario;
            $_SESSION['nobreContraseña']=$contraseña;
            header("Location:inicio.php");

        }
        else{

            $mensaje="Error al ingresar usuario o contraseña";
        }
        //pregunta si el array no esta basio ingresa a inicio sino tira error
    }

?>
<!doctype html>
<html lang="en">
  <head>
        <title>Enfermeros Especializados</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="../css/bootstrap.min.css"/>    
  </head>
  <body>
        <div class="container">

            <div class="row">
                <div class="col-md-4">
                </div>
            
                <div class="col-md-4">
                    </br></br></br></br></br></br>
                    <div class="card text-white bg-dark mb-3">
                        <div class="card-header">
                            Login
                        </div>
                        <div class="card-body">
                            <?php if(isset($mensaje)){?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje; ?>
                            </div>
                            <?php }?>
                            <form method="POST">
                            <div class = "form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ingrese nombre de Usuario">
                            </div>
                            </br>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Contraseña:</label>
                            <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="Ingrese contraseña">
                            </div>
                            </br>
                            <button type="submit" name="Accion" value="entrar" class="btn btn-success">Ingresar</button>
                            </form>
                            
                            
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
  </body>
</html>