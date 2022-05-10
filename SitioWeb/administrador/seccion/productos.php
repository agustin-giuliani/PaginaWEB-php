<?php include("../template/cabecera-admin.php");?>
    <?php
    
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
        $txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
        $txtInfo=(isset($_POST['txtInfo']))?$_POST['txtInfo']:"";
        $txtImg=(isset($_FILES['txtImg']['name']))?$_FILES['txtImg']['name']:"";
        $Accion=(isset($_POST['Accion']))?$_POST['Accion']:"";

        
        include("../config/db.php");

        //evalua, valida la varriable accion  y la iguala
        
        switch ($Accion) {
                case 'agregar':
                    //INSERT INTO `curso` (`id`, `nombre`, `informacion`, `imagen`) VALUES (NULL, 'Cirujano/a', 'curso para ser cirujano', 'imagen.jpg');
                    $sentenciaSQL=$conexion->prepare("INSERT INTO curso (nombre,informacion,imagen) VALUES (:nombre,:informacion,:imagen);");
                    $sentenciaSQL->bindParam(':nombre',$txtNombre);
                    $sentenciaSQL->bindParam(':informacion',$txtInfo);

                    //inicializa la variable fecha
                    $fecha= new DateTime();
                    //le da el valor de imagen a nombredearchivo mas fecha, sino carga con imagen.jpg
                    $nombredearchivo=($txtImg!="")?$fecha->getTimestamp()."_".$_FILES["txtImg"]["name"]:"imagen.jpg";
                    //inicializa la variable imagen temporal 
                    $tmpimagen=$_FILES["txtImg"]["tmp_name"];
                    //consultaa si la imagen temporal es distinta de basio y la guarda en la carpeta img
                    if($tmpimagen!=""){
                        move_uploaded_file($tmpimagen,"../../img/".$nombredearchivo);
                    }

                    $sentenciaSQL->bindParam(':imagen',$nombredearchivo);
                    $sentenciaSQL->execute();

                    header("Location:productos.php");

                    break;

                case 'modificar':

                    $sentenciaSQL=$conexion->prepare("UPDATE curso SET nombre=:nombre, informacion=:informacion WHERE id=:id");
                    $sentenciaSQL->bindParam(':informacion',$txtInfo);
                    $sentenciaSQL->bindParam(':nombre',$txtNombre);
                    $sentenciaSQL->bindParam(':id',$txtID);
                    $sentenciaSQL->execute();

                    if($txtImg!=""){

                        //inicializa la variable fecha
                        $fecha= new DateTime();
                        //le da el valor de imagen a nombredearchivo mas fecha, sino carga con imagen.jpg
                        $nombredearchivo=($txtImg!="")?$fecha->getTimestamp()."_".$_FILES["txtImg"]["name"]:"imagen.jpg";
                        //inicializa la variable imagen temporal 
                        $tmpimagen=$_FILES["txtImg"]["tmp_name"];
                        //consultaa si la imagen temporal es distinta de basio y la guarda en la carpeta img
                        move_uploaded_file($tmpimagen,"../../img/".$nombredearchivo);

                        //este parte del codigo busca la imagen para borrar
                        $sentenciaSQL=$conexion->prepare("SELECT imagen FROM curso WHERE id=:id");
                        $sentenciaSQL->bindParam(':id',$txtID);
                        $sentenciaSQL->execute();
                        $cursos=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
                        //este parte del codigo pregunta si la imagen para borrar, esta, es distinta de..., y si se encuentra en la carpeta img
                        if( isset($cursos['imagen']) &&($cursos['imagen']!="imagen.jpg")){
                            if(file_exists("../../img/".$cursos['imagen'])){

                            unlink("../../img/".$cursos['imagen']);

                            }
                        }


                        $sentenciaSQL=$conexion->prepare("UPDATE curso SET imagen=:imagen WHERE id=:id");
                        $sentenciaSQL->bindParam(':imagen',$nombredearchivo);
                        $sentenciaSQL->bindParam(':id',$txtID);
                        $sentenciaSQL->execute();
                    }
                    header("Location:productos.php");
                    break;

                case 'borrar':
                    //este parte del codigo busca la imagen para borrar
                    $sentenciaSQL=$conexion->prepare("SELECT imagen FROM curso WHERE id=:id");
                    $sentenciaSQL->bindParam(':id',$txtID);
                    $sentenciaSQL->execute();
                    $cursos=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
                    //este parte del codigo pregunta si la imagen para borrar, esta, es distinta de..., y si se encuentra en la carpeta img
                    if( isset($cursos['imagen']) &&($cursos['imagen']!="imagen.jpg")){
                        if(file_exists("../../img/".$cursos['imagen'])){

                          unlink("../../img/".$cursos['imagen']);

                        }
                    }

                    $sentenciaSQL=$conexion->prepare("DELETE  FROM curso WHERE id=:id");
                    $sentenciaSQL->bindParam(':id',$txtID);
                    $sentenciaSQL->execute();

                    header("Location:productos.php");
                    //echo "precionado bottn seleccionar";
                    break;
                case 'seleccionar':
                    $sentenciaSQL=$conexion->prepare("SELECT * FROM curso WHERE id=:id");
                    $sentenciaSQL->bindParam(':id',$txtID);
                    $sentenciaSQL->execute();
                    $cursos=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    $txtNombre=$cursos['nombre'];
                    $txtInfo=$cursos['informacion'];
                    $txtImg=$cursos['imagen'];

                    //echo "precionado bottn seleccionar";
                    break;
                case 'cancelar':
                    header("Location:productos.php");
                    //echo "precionado bottn modificar";
                    break;

        }

        //Selecciona toda la informacion de la tabla curso

        $sentenciaSQL=$conexion->prepare("SELECT * FROM curso ORDER BY nombre ASC");
        $sentenciaSQL->execute();
        $listacurso=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

        //Selecciona toda la informacion de la tabla curso

    ?>
    <div class="col-md-5">
        
        <div class="card text-white bg-dark mb-3">

            <div class="card-header">
                Datos de Curso
            </div>
            <div class="card-body">
                <form method="POST"  enctype="multipart/form-data">
                   <div class = "form-group">
                        <!--<label type="hidden" for="txtId">ID:</label>-->
                        <input type="hidden" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtId" placeholder="ID">
                    </div>
                    <div class = "form-group">
                        <label for="txtNombre">Nombre:</label>
                        <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre">
                    </div>
                    <div class = "form-group">
                        <label for="txtInformacion">informacion:</label>
                        <input type="text" class="form-control" value="<?php echo $txtInfo; ?>" name="txtInfo" id="txtInformacion" placeholder="Informacion">
                    </div>
                    <div class = "form-group">
                        <label for="txtImagen">imagen:</label>

                        </br>
                        
                        <?php if( $txtImg!=""){?>
                            <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImg; ?>" width="50" alt="" srcset="">
                        <?php }?>
                        
                        <input type="file" class="form-control" name="txtImg" id="txtImagen" placeholder="imagen">
                    </div>
                    </br>
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="Accion" <?php echo($Accion=="seleccionar")?"disabled":""; ?> value="agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="Accion" <?php echo($Accion!="seleccionar")?"disabled":""; ?>  value="modificar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="Accion" <?php echo($Accion!="seleccionar")?"disabled":""; ?>  value="cancelar" class="btn btn-light">Cancelar</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    <div class="col-md-7">
        <table class="table table-info table-bordered">
            <thead>
                <tr>
                     <!--<th>ID</th>-->
                    <th>Nombre</th>
                    <th>Informacion</th>
                    <th>Imagen</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <!--El codigo en php trae la lista de la base de datos y la imprime en la tabla de html-->
                <?php foreach($listacurso as $curso){?>
                <tr>
                    <!--<td><?php echo  $curso['id']; ?></td>-->
                    <td><?php echo $curso['nombre']; ?></td>
                    <td><?php echo  $curso['informacion']; ?></td>
                    <td>

                        <img class="img-thumbnail rounded" src="../../img/<?php echo  $curso['imagen']; ?>" width="50" alt="" srcset="">
                        
                    
                    </td>

                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $curso['id']; ?>" />
                            <input type="submit" name="Accion" value="seleccionar" class="btn btn-secondary" />
                            <input type="submit" name="Accion" value="borrar" class="btn btn-danger" />
                        </form>
                    </td>

                </tr>
                <?php } ?>
                <!--El codigo en php trae la lista de la base de datos y la imprime en la tabla de html-->
            </tbody>
        </table>
    </div>

<?php include("../template/pie-admin.php");?>