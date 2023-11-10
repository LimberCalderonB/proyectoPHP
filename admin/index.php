<?php
if($_POST){
    header('Location:inicio.php');
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
        
        <br/><br/><br/>
        <div class="row">
             <div class="col-md-3">
            
             </div>

             <br/>
             
            <div class="col-md-5">

                <div class="card">
                    <div class="card-header">
                         INICIAR SESION
                    </div>
                    <div class="card-body">

                        <form method="POST">

                        <div class = "form-group">
                        <label >USUARIO</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Ingresa tu Usuario">
                        <small id="emailHelp" class="form-text text-muted"></small>

                        </div>
                        <div class="form-group">
                        <label>CONTRASEÑA</label>
                        <input type="password" class="form-control" name="contrasenia"  placeholder="Ingresa tu contraseña">
                        </div>
                    
                        <button type="submit" class="btn btn-primary">INGRESAR AL SISTEMA</button>
                        </form>
                        
                        
                    </div>
                    
                </div>
            </div>
            
        </div>
      </div>
  </body>
</html>