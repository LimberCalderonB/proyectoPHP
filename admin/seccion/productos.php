<?php
include("../template/cabezera.php");
?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtmarca=(isset($_POST['txtmarca']))?$_POST['txtmarca']:"";
$txtmodelo=(isset($_POST['txtmodelo']))?$_POST['txtmodelo']:"";
$txtprecio=(isset($_POST['txtprecio']))?$_POST['txtprecio']:"";
$txttamaño=(isset($_POST['txttamaño']))?$_POST['txttamaño']:"";
$txtCategoria_idCategoria=(isset($_POST['txtCategoria_idCategoria']))?$_POST['txtCategoria_idCategoria']:"";

$txtimagen=(isset($_FILES['txtimagen']['name']))?$_FILES['txtimagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");


switch($accion){
     //INSERT INTO productos (id, marca, tamaño, modelo, imagen, precio, Categoria_idCategoria) VALUES (NULL, marca, tamaño, modelo, imagen, precio, id categoria);
     /*case "Agregar":
          $sentenciaSQL = $conexion->prepare("INSERT INTO productos (marca, tamaño, modelo, imagen, precio, Categoria_idCategoria) VALUES ( :marca, :tamaño, :modelo, :imagen, :precio, :Categoria_idCategoria);");
          $sentenciaSQL->bindParam(':Categoria_idCategoria', $txtCategoria_idCategoria);
          $sentenciaSQL->bindParam(':marca', $txtmarca);
          $sentenciaSQL->bindParam(':tamaño', $txttamaño);
          $sentenciaSQL->bindParam(':modelo', $txtmodelo);
          $sentenciaSQL->bindParam(':imagen', $txtimagen);
          $sentenciaSQL->bindParam(':precio', $txtprecio);
          $sentenciaSQL->execute();*/

          /*$sentenciaSQL=$conexion->prepare("INSERT INTO `productos` (`id`, `marca`, `tamaño`, `modelo`, `imagen`, `precio`, `Categoria_idCategoria`) VALUES (NULL, 'samsung', '18', '4544544dc', 'imagen', '2000.00', '1');");
          $sentenciaSQL->execute();*/

          /*$sentenciaSQL=$conexion->prepare("INSERT INTO `productos` (`id`, `marca`, `tamaño`, `modelo`, `imagen`, `precio`, `Categoria_idCategoria`) VALUES (NULL, :'marca', :'tamaño', :'modelo', :'imagen', :'precio', :'Categoria_idCategoria');");
          $sentenciaSQL->bindParam(":'marca'",$txtmarca);
          $sentenciaSQL->bindParam(":'tamaño'",$txttamaño);
          $sentenciaSQL->bindParam(":'modelo'",$txtmodelo);
          $sentenciaSQL->bindParam(":'imagen'",$txtimagen);
          $sentenciaSQL->bindParam(":'precio'",$txtprecio);
          $sentenciaSQL->bindParam(":'Categoria_idCategoria'",$txtCategoria_idCategoria);
          $sentenciaSQL->execute();*/
          
          case "Agregar":
               
               $sentenciaSQL = $conexion->prepare("INSERT INTO productos (marca, tamaño, modelo, imagen, precio, Categoria_idCategoria) VALUES (marca, tamaño, modelo, imagen, precio, Categoria_idCategoria)");
               $sentenciaSQL->bindParam('marca', $txtmarca);
               $sentenciaSQL->bindParam('tamaño', $txttamaño);
               $sentenciaSQL->bindParam('modelo', $txtmodelo);
               $sentenciaSQL->bindParam('imagen', $txtimagen);
               $sentenciaSQL->bindParam('precio', $txtprecio);
               $sentenciaSQL->bindParam('Categoria_idCategoria', $txtCategoria_idCategoria);
               $sentenciaSQL->Execute();
               

               
          break;
               
           
     case "Modificar":
          

          break;
     case "Eliminar":
          

          break;
     case "Cancelar":
          

          break;
}


?>

<div class="col-md-5">
    
    <div class="card">
    <div class="card-header">
        DATOS DE TELEVISOR
    </div>

    <div class="card-body">
        
    <form method="POST" enctype="multipart/form-data">

        <div class = "form-group">
             <label for="txtimagen">IMAGEN</label>
             <input type="file" class="form-control"name="txtimagen" id="txtimagen">
        </div>

        <div class = "form-group">
             <label for="txtCategoria_idCategoria">ID-Categoria</label>
             <input type="text" class="form-control"name="txtCategoria_idCategoria" id="txtCategoria_idCategoria" placeholder="Categoria:">
        </div>

        <div class = "form-group">
             <label for="txtprecio">PRECIO</label>
             <input type="text" class="form-control"name="txtprecio" id="txtprecio" placeholder="PRECIO : ">
        </div>

        <div class = "form-group">
             <label for="textmarca">MARCA:</label>
             <input type="text" class="form-control"name="txtmarca" id="txtmarca" placeholder="MARCA DEL TELEVISOR :">
        </div>

        <div class = "form-group">
             <label for="txtmodelo">MODELO</label>
             <input type="txt" class="form-control"name="txtmodelo" id="txtmodelo" placeholder="MODELO :">
        </div>

        <div class = "form-group">
             <label for="txttamaño">PULGADAS</label>
             <input type="text" class="form-control"name="txttamaño" id="txttamaño" placeholder="PULGADAS :">
        </div>

       <div class="btn-group" role="group" aria-label="">
             <button type="submit" name="accion" value="Agregar" class="btn btn-info">AGREGAR</button>
             <button type="submit" name="accion" value="Modificar" class="btn btn-warning">MODIFICAR</button>
             
             <button type="submit" name="accion" value="Cancelar" class="btn btn-info">CANCELAR</button>
       </div>
    </form>
</div>
</div>
</div>
<div class="col-md-7">
    
    <table class="table table-bordered">
            <thead>
              <tr>
                <th>IMAGEN</th>
                <th>ID</th>
                <th>MARCA</th>
                <th>MODELO</th>
                <th>PULAGADAS</th>
                <th>PRECIO</th>
                <th>ACCIONES</th>
            </tr>
          </thead>
          <tbody>
               <tr>
                <td>Imagen</td>
                <td></td>
                <td></td>
                <td></td>
                <td> </td>
                <td> </td>
                <td> Seleccionar | borrar</td>
                
            </tr>
           </tbody>
        </table>
    </div>
    </div>
</div>


<?php
include("../template/pie.php");
?>