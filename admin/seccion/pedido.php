<?php
include("../template/cabezera.php");
?>

<?php
//INSERT INTO `proveedor` (`idProveedor`, `nombre_proveedor`, `numero_proveedor`, `mercancia`) VALUES (NULL, 'limber', '75497941', 'televisor');
include("../config/bd.php");


//proveedor

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$txtidProveedor=(isset($_POST['txtidProveedor'])) ? $_POST['txtidProveedor'] : "";
$txtnombre_proveedor = (isset($_POST['txtnombre_proveedor'])) ? $_POST['txtnombre_proveedor'] : "";
$txtnumero_proveedor = (isset($_POST['txtnumero_proveedor'])) ? $_POST['txtnumero_proveedor'] : "";

switch ($accion) {
    case "Agregar":
  
        $sentenciaSQL = $conexion->prepare("INSERT INTO proveedor (nombre_proveedor, numero_proveedor) VALUES (?, ?)");
        $sentenciaSQL->bindParam(1, $txtnombre_proveedor);
        $sentenciaSQL->bindParam(2, $txtnumero_proveedor);

        $sentenciaSQL->execute();
        
        header("Location:pedido.php");
        break;

        case "Modificar":
            $sentenciaSQL = $conexion->prepare("UPDATE proveedor SET nombre_proveedor=:nombre_proveedor, numero_proveedor=:numero_proveedor WHERE idProveedor=:idProveedor");
            $sentenciaSQL->bindParam(':nombre_proveedor', $txtnombre_proveedor);
            $sentenciaSQL->bindParam(':numero_proveedor', $txtnumero_proveedor);
            $sentenciaSQL->bindParam(':idProveedor', $txtidProveedor);
            $sentenciaSQL->execute();
            header("Location:pedido.php");
            break;
        

    case "Cancelar":
        header("Location:pedido.php");
        break;

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM proveedor WHERE idProveedor=:idProveedor");
        $sentenciaSQL->bindParam(':idProveedor', $txtidProveedor);
        $sentenciaSQL->execute();
        $pedido = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == "Seleccionar") {

            $txtidProveedor = $_POST['txtidProveedor'];
            $txtnombre_proveedor = $_POST['txtnombre_proveedor'];
            $txtnumero_proveedor = $_POST['txtnumero_proveedor'];

        } else {

            header("Location:pedido.php");
            exit();
        }
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM proveedor WHERE idProveedor=:idProveedor");
        $sentenciaSQL->bindParam(':idProveedor', $txtidProveedor);
        $sentenciaSQL->execute();
        header("Location:pedido.php");
        break;
}


$sentenciaSQL = $conexion->prepare("SELECT * FROM proveedor");
$sentenciaSQL->execute();
$listaProveedor = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
  <!--___________________________________________________________________________________________-->
  <!--                                          PROVEEDOR                                        -->
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

            <label for="mostrar-formulario" class="btn btn-primary">Agregar Proveedor</label>

            <input type="checkbox" id="mostrar-formulario" style="display: none;">

            <div class="formulario-proveedor">
            <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="txtidProveedor">ID:</label>
                        <input type="text" required readonly class="form-control" value="<?php echo $txtidProveedor; ?>" id="txtidProveedor" name="txtidProveedor">
                    </div>
                    <div class="form-group">
                        <label for="txtnombre_proveedor">Nombre:</label>
                        <input type="text"  class="form-control"value="<?php echo $txtnombre_proveedor; ?>"id="txtnombre_proveedor" name="txtnombre_proveedor">
                    </div>
                    <div class="form-group">
                        <label for="txtnumero_proveedor">Número:</label>
                        <input type="text"  class="form-control" value="<?php echo $txtnumero_proveedor; ?>" id="txtnumero_proveedor" name="txtnumero_proveedor">
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
                        <th>Nombre</th>
                        <th>Número</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listaProveedor as $pedido) { ?>

                    <tr>
                        <td><?php echo $pedido['idProveedor']?></td>
                        <td><?php echo $pedido['nombre_proveedor']?></td>
                        <td><?php echo $pedido['numero_proveedor']?></td>
                        <td>

                        <form method="post">
                        <input type="hidden" name="txtidProveedor" value="<?php echo $pedido['idProveedor'] ?>"/>
                            <input type="hidden" name="txtnombre_proveedor" value="<?php echo $pedido['nombre_proveedor'] ?>"/>
                            <input type="hidden" name="txtnumero_proveedor" value="<?php echo $pedido['numero_proveedor'] ?>"/>
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                            <input type="submit" name = "accion" value="Borrar" class="btn btn-danger"/>
                            
                </form>
                            
                        </td>
                    </tr>
                    <?php }?>

                </tbody>
            </table>
        </div>
    </div>
    </body>

  
   




 <!--___________________________________________________________________________________________-->
  <!--                                     productos de proveedor                                      -->
  <!--___________________________________________________________________________________________-->











  <?php
