<?php
  session_start();
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  include('includes/conexion.php');
  conectar();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>YLK IND.</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  </head>
  <body>
  <header>
    <div class="left">
        <img src="img/logo.jpeg" alt="logo" id="logo" />
    </div>
    <?php
    if (isset($_SESSION['nombre_usuario'])) {
    ?>
    <div class="right">
        <p>Bienvenido/a
          <b> 
            <?php echo $_SESSION['nombre_usuario'] ?>
           
          </b> !
        </p>
        <a href="index.php?modulo=procesar_login&salir=ok">
          <p><b>Cerrar Sesión</b></p>
        </a>
    </div>
    <?php
    }
    ?>
</header>
<nav>
    <hr/>
    <div class="navleft">
        <a href="index.php">Inicio</a>
        <a href="index.php?modulo=producto">Productos</a>
        <a href="index.php?modulo=contacto">Contacto</a>
        <a href="index.php?modulo=acerca_de">¿Quienes somos?</a>
    </div>
    <div class="navright">
        <a href="index.php?modulo=procesar_registro">Registro</a>
        <a href="index.php?modulo=procesar_login">Login</a>
        <a href="index.php?modulo=carrito">
          <img src="img/carrito.png" alt="carrito" id="carrito">
        </a>

    </div>
    <hr style="margin-bottom: 0px" />
</nav>

    <main>
    <?php
      if (!empty($_GET['modulo'])) {
        include('modulos/'.$_GET['modulo'].'.php');
      }else{
        ?>
          <div class="main" style="margin-top: 0">
            <img src="img/banner.gif" alt="video" class="video"><img src="img/banner1.gif" alt="video" class="video"><img src="img/banner.gif" alt="video" class="video"><img src="img/banner1.gif" alt="video" class="video">
          </div>
        <?php 
      }
    ?>

    </main>
    <footer>
      <div class="footer">
        <p>
          © 2023 Todos los derechos reservados.
          <a href="https://www.instagram.com/yelenkamaroseck"
            >Autor: Yelenka Maroseck.</a
          >
        </p>
      </div>
    </footer>
    
  </body>
</html>