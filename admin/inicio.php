<?php
include('template/cabezera.php')
?>

<?php 
     $url="http://".$_SERVER['HTTP_HOST']."/sitioWeb" 
     ?>
    <div class="col-md-12">
    <div class="jumbotron">
        <h1 class="display-3">BIENBENIDO</h1>
            <p class="lead">PAPU - ADMINISTRADOR </p>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Porro molestias voluptatibus assumenda nemo tempore ipsum error laborum! Odio dolore minus, eaque dolorem itaque vitae labore magni sapiente perferendis magnam velit?
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque ullam quam, ipsa voluptatum dolores est aperiam, soluta ab, quidem cumque ex. Delectus maxime exercitationem officia debitis nulla! Eum, qui quaerat!
            </p>
            <hr class="my-2">
            <p></p>
            <p class="lead">
            <a class="btn btn-primary btn-lg" href="<?php echo $url;?>" role="button">VER PAGINA DE TIENDA</a>

             
            </p>
        </div>
    </div>
    <?php
include('template/pie.php')
?>