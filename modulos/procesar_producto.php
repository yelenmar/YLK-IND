<?php
//capturo errores
if(!isset($_GET['accion'])){
    $_GET['accion'] = '';
}
//insertar
if($_GET['accion'] == 'guardar_insertar'){
    //verifico que no exista el producto
    $sql = "SELECT *FROM productos where nombre = '{$_POST['nombre']}'";
    $sql = mysqli_query($con, $sql);
    if(mysqli_num_rows($sql) != 0){
        echo "<script> alert('EL producto YA EXISTE EN LA BD');</script>";
    }else{
        //procesar la foto
        if(is_uploaded_file($_FILES['foto']['tmp_name'])){
            //copiar en un directorio
            $nombre = explode('.', $_FILES['foto']['name']);
            $foto = time().'.'.end($nombre);
            copy($_FILES['foto']['tmp_name'], 'img/'.$foto);

            //obtener el blob
            $image = $_FILES['foto']['tmp_name'];
            $imgContenido = addslashes(file_get_contents($image));
        }
        //fin de procesar la foto

        //inserto nuevo producto
        $sql = "INSERT INTO productos (nombre,descripcion,precio,foto,foto_blob) values('{$_POST['nombre']}','{$_POST['descripcion']}',{$_POST['precio']},'{$foto}','{$imgContenido}')";
        $sql = mysqli_query($con, $sql);
        if(mysqli_error($con)){
            echo "<script> alert('ERROR NO SE PUDO INSERTAR EL producto);</script>";
        }else{
            echo "<script> alert('producto cargado con exito');</script>";
        }
    }    
}

//editar 
if($_GET['accion'] == 'guardar_editar'){
    //controlo si tengo que editar la foto
    if(is_uploaded_file($_FILES['foto']['tmp_name'])){
        //copiar en un directorio
        $nombre = explode('.', $_FILES['foto']['name']);
        $foto = time().'.'.end($nombre);
        copy($_FILES['foto']['tmp_name'], '../img/'.$foto);

        //obtener el blob
        $image = $_FILES['foto']['tmp_name'];
        $imgContenido = addslashes(file_get_contents($image));

        //armo la cadena para editar las fotos
        $mas_datos = ", foto='".$foto."', foto_blob='".$imgContenido."'";
    }else{
        $mas_datos = '';
    }
        //fin de controlar si tengo que editar la foto
    $sql = "UPDATE productos SET nombre='{$_POST['nombre']}', descripcion='{$_POST['descripcion']}' {$mas_datos} WHERE id=".$_GET['id'];
    $sql = mysqli_query($con, $sql);
    if(!mysqli_error($con)){
        echo "<script> alert('producto editado con exito');</script>";
    }else{
        echo "<script> alert('ERROR NO SE PUDO editar EL producto);</script>";
    }
}

//eliminar 
if($_GET['accion'] == 'guardar_eliminar'){
    $sql = "UPDATE productos SET eliminado=1 WHERE id=".$_GET['id'];
    $sql = mysqli_query($con, $sql);
    if(!mysqli_error($con)){
        echo "<script> alert('producto eliminado con exito');</script>";
    }else{
        echo "<script> alert('ERROR NO SE PUDO eliminar EL producto);</script>";
    }
}
?>
<section id="admin" class="section">
    <h2>Panel de Administración</h2>
    <?php
    if($_GET['accion']=='editar'){
        $url = 'index.php?modulo=procesar_producto&accion=guardar_editar&id='.$_GET['id'];
        $sql = "SELECT *FROM productos WHERE id = ".$_GET['id'];
        $sql = mysqli_query($con, $sql);
        if(mysqli_num_rows($sql) != 0){
            $r = mysqli_fetch_array($sql);
        }
    }else{
        $url = 'index.php?modulo=procesar_producto&accion=guardar_insertar';
        $r['nombre'] = $r['descripcion'] = $r['precio'] =$r['talle']=$r['foto'] = '';
    }
    ?> 
    <form id="form" action="<?php echo $url;?>" method="POST" enctype="multipart/form-data">
        <label for="dproducto-nombre">Nombre del producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $r['nombre'];?>" required>
        
        <label for="producto-descripcion">Descripción del producto:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo $r['descripcion'];?></textarea>

        <label for="producto-precio">Precio del producto:</label>
        <textarea id="precio" name="precio" required><?php echo $r['precio'];?></textarea>

        <label for="producto-nombre">Foto:</label>
        <input type="file" id="foto" name="foto">

        <?php
        if(!empty($r['foto'])){
            ?>
            <img src="img/<?php echo $r['foto'];?>" width="100%">
            <?php
        }
        ?>
        <button type="submit">Agregar producto</button>
    </form>
</section>

<section id="admin" class="section">
    <h2>Listado</h2>
    <table id="table" border="1" style="width: 100%;">
        <tr>
            <td>Item</td>
            <td>Nombre</td>
            <td>Opciones</td>
        </tr>
        <?php
        $sql = "SELECT id, nombre FROM productos WHERE eliminado=0 ORDER BY nombre";
        $sql = mysqli_query($con, $sql);
        if(mysqli_num_rows($sql) != 0){
            while($r = mysqli_fetch_array($sql)){
                ?>
                <tr>
                    <td><?php echo $r['id'];?></td>
                    <td align="left"><?php echo $r['nombre'];?></td>
                    <td>
                        <a href="index.php?modulo=procesar_producto&accion=editar&id=<?php echo $r['id'];?>">Editar</a>
                        -
                        <a href="javascript:if(confirm('Desea eliminar el registro?')) window.location='index.php?modulo=procesar_producto&accion=guardar_eliminar&id=<?php echo $r['id'];?>'">Eliminar</a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</section>