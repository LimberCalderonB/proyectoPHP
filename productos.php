<?php 
include("template/cabezera.php"); 
?>

<?php
include ("admin/config/bd.php");

$sentenciaSQL= $conexion->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php foreach($listaProductos as $productos){ ?>
<div class="col-md-3">
<div class="card">

    <img class="card-img-top" src="./img/<?php echo $productos['imagen'] ?>" alt="">
    <div class="card-body">
        <h4 class="card-title"><?php echo $productos['marca'] ?></h4>
        <a name="" id="" class="btn btn-primary" href=""role="button">Ver más</a>
</div>
</div>
</div>

<?php } ?>



<?php 
include("template/pie.php"); 
?>