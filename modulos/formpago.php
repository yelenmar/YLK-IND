<?php

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?modulo=procesar_login");
    exit();
} else {
    $usuario_id = $_SESSION['usuario_id'];

    // Obtener el id del producto desde la URL
    if (isset($_GET['id'])){
        $producto_id = $_GET['id'];
    }

    $sql= "SELECT precio FROM productos WHERE id= $producto_id";
        $sql=mysqli_query($con, $sql);
        if (!mysqli_error($con)) {
            $total = mysqli_fetch_array($sql);
        }
?>
    <form  class="formpago" action="index.php?modulo=confirmar_compra&id=<?php echo $producto_id?>" method="post">
        <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
        <!-- hacer un selec para obtener precio del producto -->
        <input type="hidden" name="precio" value="<?php echo $total['precio']; ?>">

        <label for="numero_tarjeta">Número de Tarjeta:</label>
        <input type="text" name="numero_tarjeta" id="numero_tarjeta" maxlength="16" required>

        <label for="codigo_seguridad">Código de Seguridad:</label>
        <input type="text" name="codigo_seguridad" id="codigo_seguridad" maxlength="4" required>

        <label for="fecha_vencimiento">Direccion:</label>
        <input type="text" name="direccion" id="direccion" ,required>

        <input id="confirmarcompra" type="submit" value="Confirmar Compra">
    </form>
<?php
}
?>
