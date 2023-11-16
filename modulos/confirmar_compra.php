<?php
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?modulo=procesar_login");
} else {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $producto_id = $_POST['producto_id'];
        $usuario_id = $_SESSION['usuario_id'];
        $numero_tarjeta = $_POST['numero_tarjeta'];
        $codigo_seguridad = $_POST['codigo_seguridad'];
        $direccion = $_POST['direccion'];

        // Realizar la inserción de la compra
        $sql = "SELECT precio FROM productos WHERE id = $producto_id";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $total = mysqli_fetch_assoc($result)['precio'];

            $insert_compra = "INSERT INTO compras(usuario_id, total, numero_tarjeta, codigo_seguridad, direccion) VALUES ($usuario_id, $total, $numero_tarjeta, $codigo_seguridad, '$direccion')";
            $result_compra = mysqli_query($con, $insert_compra);

            if ($result_compra) {
                $compra_id = mysqli_insert_id($con);
                $insert_detalle_compra = "INSERT INTO detalles_compras(compra_id, producto_id, cantidad, subtotal) VALUES ($compra_id, $producto_id, 1, $total)";
                $result_detalle_compra = mysqli_query($con, $insert_detalle_compra);

                if ($result_detalle_compra) {
                    // Obtener el nombre del usuario
                    $get_user_name_query = "SELECT nombre FROM usuarios WHERE id = $usuario_id";
                    $user_name_result = mysqli_query($con, $get_user_name_query);
                
                    if ($user_name_result && mysqli_num_rows($user_name_result) > 0) {
                        $user_name = mysqli_fetch_assoc($user_name_result)['nombre'];
                        echo "<div class='mensaje'>";
                        echo "Pago realizado con éxito.<br>";
                        echo "Gracias \"$user_name\", ha realizado su compra n° $compra_id.";
                        echo "</div>";
                    } else {
                        echo "<div class='mensaje'>";
                        echo "ERROR: No se pudo obtener el nombre del usuario.";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='mensaje'>";
                    echo "ERROR: No se pudo realizar el pago.";
                    echo "</div>";
                }
            } else {
                echo "<div class='mensaje'>";
                echo "ERROR: No se pudo realizar el pago.";
                echo "</div>";
            }
        } else {
            echo "<div class='mensaje'>";
            echo "ERROR: Producto no encontrado.";
            echo "</div>";
        }
    }
}
?>
