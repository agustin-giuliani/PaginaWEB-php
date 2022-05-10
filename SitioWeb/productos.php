<?php include("templates/cabecera.php");?>
    <!--El codigo en php nos trae de otro archibo php la barra o menu y--> 
    <!-- el codio en html jenera las carta que muestran los cursos de enfermeros como ejemplo-->
    <?php 
        //Trae la coneccion a la base de datos
        include("administrador/config/db.php");

        $buscar=(isset($_POST['buscar']))?$_POST['buscar']:"";

        //selecciona todos los datos de la tabla curso
        //y a la ves la filtra segun lo que busquemos
        $sentenciaSQL=$conexion->prepare("SELECT * FROM curso WHERE nombre LIKE '%".$buscar."%'OR informacion LIKE '%".$buscar."%' ORDER BY nombre");
        $sentenciaSQL->execute();
        $listacurso=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
        //selecciona todos los datos de la tabla curso
    ?>

    <form method="POST">
        <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Buscar...">
        <button type="submit" name="Accion" value="buscar" class="btn btn-primary">Buscar</button>
    </form>
 
    <br>
    <?php foreach( $listacurso as $cursos ) {?>
        <div class="col-md-3">
            <br><br>
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Curso</div>
                <img class="card-img-top" src="./img/<?php echo $cursos['imagen']; ?>" width="50" alt="">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $cursos['nombre']; ?></h4>
                    </br>
                    <a name="" id="" class="btn btn-dark" href="#" role="button">Ver Mas</a>
                </div>
            </div>
        </div>

    <?php }?>
<?php include("templates/pie.php");?>