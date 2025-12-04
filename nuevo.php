<?php
// Mostrar mensaje si hay un error.
$error = $_GET['error'] ?? null;
$mensaje_error = '';

if ($error === 'error_insercion') {
    $mensaje_error = "No se pudo guardar el cultivo. Por favor, inténtelo de nuevo.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Cultivo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #4CAF50;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .link-volver {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }
        .link-volver:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Cultivo</h1>
        <?php if ($mensaje_error): ?>
            <div style="color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($mensaje_error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="procesar.php">
            <div class="form-group">
                <label for="nombre">Nombre del Cultivo:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label for="tipo">Tipo de Cultivo:</label>
                <select id="tipo" name="tipo" required>
                    <option value="">-- Selecciona un tipo --</option>
                    <option value="Hortaliza">Hortaliza</option>
                    <option value="Fruto">Fruto</option>
                    <option value="Aromática">Aromática</option>
                    <option value="Legumbre">Legumbre</option>
                    <option value="Tubérculo">Tubérculo</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="dias_cosecha">Días de Cosecha:</label>
                <input type="number" id="dias_cosecha" name="dias_cosecha" min="1" required>
            </div>
            
            <button type="submit" class="btn">Registrar Cultivo</button>
        </form>
        
        <a href="index.php" class="link-volver">← Volver al listado</a>
    </div>
</body>
</html>