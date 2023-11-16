<?php
    include('../includes/conexion.php');
    conectar();

    $sql=mysqli_query($con,"SELECT foto_blob FROM productos WHERE id=" .$_GET['id']);
    $r=mysqli_fetch_array($sql);
    header('Content-type: img/jpg');
    echo $r['foto_blob'];
?>