include("../config/bd.php");

$pulsar = (isset($_POST['pulsar'])) ? $_POST['pulsar'] : "";
$txtidproductos_proveedor=(isset($_POST['txtidproductos_proveedor'])) ? $_POST['txtidproductos_proveedor'] : "";

$txtmarca = (isset($_POST['txtmarca'])) ? $_POST['txtmarca'] : "";
$txtprecio = (isset($_POST['txtprecio'])) ? $_POST['txtprecio'] : "";
$txtproveedor_idProveedor = (isset($_POST['txtproveedor_idProveedor'])) ? $_POST['txtproveedor_idProveedor'] : "";
$txtCategoria_idCategoria = (isset($_POST['txtCategoria_idCategoria'])) ? $_POST['txtCategoria_idCategoria'] : "";
$txtpedido_idPedido = (isset($_POST['txtpedido_idPedido'])) ? $_POST['txtpedido_idPedido'] : "";



switch ($pulsar) {
    case "Agregar":

        //INSERT INTO `porductos_proveedor` (`idporductos_proveedor`, `marca`, `precio`, `proveedor_idProveedor`, `Categoria_idCategoria`, `pedido_idPedido`) VALUES (NULL, 'samsung', '2000.00', '4', '1', '4');
  
       
        $sentenciaSQL = $conexion->prepare("INSERT INTO productos_proveedor (marca, precio, proveedor_idProveedor, Categoria_idCategoria, pedido_idPedido) VALUES (?, ?, ?, ?, ?);");
        $sentenciaSQL->bindParam(1, $txtmarca);
        $sentenciaSQL->bindParam(2, $txtprecio);
        $sentenciaSQL->bindParam(3, $txtproveedor_idProveedor);
        $sentenciaSQL->bindParam(4, $txtCategoria_idCategoria);
        $sentenciaSQL->bindParam(5, $txtpedido_idPedido);
        $sentenciaSQL->execute();
        @header("Location: pedido.php");
        exit();
        break;

        case "Modificar":
            $sentenciaSQL = $conexion->prepare("UPDATE productos_proveedor SET marca=:marca, precio=:precio, proveedor_idProveedor=:proveedor_idProveedor, Categoria_idCategoria=:Categoria_idCategoria, pedido_idPedido=:pedido_idPedido WHERE idproductos_proveedor=:idproductos_proveedor");
            $sentenciaSQL->bindParam(':marca', $txtmarca);
            $sentenciaSQL->bindParam(':precio', $txtprecio);
            $sentenciaSQL->bindParam(':proveedor_idProveedor', $txtproveedor_idProveedor);
            $sentenciaSQL->bindParam(':Categoria_idCategoria', $txtCategoria_idCategoria);
            $sentenciaSQL->bindParam(':pedido_idPedido', $txtpedido_idPedido);
            $sentenciaSQL->bindParam(':idproductos_proveedor', $txtidproductos_proveedor);
            $sentenciaSQL->execute();
            @header("Location: pedido.php");
            exit();
            break;
        

            case "Cancelar":
                // Asignar valores vacíos o nulos a las variables asociadas a los campos del formulario
                $txtidproductos_proveedor = "";
                $txtmarca = "";
                $txtprecio = "";
                $txtproveedor_idProveedor = "";
                $txtCategoria_idCategoria = "";
                $txtpedido_idPedido = "";
                // Redirigir a pedido.php
                @header("Location: pedido.php");
                break;
            

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM productos_proveedor WHERE idproductos_proveedor=:idproductos_proveedor");
        $sentenciaSQL->bindParam(':idproductos_proveedor', $txtidproductos_proveedor);
        $sentenciaSQL->execute();
        $productos_proveedor = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $txtidproductos_proveedor = $_POST['txtidproductos_proveedor'];
            $txtmarca = $_POST['txtmarca'];
            $txtprecio = $_POST['txtprecio'];
            $txtproveedor_idProveedor = $_POST['txtproveedor_idProveedor'];
            $txtCategoria_idCategoria = $_POST['txtCategoria_idCategoria'];
            $txtpedido_idPedido = $_POST['txtpedido_idPedido'];
        } else {
            // Redirigir si no se envió el formulario
            header("Location: pedido.php");
            exit();
        }
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM productos_proveedor WHERE idproductos_proveedor=:idproductos_proveedor");
        $sentenciaSQL->bindParam(':idproductos_proveedor', $txtidproductos_proveedor);
        $sentenciaSQL->execute();
        @header("Location: pedido.php");
        break;
}



