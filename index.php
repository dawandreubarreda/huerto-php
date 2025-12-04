<?php
    //Llamada al archivo con los datos de conexión.
    require 'conexion.php';
    
    // Función para calcular el ciclo del cultivo.
    function cicloCultivo($dias) {
        if ($dias < 60) {
            return "Corto";
        } elseif ($dias >= 60 && $dias <= 180) {
            return "Medio";
        } else {
            return "Tardío";
        }
    }
    
    $sql = "SELECT * FROM cultivos";
    $resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Cultivos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .btn-nuevo {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 10px;
        }
        .btn-nuevo:hover {
            background-color: #45a049;
        }
        .ciclo-corto {
            color: #28a745;
            font-weight: bold;
        }
        .ciclo-medio {
            color: #ffc107;
            font-weight: bold;
        }
        .ciclo-tardio {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Listado de Cultivos</h1>
    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Días de Cosecha</th>
            <th>Ciclo de Cultivo</th>
        </tr>
        
         
        <?php 
            // Recorremos la base de datos para obtener los resultados.
            while ($fila = mysqli_fetch_assoc($resultado)) { 
            $ciclo = cicloCultivo($fila['dias_cosecha']);
            $clase_ciclo = '';
            
            // Asignar clase CSS según el ciclo
            if ($ciclo === 'Corto') {
                $clase_ciclo = 'ciclo-corto';
            } elseif ($ciclo === 'Medio') {
                $clase_ciclo = 'ciclo-medio';
            } else {
                $clase_ciclo = 'ciclo-tardio';
            }
        ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['id']); ?></td>
                <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                <td><?php echo htmlspecialchars($fila['tipo']); ?></td>
                <td><?php echo htmlspecialchars($fila['dias_cosecha']); ?></td>
                <td class="<?php echo $clase_ciclo; ?>"><?php echo $ciclo; ?></td>
            </tr>
        <?php } ?>
    </table>
    
    <a href="nuevo.php" class="btn-nuevo">+ Añadir Cultivo</a>
    
</body>
</html>