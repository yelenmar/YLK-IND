<?php

if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

// Agregar productos al carrito
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    $sql = "SELECT * FROM productos WHERE id = $producto_id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        $_SESSION['carrito'][] = $producto;
    }
}

// Eliminar productos del carrito
if (isset($_GET['eliminar']) && !empty($_SESSION['carrito'])) {
    $indice = $_GET['eliminar'];
    unset($_SESSION['carrito'][$indice]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

// Vaciar el carrito
if (isset($_GET['vaciar'])) {
    unset($_SESSION['carrito']);
}
?>

<div class="carrito">
        <?php
        $total = 0; // Variable para almacenar el total del carrito

        // Mostrar productos en el carrito
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $indice => $producto) {
                $subtotal = $producto['precio']; // Precio individual del producto
                $total += $subtotal; // Sumar al total del carrito
        ?>
                <div class='producto'>
                    <?php  echo "<img src='img/{$row['foto']}' alt='{$row['nombre']}'>"; ?>
                    <h3><?php echo $producto['nombre']; ?></h3>
                    <p>Precio: $<?php echo $producto['precio']; ?></p>
                    <form action='comprar_producto.php' method='post'>
                        <input type='hidden' name='producto_id' value='<?php echo $producto['id']; ?>'>
                        <?php
                             echo "<a class='buttomcomprar' href='index.php?modulo=formpago&id={$row['id']}'><h3><b>Comprar producto</b></h3></a>";
                        ?>
                    </form>
                    <hr>
                </div>
        <?php
            }
        } else {
            echo "El carrito está vacío.";
        }
        ?>
    </div>

    <!-- Mostrar el total del carrito -->
    <div class="total">
        <?php
            echo "<h3>Total: $" . $total . "</h3>";
            echo "<a class='buttomcomprar' href='index.php?modulo=formpago&id={$row['id']}'><h3><b>Comprar todo el carrito</b></h3></a>";
        ?>
        </form>
    </div>

<?php
// Mostrar productos en el carrito
if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $indice => $producto) {
        echo "<div class='producto'>";
        echo "<h3>" . $producto['nombre'] . "</h3>";
        echo "<p>Precio: $" . $producto['precio'] . "</p>";
        echo "<a href='carrito.php?eliminar=$indice'>Eliminar</a>";
        echo "</div>";
    }
} else {
    echo "El carrito está vacío.";
}
?>

<!-- Enlaces o botones para vaciar el carrito -->
<?php
    echo "<a class='buttomcomprar' href='index.php?modulo=&id={$row['id']}'><h3><b>Vaciar carrito</b></h3></a>";
?>