$sentenciaSQL = $conexion->prepare("SELECT * FROM productos_proveedor");
$sentenciaSQL->execute();
$listaProductosProveedor = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$sentenciaProveedores = $conexion->prepare("SELECT idProveedor, nombre_proveedor FROM proveedor");
$sentenciaProveedores->execute();
$proveedores = $sentenciaProveedores->fetchAll(PDO::FETCH_ASSOC);

$sentenciaCategoria = $conexion->prepare("SELECT idCategoria, nombre FROM Categoria");
$sentenciaCategoria->execute();
$categorias = $sentenciaCategoria->fetchAll(PDO::FETCH_ASSOC);

$sentenciaPedido = $conexion->prepare("SELECT idPedido, cantidad FROM pedido");
$sentenciaPedido->execute();
$pedidoss = $sentenciaPedido->fetchAll(PDO::FETCH_ASSOC);

?>
    <style>
        .formulary-producto_proveedor {
            display: none;
            padding: 10px;
            border: 1px solid #ccc;
        }
        
       
        .btn-primary {
            display: block;
            /*width: 100px; 
            text-align: center;
            padding: 10px;
            margin: 10px auto; 
            cursor: pointer;
            background-color: #007bf0;
            color: #fff;*/
        }


        #mostrar-formulary {
            display: none;
        }


        #mostrar-formulary:checked ~ .formulary-producto_proveedor {
            display: block;
        }
    </style>
