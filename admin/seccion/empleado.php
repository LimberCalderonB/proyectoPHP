
<?php
include("../template/cabezera.php");
?>

<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtimagen=(isset($_FILES['txtimagen']['name']))?$_FILES['txtimagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

$txtnombre=(isset($_POST['txtnombre']))?$_POST['txtnombre']:"";
$txtapellido1=(isset($_POST['txtapellido1']))?$_POST['txtapellido1']:"";
$txtapellido2=(isset($_POST['txtapellido2']))?$_POST['txtapellido2']:"";

$txtsalario=(isset($_POST['txtsalario']))?$_POST['txtsalario']:"";
$txtdireccion=(isset($_POST['txtdireccion']))?$_POST['txtdireccion']:"";
$txtnumero_celular_empleado=(isset($_POST['txtnumero_celular_empleado']))?$_POST['txtnumero_celular_empleado']:"";

include("../config/bd.php");

switch($accion){


          case "Agregar":

               $sentenciaSQL = $conexion->prepare("INSERT INTO empleado (imagen, nombre, apellido1, apellido2, salario, direccion, numero_celular_empleado) VALUES ( ?, ?, ?, ?, ?, ?, ?)");

               $fecha=new DateTime();
               $nombreArchibo=($txtimagen!="")?$fecha->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen";
               $tmpimagen=$_FILES["txtimagen"]["tmp_name"];

               if($tmpimagen!=""){
                    move_uploaded_file($tmpimagen,"../../img/".$nombreArchibo);
               }
               $sentenciaSQL->bindParam(1, $nombreArchibo);
               $sentenciaSQL->bindParam(2, $txtnombre);
               $sentenciaSQL->bindParam(3, $txtapellido1);
               $sentenciaSQL->bindParam(4, $txtapellido2);
               $sentenciaSQL->bindParam(5, $txtsalario);
               $sentenciaSQL->bindParam(6, $txtdireccion);   
                 
               $sentenciaSQL->bindParam(7, $txtnumero_celular_empleado);             
               $sentenciaSQL->execute();

               header("Location:empleado.php");
           break;
           
     case "Modificar":
          

          if($txtimagen!=""){
               
               $fecha=new DateTime();
               $nombreArchibo=($txtimagen!="")?$fecha->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen";
               $tmpimagen=$_FILES["txtimagen"]["tmp_name"];
               move_uploaded_file($tmpimagen,"../../img/".$nombreArchibo);

               $sentenciaSQL= $conexion->prepare("SELECT imagen FROM empleado WHERE id=:id");
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();
          $empleado=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

          if (isset($empleado["imagen"])&&($empleado["imagen"]!="imagen")){
               if(file_exists("../../img/".$empleado["imagen"])){
                    unlink("../../img/".$empleado["imagen"]);
               }
          }



          $sentenciaSQL= $conexion->prepare("UPDATE empleado SET imagen=:imagen WHERE id=:id");
          $sentenciaSQL->bindParam(':imagen', $nombreArchibo);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          }

          $sentenciaSQL= $conexion->prepare("UPDATE empleado SET nombre=:nombre WHERE id=:id");
          $sentenciaSQL->bindParam(':nombre', $txtnombre);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE empleado SET apellido1=:apellido1 WHERE id=:id");
          $sentenciaSQL->bindParam(':apellido1', $txtapellido1);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE empleado SET apellido2=:apellido2 WHERE id=:id");
          $sentenciaSQL->bindParam(':apellido2', $txtapellido2);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE empleado SET salario=:salario WHERE id=:id");
          $sentenciaSQL->bindParam(':salario', $txtsalario);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE empleado SET direccion=:direccion WHERE id=:id");
          $sentenciaSQL->bindParam(':direccion', $txtdireccion);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          $sentenciaSQL= $conexion->prepare("UPDATE empleado SET numero_celular_empleado=:numero_celular_empleado WHERE id=:id");
          $sentenciaSQL->bindParam(':numero_celular_empleado', $txtnumero_celular_empleado);
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();


          header("Location:empleado.php");

          break;
     case "Cancelar":
               header("Location:empleado.php");
               break;
           
          break;
                 
          case "Seleccionar":
              

               $sentenciaSQL = $conexion->prepare("SELECT * FROM empleado WHERE id=:id");
               $sentenciaSQL->bindParam(':id', $txtID);
               $sentenciaSQL->execute();
               $empleado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

if ($empleado) {
    $txtimagen = $empleado['imagen'];
    $txtnombre = $empleado['nombre'];            
    $txtapellido1 = $empleado['apellido1'];
    $txtapellido2 = $empleado['apellido2'];
    $txtsalario = $empleado['salario'];
    $txtdireccion = $empleado['direccion'];
    $txtnumero_celular_empleado = $empleado['numero_celular_empleado'];
} else {
   
    $txtimagen = "";
    $txtnombre = "";
    $txtapellido1 = "";
    $txtapellido2 = "";
    $txtsalario = "";
    $txtdireccion = "";
    $txtnumero_celular_empleado = "";
}
         
               break;         
                 
     case "Borrar":
          $sentenciaSQL= $conexion->prepare("SELECT imagen FROM empleado WHERE id=:id");
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();
          $empleado=$sentenciaSQL->fetch(PDO::FETCH_ASSOC);

          if (isset($empleado["imagen"])&&($empleado["imagen"]!="imagen")){
               if(file_exists("../../img/".$empleado["imagen"])){
                    unlink("../../img/".$empleado["imagen"]);
               }
          }

          $sentenciaSQL= $conexion->prepare("DELETE FROM empleado WHERE id=:id");
          $sentenciaSQL->bindParam(':id', $txtID);
          $sentenciaSQL->execute();

          header("Location:empleado.php");

          break;
}
$sentenciaSQL= $conexion->prepare("SELECT * FROM empleado");
$sentenciaSQL->execute();
$listaempleado=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-4">
    
    <div class="card">
    <div class="card-header">
        DATOS DE EMPLEADO
    </div>

    <div class="card-body">
        
    <form method="POST" enctype="multipart/form-data">

        <div class = "form-group">
             <label for="txtimagen">IMAGEN</label>
             <?php echo $txtimagen; ?> 
            
             <input type="file" class="form-control" value="txtimagen " name="txtimagen" id="txtimagen" >
        </div>

        <div class = "form-group">
             <label for="txtID">ID</label>
             <input type="text"required readonly class="form-control" value="<?php echo $txtID; ?> " name="txtID" id="txtID" placeholder="ID :">
        </div>

        <div class = "form-group">
             <label for="txtnombre">Nombre</label>
             <input type="text"  class="form-control" value="<?php echo $txtnombre; ?> " name="txtnombre" id="txtnombre" placeholder="Nombre : ">
        </div>

        <div class = "form-group">
             <label for="txtapellido1">Primer Apellido</label>
             <input type="text" class="form-control" value="<?php echo $txtapellido1; ?>" name="txtapellido1" id="txtapellido1" placeholder="Primer Apellido : ">
        </div>

        <div class = "form-group">
             <label for="txtapellido2">Segundo Apellido</label>
             <input type="text"  class="form-control" value="<?php echo $txtapellido2; ?>" name="txtapellido2" id="txtapellido2" placeholder="Segundo Apellido : ">
        </div>

        <div class = "form-group">
             <label for="txtsalario">Salario</label>
             <input type="text"  class="form-control" value="<?php echo $txtsalario; ?>" name="txtsalario" id="txtsalario" placeholder="Salario : ">
        </div>

        <div class = "form-group">
             <label for="txtdireccion">Direccion</label>
             <input type="text"  class="form-control" value="<?php echo $txtdireccion; ?>" name="txtdireccion" id="txtdireccion" placeholder="Diereccion : ">
        </div>

        <div class = "form-group">
             <label for="txtnumero_celular_empleado">Numero de Celular</label>
             <input type="text" class="form-control" value="<?php echo $txtnumero_celular_empleado; ?> " name="txtnumero_celular_empleado" id="txtnumero_celular_empleado" placeholder="Celular : ">
        </div>

       <div class="btn-group" role="group" aria-label="">
             <button type="submit" name="accion"<?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-info">AGREGAR</button>
             <button type="submit" name="accion"<?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">MODIFICAR</button>
             <button type="submit" name="accion"<?php echo ($accion!="Seleccionar"&&$accion=="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-danger">CANCELAR</button>
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
                <th>Foto</th>          
                <th>Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Salario</th>
                <th>Direccion</th>
                <th>Celular</th>
                <th>Acción</th>
            </tr>
          </thead>
          <tbody>
               <?php foreach($listaempleado as $empleado) { ?>
               <tr>
                
                <td> <?php echo $empleado['id']?></td>
                
                <td> 
                <img src="../../img/<?php echo $empleado['imagen']?>"width="120" alt="" srcset="">    
                </td>
                <td> <?php echo $empleado['nombre']?></td>
                <td> <?php echo $empleado['apellido1']?></td>
                <td> <?php echo $empleado['apellido2']?></td>
                <td> <?php echo $empleado['salario']?></td>
                <td> <?php echo $empleado['direccion']?></td>               
                <td> <?php echo $empleado['numero_celular_empleado']?></td>
                <td>

                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $empleado['id'] ?>"/>

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