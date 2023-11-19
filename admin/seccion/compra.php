<?php
include("../template/cabezera.php");
?>

<?php
include("../config/bd.php");


//pedido

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

$txtidPedido=(isset($_POST['txtidPedido'])) ? $_POST['txtidPedido'] : "";
$txtcantidad = (isset($_POST['txtcantidad'])) ? $_POST['txtcantidad'] : "";
$txtdireccion = (isset($_POST['txtdireccion'])) ? $_POST['txtdireccion'] : "";
$txtfecha_pedido = (isset($_POST['txtfecha_pedido'])) ? $_POST['txtfecha_pedido'] : "";
//$txtproveedor_idProveedor = (isset($_POST['txtproveedor_idProveedor'])) ? $_POST['txtproveedor_idProveedor'] : "";



switch ($accion) {
    case "Agregar":

        //INSERT INTO `pedido` (`idPedido`, `cantidad`, `direccion`, `fecha_pedido`, `proveedor_idProveedor`) VALUES (NULL, '5', 'villa satelite', '2023-11-01', '3');
  
       
    $sentenciaSQL = $conexion->prepare("INSERT INTO pedido (cantidad, direccion, fecha_pedido) VALUES ( ?, ? ,?);");
    $sentenciaSQL->bindParam(1, $txtcantidad);
    $sentenciaSQL->bindParam(2, $txtdireccion);
    $sentenciaSQL->bindParam(3, $txtfecha_pedido);
   // $sentenciaSQL->bindParam(4, $txtproveedor_idProveedor);
    $sentenciaSQL->execute();
    header("Location: compra.php");

        
        header("Location:compra.php");
        break;

        case "Modificar":
            $sentenciaSQL = $conexion->prepare("UPDATE pedido SET cantidad=:cantidad, direccion=:direccion, fecha_pedido=:fecha_pedido WHERE idPedido=:idPedido");
            $sentenciaSQL->bindParam(':cantidad', $txtcantidad);
            $sentenciaSQL->bindParam(':direccion', $txtdireccion);
            $sentenciaSQL->bindParam(':fecha_pedido', $txtfecha_pedido);
            //$sentenciaSQL->bindParam(':proveedor_idProveedor', $txtproveedor_idProveedor);
            $sentenciaSQL->bindParam(':idPedido', $txtidPedido);
            $sentenciaSQL->execute();
            header("Location:compra.php");
            break;
        

    case "Cancelar":
        header("Location:compra.php");
        break;

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM pedido WHERE idPedido=:idPedido");
        $sentenciaSQL->bindParam(':idPedido', $txtidPedido);
        $sentenciaSQL->execute();
        $pedido = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == "Seleccionar") {

            $txtidPedido = $_POST['txtidPedido'];
            $txtcantidad = $_POST['txtcantidad'];
            $txtdireccion = $_POST['txtdireccion'];          
            $txtfecha_pedido = $_POST['txtfecha_pedido'];
            //@$txtproveedor_idProveedor = $_POST['txtproveedor_idProveedor'];
        } else {

            header("Location:compra.php");
            exit();
        }
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM pedido WHERE idPedido=:idPedido");
        $sentenciaSQL->bindParam(':idPedido', $txtidPedido);
        $sentenciaSQL->execute();
        header("Location:compra.php");
        break;
}


$sentenciaSQL = $conexion->prepare("SELECT * FROM pedido");
$sentenciaSQL->execute();
$listaPedido = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

/*$sentenciaProveedores = $conexion->prepare("SELECT idProveedor, nombre_proveedor FROM proveedor");
$sentenciaProveedores->execute();
$proveedores = $sentenciaProveedores->fetchAll(PDO::FETCH_ASSOC);*/


?>
  <!--___________________________________________________________________________________________-->
  <!--                                          tabla pedido                                       -->
  <!--___________________________________________________________________________________________-->
  <style>
        .formulario-proveedor {
            display: none;
            padding: 10px;
            border: 1px solid #ccc;
        }
        #mostrar-formulario:checked ~ .formulario-proveedor {
            display: block;
        }
    </style>
</head>
<body>
    

    <div class="container">
        <div class="col-md-12">

            <label for="mostrar-formulario" class="btn btn-primary">Agregar Pedido</label>

            <input type="checkbox" id="mostrar-formulario" style="display: none;">

            <div class="formulario-proveedor">
            <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="txtidPedido">ID:</label>
                        <input type="text" required readonly class="form-control" value="<?php echo $txtidPedido; ?>" id="txtidPedido" name="txtidPedido">
                    </div>
                    <div class="form-group">
                        <label for="txtcantidad">Cantidada:</label>
                        <input type="text"  class="form-control"value="<?php echo $txtcantidad; ?>"id="txtcantidad" name="txtcantidad">
                    </div>

                   <!-- <div class="form-group">
    <label for="txtproveedor_idProveedor">ID Proveedor - Nombre:</label>
    <select class="form-control" id="txtproveedor_idProveedor" name="txtproveedor_idProveedor">
        <?php /*foreach ($proveedores as $proveedor_db) { ?>
            <option value="<?php echo $proveedor_db['idProveedor']; ?>">
                <?php echo $proveedor_db['idProveedor'] . ' - ' . $proveedor_db['nombre_proveedor']; ?>
            </option>
        <?php } */?>
    </select>
</div>-->

                    <div class="form-group">
                        <label for="txtdireccion">Direccion:</label>
                        <input type="text"  class="form-control" value="<?php echo $txtdireccion; ?>" id="txtdireccion" name="txtdireccion">
                    </div>
                    <div class="form-group">
                        <label for="txtfecha_pedido">Fecha-Pedido: </label>
                        <input type="date"  class="form-control" value="<?php echo $txtfecha_pedido; ?>" id="txtfecha_pedido" name="txtfecha_pedido" >
                        </div>

                        <div class="btn-group" role="group" aria-label="">

                    <button type="submit" name="accion"<?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">AGREGAR</button>
                    
                    <button type="submit" name="accion"<?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">MODIFICAR</button>

                    <button type="submit" name="accion"<?php echo ($accion!="Seleccionar"&&$accion=="Selecionar")?"disabled":""; ?> value="Cancelar" class="btn btn-danger">CANCELAR</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        

        <div class="col-md-12 mt-4">
            <h2>Datos de Proveedores</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cantidad</th>
                        <th>Nombre-Proveedor</th>
                        <th>Direccion</th>
                        <th>Fecha</th>

                    </tr>
                </thead>
                <tbody>
                <?php foreach($listaPedido as $compra) { ?>

                    <tr>

                    <td><?php echo $compra['idPedido']; ?></td>
                        <td><?php echo $compra['cantidad']; ?></td>
     

                        <td><?php echo $compra['direccion']; ?></td>
                        <td><?php echo $compra['fecha_pedido']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="txtidPedido" value="<?php echo $compra['idPedido']; ?>"/>
                                <input type="hidden" name="txtcantidad" value="<?php echo $compra['cantidad']; ?>"/>
                                <input type="hidden" name="txtdireccion" value="<?php echo $compra['direccion']; ?>"/>
                                <input type="hidden" name="txtfecha_pedido" value="<?php echo $compra['fecha_pedido']; ?>"/>

                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                                               
                            
                </form>
                            
                        </td>
                    </tr>
                    <?php }?>

                </tbody>
            </table>
        </div>
    </div>
    </body>



<?php
include("../template/pie.php");
?>