</head>
<body>
    <input type="checkbox" id="mostrar-formulary">
    <label for="mostrar-formulary" class="btn btn-primary">Agregar Pedido</label>

    <div class="formulary-producto_proveedor">
        <form method="POST" enctype="multipart/form-data">


            <div class="form-group">
                        <label for="txtidproductos_proveedor">ID-P-P</label>
                        <input type="text" required readonly class="form-control"value="<?php echo $txtidproductos_proveedor; ?>"id="txtidproductos_proveedor" name="txtidproductos_proveedor">
                    </div>


                    <div class="form-group">
                        <label for="txtmarca">Cantidada:</label>
                        <input type="text"  class="form-control"value="<?php echo $txtmarca; ?>"id="txtmarca" name="txtmarca">
                    </div>

                    <div class="form-group">
                        <label for="txtprecio">Precio:</label>
                        <input type="text"  class="form-control"value="<?php echo $txtprecio; ?>"id="txtprecio" name="txtprecio">
                    </div>


                    <div class="form-group">
                        <label for="txtproveedor_idProveedor">ID Proveedor - Nombre:</label>
                        <select class="form-control" id="txtproveedor_idProveedor" name="txtproveedor_idProveedor">
                            <?php foreach ($proveedores as $proveedor_db) { ?>
                                <option value="<?php echo $proveedor_db['idProveedor']; ?>">
                                    <?php echo $proveedor_db['idProveedor'] . ' - ' . $proveedor_db['nombre_proveedor']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="txtCategoria_idCategoria">ID Categoria Nombre:</label>
                        <select class="form-control" id="txtCategoria_idCategoria" name="txtCategoria_idCategoria">
                            <?php foreach ($categorias as $Categoria_db) { ?>
                                <option value="<?php echo $Categoria_db['idCategoria']; ?>">
                                    <?php echo $Categoria_db['idCategoria'] . ' - ' . $Categoria_db['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="txtpedido_idPedido">ID Pedido Cantidad:</label>
                        <select class="form-control" id="txtpedido_idPedido" name="txtpedido_idPedido">
                            <?php foreach ($pedidoss as $pedido_db) { ?>
                                <option value="<?php echo $pedido_db['idPedido']; ?>">
                                    <?php echo $pedido_db['idPedido'] . ' - ' . $pedido_db['cantidad']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="pulsar" <?php echo ($pulsar=="Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">AGREGAR</button>
                        <button type="submit" name="pulsar" <?php echo ($pulsar!="Seleccionar") ? "disabled" : ""; ?> value="Modificar" class="btn btn-warning">MODIFICAR</button>
                        <button type="submit" name="pulsar" <?php echo ($pulsar!="Seleccionar" && $pulsar=="Selecionar") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-danger">CANCELAR</button>
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
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>ID-Proveedor</th>
                        <th>ID-Categoria</th>
                        <th>ID-Pedido</th>

                     
                     <td>
                     <?php
                    $nombreProveedor = '';
                    if(isset($productoProveedor['proveedor_idProveedor'])) {
                        foreach ($proveedores as $proveedor) {
                            if ($proveedor['idProveedor'] == $productoProveedor['proveedor_idProveedor']) {
                                $nombreProveedor = $proveedor['nombre_proveedor'];
                                break;
                            }
                        }
                    }
                    echo $nombreProveedor;
                    ?>
</td>

<td>
<?php
                    $nombreCategoria = '';
                    if(isset($productoProveedor['Categoria_idCategoria'])) {
                        foreach ($categorias as $categoria) {
                            if ($categoria['idCategoria'] == $productoProveedor['Categoria_idCategoria']) {
                                $nombreCategoria = $categoria['nombre'];
                                break;
                            }
                        }
                    }
                    echo $nombreCategoria;
                    ?>
</td>

<td>
<?php
                    $nombrePedido = '';
                    if(isset($productoProveedor['pedido_idPedido'])) {
                        foreach ($pedidoss as $pedido) {
                            if ($pedido['idPedido'] == $productoProveedor['pedido_idPedido']) {
                                $nombrePedido = $pedido['cantidad'];
                                break;
                            }
                        }
                    }
                    echo $nombrePedido;
                    ?>
</td>


                    </tr>
                </thead>
                <tbody>
    <?php foreach($listaProductosProveedor as $productoProveedor) { ?>
        <tr>
        <td><?php echo $productoProveedor['idproductos_proveedor']; ?></td>
                    <td><?php echo $productoProveedor['marca']; ?></td>
                    <td><?php echo $productoProveedor['precio']; ?></td>
                    <td><?php echo $productoProveedor['proveedor_idProveedor']; ?></td>
                    <td><?php echo $productoProveedor['Categoria_idCategoria']; ?></td>
                    <td><?php echo $productoProveedor['pedido_idPedido']; ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="txtidproductos_proveedor" value="<?php echo $productoProveedor['idproductos_proveedor']; ?>"/>
                    <input type="hidden" name="txtmarca" value="<?php echo $productoProveedor['marca']; ?>"/>
                    <input type="hidden" name="txtprecio" value="<?php echo $productoProveedor['precio']; ?>"/>
                    <input type="hidden" name="txtproveedor_idProveedor" value="<?php echo $productoProveedor['proveedor_idProveedor']; ?>"/>
                    <input type="hidden" name="txtCategoria_idCategoria" value="<?php echo $productoProveedor['Categoria_idCategoria']; ?>"/>
                    <input type="hidden" name="txtpedido_idPedido" value="<?php echo $productoProveedor['pedido_idPedido']; ?>"/>
                    
                    <input type="submit" name="pulsar" value="Seleccionar" class="btn btn-primary"/>
                    <input type="submit" name="pulsar" value="Borrar" class="btn btn-danger"/>
                </form>
            </td>
        </tr>
    <?php } ?>
</tbody>

            </table>
        </div>
    </div>
    </body>



<?php
include("../template/pie.php");
?>



    



