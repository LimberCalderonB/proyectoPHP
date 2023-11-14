<?php
include("../template/cabezera.php");
?>
<?php

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
               $sentenciaSQL = $conexion->prepare("INSERT INTO productos (imagen, Categoria_idCategoria, precio, marca, modelo, tamanio )  
                VALUES (?,?,?,?,?,? )");

               $fecha=new DateTime();
               $nombreArchibo=($txtimagen!="")?$fecha->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen";
               $tmpimagen=$_FILES["txtimagen"]["tmp_name"];

               if($tmpimagen!=""){
                    move_uploaded_file($tmpimagen,"../../img/".$nombreArchibo);
               }
               $sentenciaSQL->bindParam(1, $nombreArchibo);

               $sentenciaSQL->bindParam(2, $txtCategoria_idCategoria);
               $sentenciaSQL->bindParam(3, $txtprecio);
               $sentenciaSQL->bindParam(4, $txtmarca);
               $sentenciaSQL->bindParam(5, $txtmodelo);
               $sentenciaSQL->bindParam(6, $txttamanio);              
          
               $sentenciaSQL->execute();

               header("Location:productos.php");
           break;
           
     case "Modificar":
          

          if($txtimagen!=""){
               
               $fecha=new DateTime();
               $nombreArchibo=($txtimagen!="")?$fecha->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen";
               $tmpimagen=$_FILES["txtimagen"]["tmp_name"];
               move_uploaded_file($tmpimagen,"../../img/".$nombreArchibo);

               $sentenciaSQL= $conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();
          $productos=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

          if (isset($productos["imagen"])&&($productos["imagen"]!="imagen")){
               if(file_exists("../../img/".$productos["imagen"])){
                    unlink("../../img/".$productos["imagen"]);
               }
          }



          $sentenciaSQL= $conexion->prepare("UPDATE productos SET imagen=:imagen WHERE id=:id");
          $sentenciaSQL->bindParam(':imagen', $nombreArchibo);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          }

          $sentenciaSQL= $conexion->prepare("UPDATE productos SET Categoria_idCategoria=:Categoria_idCategoria WHERE id=:id");
          $sentenciaSQL->bindParam('Categoria_idCategoria', $txtCategoria_idCategoria);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE productos SET precio=:precio WHERE id=:id");
          $sentenciaSQL->bindParam(':precio', $txtprecio);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE productos SET marca=:marca WHERE id=:id");
          $sentenciaSQL->bindParam(':marca', $txtmarca);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE productos SET modelo=:modelo WHERE id=:id");
          $sentenciaSQL->bindParam(':modelo', $txtmodelo);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE productos SET tamanio=:tamanio WHERE id=:id");
          $sentenciaSQL->bindParam(':tamanio', $txttamanio);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          header("Location:productos.php");

          break;
     case "Cancelar":
               header("Location:productos.php");
               break;
           
          break;
                 
          case "Seleccionar":
               $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE id=:id");
               $sentenciaSQL->bindParam(':id', $txtID);
               $sentenciaSQL->execute();
               $productos = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
           
               $txtCategoria_idCategoria = $productos['Categoria_idCategoria']; 
               $txtimagen = $productos['imagen'];
               $txtprecio = $productos['precio'];
               $txtmarca = $productos['marca'];
               $txtmodelo = $productos['modelo'];
               $txttamanio = $productos['tamanio'];
           
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