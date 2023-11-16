<?php
// Verificar la conexión
if (!$con) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta para obtener la información de la empresa
$query = "SELECT historia, valores FROM informacion_empresa WHERE id = 1"; 

$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $historia = $row['historia'];
    $valores = $row['valores'];
} else {
    $historia = "No se encontró la historia";
    $valores = "No se encontraron valores";
}
?>


<section id="quienes-somos" class="section">
    <div class="historia">
        <h3>Nuestra Historia</h3>
        <p><?php echo $historia; ?></p>
    </div>
    <div class="valores">
        <h3>Nuestros Valores</h3>
        <p><?php echo $valores; ?></p>
    </div>
</section>
