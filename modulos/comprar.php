<?php
    if (isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "SELECT * FROM productos WHERE id = $id";
        $result = $con->query($sql);
    }

    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        echo "<div class='producto-detalle'>";
        echo "<img src='img/{$row['foto']}' alt='{$row['nombre']}'>";
        echo "<div class='producto-info'>";
        echo "<h2>" . $row['nombre'] . "</h2>";
        echo "<p><b>$" . $row['precio'] . "</b></p>";
        echo "<p><b>Descripción: </b><br>" . $row['descripcion'] . "</p>";

        // Botón para agregar al carrito
        echo "<form action='carrito.php' method='post'>";
        echo "<input type='hidden' name='producto_id' value='{$row['id']}'>";
        echo "<a class='buttomcomprar' href='index.php?modulo=carrito&id={$row['id']}'><h3>Agregar al Carrito</h3></a>";
        echo "</form>";

        // Botón para proceder con la compra
        echo "<form action='formapago.php' method='post'>";
        echo "<input type='hidden' name='producto_id' value='{$row['id']}'>";
        echo "<a class='buttomcomprar' href='index.php?modulo=formpago&id={$row['id']}'><h3><b>Comprar</b></h3></a>";
        echo "</form>";

        echo "</div>"; // Cierre de producto-info
        echo "</div>"; // Cierre de producto-detalle
        } else {
        echo "Producto no encontrado.";
    }
    
?>