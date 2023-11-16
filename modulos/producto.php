<br>
<br>
<a href="index.php?modulo=producto&orden=nombre" id="botonorden">Ordenar por nombre</a>
<a href="index.php?modulo=producto&orden=precio" id="botonorden">Ordenar por precio</a>
<br>
<?php
if (!$con) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Verificar si se ha enviado una solicitud de ordenamiento
if (isset($_GET['orden'])) {
    $orden = $_GET['orden'];
    
    // Llamar al procedimiento almacenado correspondiente según la opción de ordenamiento
    if ($orden === 'nombre') {
        $sql = "CALL ObtenerProductosOrdenadosPorNombre()";
    } elseif ($orden === 'precio') {
        $sql = "CALL ObtenerProductosOrdenadosPorPrecio()";
    } else {
        $sql = "SELECT * FROM productos";
    }
} else {
    $sql = "SELECT * FROM productos";
}

$result = $con->query($sql);
echo "<br>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='producto-tarjeta'>";
        echo "<img src='img/{$row['foto']}' alt='{$row['nombre']}'>";
        echo "<h2>" . $row['nombre'] . "</h2>";
        echo "<p>Precio: $" . $row['precio'] . "</p>";
        echo "<a href='index.php?modulo=comprar&id={$row['id']}'><h3><b>Ver detalles</b></h3></a>";
        echo "</div>";
    }
} else {
    echo "No se encontraron productos.";
}
?>
