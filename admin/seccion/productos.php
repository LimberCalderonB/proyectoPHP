
<?php
include("../template/cabezera.php");
?>

<?php
//----------------------------------------------------------------------------------------------------------
//                                  CATEGORIAS DE TELEVISORES
//----------------------------------------------------------------------------------------------------------
$txtidCategoria = (isset($_POST['txtidCategoria'])) ? $_POST['txtidCategoria'] : "";
$txtnombre = (isset($_POST['txtnombre'])) ? $_POST['txtnombre'] : "";
$pulsar= (isset($_POST['pulsar'])) ? $_POST['pulsar'] : "";


include("../config/bd.php");

switch ($pulsar) {

        case "Agregar":

          $sentenciaSQL = $conexion->prepare("SELECT COUNT(*) AS count FROM categoria WHERE nombre = ?");
          $sentenciaSQL->bindParam(1, $txtnombre);
          $sentenciaSQL->execute();
          $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
  
          if ($resultado['count'] > 0) {

               echo "la categoría ya existe";
          } else {

              $sentenciaSQL = $conexion->prepare("INSERT INTO categoria (nombre) VALUES (?)");
              $sentenciaSQL->bindParam(1, $txtnombre);
              $sentenciaSQL->execute();
              header("Location:productos.php");
          }
          break;
  
      case "Modificar":

          $sentenciaSQL = $conexion->prepare("SELECT COUNT(*) AS count FROM categoria WHERE nombre = ? AND idCategoria != ?");
          $sentenciaSQL->bindParam(1, $txtnombre);
          $sentenciaSQL->bindParam(2, $txtidCategoria);
          $sentenciaSQL->execute();
          $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
  
          if ($resultado['count'] > 0) {

               echo "El nombre ya existe";
          } else {

              $sentenciaSQL = $conexion->prepare("UPDATE categoria SET nombre=:nombre WHERE idCategoria=:idCategoria");
              $sentenciaSQL->bindParam(':nombre', $txtnombre);
              $sentenciaSQL->bindParam(':idCategoria', $txtidCategoria);
              $sentenciaSQL->execute();
              header("Location:productos.php");
          }
          break;
      
    case "Cancelar":
        header("Location:productos.php");
        break;

        case "Seleccionar":
          $sentenciaSQL = $conexion->prepare("SELECT * FROM categoria WHERE idCategoria=:idCategoria");
          $sentenciaSQL->bindParam(':idCategoria', $txtidCategoria); // Modificación aquí
          $sentenciaSQL->execute();
          $categoria = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
          if ($categoria) {
              $txtidCategoria = $categoria['idCategoria'];
              $txtnombre = $categoria['nombre'];
          }
          break;
      
      

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM categoria WHERE idCategoria=:idCategoria");
        $sentenciaSQL->bindParam(':idCategoria', $txtidCategoria);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;

          
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM categoria");
$sentenciaSQL->execute();
$listaCategoria = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


 

?>

<div class="col-md-4">
    
    <div class="card">
    <div class="card-header">
INSERTAR CATEGORIA
</div>

<div class="card-body">
 
<form method="POST" enctype="multipart/form-data">


 <div class = "form-group">
      <label for="txtidCategoria">ID-CATEGORIA</label>
      <input type="text"required readonly class="form-control" value="<?php echo $txtidCategoria; ?> " name="txtidCategoria" id="txtidCategoria" placeholder="ID DE CATEGORIA : ">
 </div>

 <div class = "form-group">
      <label for="txtnombre">NOMBRE DE CATEGORIA</label>
      <input type="text" required class="form-control" value="<?php echo $txtnombre; ?>" name="txtnombre" id="txtnombre" placeholder="Categoria:">
 </div>

 <div class="btn-group" role="group" aria-label="">
             <button type="submit" name="pulsar"<?php echo ($pulsar=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-info">AGREGAR</button>
             <button type="submit" name="pulsar"<?php echo ($pulsar!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">MODIFICAR</button>
             <button type="submit" name="pulsar"<?php echo ($pulsar!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">CANCELAR</button>
       </div>
    </form>
</div>
</div>
</div>

<div class="col-md-8">
    
    <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID-CATEGORIA</th>              
                <th>NOMBRE CATEGORIA</th>
                
            </tr>
          </thead>
          <tbody>
               <?php foreach($listaCategoria as $categoria) { ?>
               <tr>
                
                <td> <?php echo $categoria['idCategoria']?></td>
                <td> <?php echo $categoria['nombre']?></td>

                <td>
                <form method="post">
                <input type="hidden" name="txtidCategoria" id="txtidCategoria" value="<?php echo $categoria['idCategoria'] ?>"/>


                    <input type="submit" name = "pulsar" value="Seleccionar" class="btn btn-primary"/>
                    <input type="submit" name = "pulsar" value="Borrar" class="btn btn-danger"/>
                </form>
                </td>
                
               </tr>
            <?php }?>
           </tbody>
        </table>
    </div>
    </div>
</div>
</div>
</div>

<div class="container">
        <br/>
        <div class="row">


<?php

//-------------------------------------------------------------------------
//                           TELEVISORES
//-------------------------------------------------------------------------


$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtimagen=(isset($_FILES['txtimagen']['name']))?$_FILES['txtimagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";
$txtCategoria_idCategoria=(isset($_POST['txtCategoria_idCategoria']))?$_POST['txtCategoria_idCategoria']:"";
$txtprecio=(isset($_POST['txtprecio']))?$_POST['txtprecio']:"";
$txtmarca=(isset($_POST['txtmarca']))?$_POST['txtmarca']:"";
$txtmodelo=(isset($_POST['txtmodelo']))?$_POST['txtmodelo']:"";
$txttamanio=(isset($_POST['txttamanio']))?$_POST['txttamanio']:"";

include("../config/bd.php");

switch($accion){

     
          case "Agregar":
              // Verificar si el modelo de televisor ya existe en la base de datos
              $sentenciaSQL = $conexion->prepare("SELECT COUNT(*) AS count FROM productos WHERE modelo = ?");
              $sentenciaSQL->bindParam(1, $txtmodelo);
              $sentenciaSQL->execute();
              $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
      
              if ($resultado['count'] > 0) {
                  
                   echo "El modelo de televisor ya existe. Por favor, elija otro modelo.";
              } else {
      
                  $sentenciaSQL = $conexion->prepare("INSERT INTO productos (imagen, Categoria_idCategoria, precio, marca, modelo, tamanio)  
                      VALUES (?, ?, ?, ?, ?, ?)");
                  $fecha = new DateTime();
                  $nombreArchivo = ($txtimagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtimagen"]["name"] : "imagen";
                  $tmpimagen = $_FILES["txtimagen"]["tmp_name"];
      
                  if ($tmpimagen != "") {
                      move_uploaded_file($tmpimagen, "../../img/" . $nombreArchivo);
                  }
      
                  $sentenciaSQL->bindParam(1, $nombreArchivo);
                  $sentenciaSQL->bindParam(2, $txtCategoria_idCategoria);
                  $sentenciaSQL->bindParam(3, $txtprecio);
                  $sentenciaSQL->bindParam(4, $txtmarca);
                  $sentenciaSQL->bindParam(5, $txtmodelo);
                  $sentenciaSQL->bindParam(6, $txttamanio);
                  
                  $sentenciaSQL->execute();
                  header("Location:productos.php");
              }
              break;
      
          case "Modificar":

              $sentenciaSQL = $conexion->prepare("SELECT COUNT(*) AS count FROM productos WHERE modelo = ? AND id != ?");
              $sentenciaSQL->bindParam(1, $txtmodelo);
              $sentenciaSQL->bindParam(2, $txtID);
              $sentenciaSQL->execute();
              $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
      
              if ($resultado['count'] > 0) {
                  
                   echo "El modelo de televisor ya existe para otro registro. Por favor, elija otro modelo.";
              } else {
      
                  $sentenciaSQL = $conexion->prepare("UPDATE productos SET imagen=?, Categoria_idCategoria=?, precio=?, marca=?, modelo=?, tamanio=? WHERE id=?");
                  if ($txtimagen != "") {
                      $fecha = new DateTime();
                      $nombreArchivo = $fecha->getTimestamp() . "_" . $_FILES["txtimagen"]["name"];
                      $tmpimagen = $_FILES["txtimagen"]["tmp_name"];
                      move_uploaded_file($tmpimagen, "../../img/" . $nombreArchivo);
                      $sentenciaSQL->bindParam(1, $nombreArchivo);
                  } else {
                      $sentenciaSQL->bindParam(1, $txtimagen);
                  }
      
                  $sentenciaSQL->bindParam(2, $txtCategoria_idCategoria);
                  $sentenciaSQL->bindParam(3, $txtprecio);
                  $sentenciaSQL->bindParam(4, $txtmarca);
                  $sentenciaSQL->bindParam(5, $txtmodelo);
                  $sentenciaSQL->bindParam(6, $txttamanio);
                  $sentenciaSQL->bindParam(7, $txtID);
                  
                  $sentenciaSQL->execute();
                  header("Location:productos.php");
              }
              break;
          
     case "Cancelar":
               header("Location:productos.php");
               break;
           
          break;


          case "Seleccionar":
               $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE id=:id");
               $sentenciaSQL->bindParam(':id', $txtID);
               $sentenciaSQL->execute();
               $productoSeleccionado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
           
               $sentenciaVerificacion = $conexion->prepare("SELECT COUNT(*) AS count FROM productos WHERE modelo = ? AND id != ?");
               $sentenciaVerificacion->bindParam(1, $productoSeleccionado['modelo']);
               $sentenciaVerificacion->bindParam(2, $txtID);
               $sentenciaVerificacion->execute();
               $resultadoVerificacion = $sentenciaVerificacion->fetch(PDO::FETCH_ASSOC);
           
               if ($resultadoVerificacion['count'] > 0) {
                   echo "El modelo de televisor ya existe para otro registro. Por favor, elija otro modelo.";
               } else {

                   $txtCategoria_idCategoria = $productoSeleccionado['Categoria_idCategoria'];
                   $txtimagen = $productoSeleccionado['imagen'];
                   $txtprecio = $productoSeleccionado['precio'];
                   $txtmarca = $productoSeleccionado['marca'];
                   $txtmodelo = $productoSeleccionado['modelo'];
                   $txttamanio = $productoSeleccionado['tamanio'];
               }
               break;
                  
     case "Borrar":
          $sentenciaSQL= $conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();
          $productos=$sentenciaSQL->fetch(PDO::FETCH_ASSOC);

          if (isset($productos["imagen"])&&($productos["imagen"]!="imagen")){
               if(file_exists("../../img/".$productos["imagen"])){
                    unlink("../../img/".$productos["imagen"]);
               }
          }

          $sentenciaSQL= $conexion->prepare("DELETE FROM productos WHERE id=:id");
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          
          header("Location:productos.php");

          break;
}
$sentenciaSQL= $conexion->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-4">
    
    <div class="card">
    <div class="card-header">
        DATOS DE TELEVISOR
    </div>

    <div class="card-body">
        
    <form method="POST" enctype="multipart/form-data">

        <div class = "form-group">
             <label for="txtimagen">IMAGEN</label>
             <?php echo $txtimagen; ?> 
            
             <input type="file" class="form-control" value="txtimagen " name="txtimagen" id="txtimagen" placeholder="nombre : ">
        </div>

        <div class = "form-group">
             <label for="txtID">ID-PRODUCTO</label>
             <input type="text"required readonly class="form-control" value="<?php echo $txtID; ?> " name="txtID" id="txtID" placeholder="ID :">
        </div>

        <div class = "form-group">
             <label for="txtCategoria_idCategoria">ID-Categoria</label>
             <input type="text" required class="form-control" value="<?php echo $txtCategoria_idCategoria; ?>" name="txtCategoria_idCategoria" id="txtCategoria_idCategoria" placeholder="Categoria:">
        </div>

        <div class = "form-group">
             <label for="txtprecio">PRECIO</label>
             <input type="text" required class="form-control" value="<?php echo $txtprecio; ?>" name="txtprecio" id="txtprecio" placeholder="PRECIO : ">
        </div>

        <div class = "form-group">
             <label for="textmarca">MARCA:</label>
             <input type="text" required class="form-control" value="<?php echo $txtmarca; ?>" name="txtmarca" id="txtmarca" placeholder="MARCA DEL TELEVISOR :">
        </div>

        <div class = "form-group">
             <label for="txtmodelo">MODELO</label>
             <input type="txt" required class="form-control" value="<?php echo $txtmodelo; ?>" name="txtmodelo" id="txtmodelo" placeholder="MODELO :">
        </div>

        <div class = "form-group">
             <label for="txttamanio">TAMAÑO EN PULGADAS</label>
             <input type="text" required class="form-control" value="<?php echo $txttamanio; ?>" name="txttamanio" id="txttamanio" placeholder="PULGADAS :">
        </div>

       <div class="btn-group" role="group" aria-label="">
             <button type="submit" name="accion"<?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-info">AGREGAR</button>
             <button type="submit" name="accion"<?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">MODIFICAR</button>
             <button type="submit" name="accion"<?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">CANCELAR</button>
       </div>
    </form>
</div>
</div>
</div>
<div class="col-md-8">
    
    <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>              
                <th>CAT</th>
                <th>Imagen</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Tamaño</th>
                <th>Precio</th>
                <th>Acción</th>
            </tr>
          </thead>
          <tbody>
               <?php foreach($listaProductos as $productos) { ?>
               <tr>
                
                <td> <?php echo $productos['id']?></td>
                <td> <?php echo $productos['Categoria_idCategoria']?></td>
                <td> 
                <img src="../../img/<?php echo $productos['imagen']?>"width="120" alt="" srcset="">    
                </td>
                <td> <?php echo $productos['marca']?></td>
                <td> <?php echo $productos['modelo']?></td>
                <td> <?php echo $productos['tamanio']?></td>
                <td> <?php echo $productos['precio']?></td>
                <td>

                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $productos['id'] ?>"/>

                    <input type="submit" name = "accion"value="Seleccionar" class="btn btn-primary"/>
                    <input type="submit" name = "accion"value="Borrar" class="btn btn-danger"/>
                </form>
                </td>
                
               </tr>
            <?php }?>
           </tbody>
        </table>
    </div>
    </div>
</div>


<?php
include("../template/pie.php");
?>