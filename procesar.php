<?php
// Incluir el archivo de conexión
require_once 'logic/db.php';
// Llamada al archivo de la lógica:
require_once 'logic/cultivos.php';

$errores = [];

// Validar nombre con filter_input
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($nombre)) {
    $errores[] = "El nombre es obligatorio";
} elseif (strlen($nombre) < 3) {
    $errores[] = "El nombre debe tener al menos 3 caracteres";
}

// Validar tipo con filter_input
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$tipos_validos = ['Hortaliza', 'Fruto', 'Aromática', 'Legumbre', 'Tubérculo'];

if (empty($tipo)) {
    $errores[] = "El tipo de cultivo es obligatorio";
} elseif (!in_array($tipo, $tipos_validos)) {
    $errores[] = "El tipo de cultivo no es válido";
}

// Validar días de cosecha con filter_input
$dias_cosecha = filter_input(INPUT_POST, 'dias_cosecha', FILTER_VALIDATE_INT);
if ($dias_cosecha === false || $dias_cosecha === null) {
    $errores[] = "Los días de cosecha deben ser un número entero válido";
} elseif ($dias_cosecha <= 0) {
    $errores[] = "Los días de cosecha deben ser mayor a 0";
}

// Si hay errores, mostrarlos y detener
if (!empty($errores)) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error en el registro</title>
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
                color: #721c24;
                text-align: center;
            }
            .errores {
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 4px;
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
            .errores ul {
                margin: 0;
                padding-left: 20px;
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
        <div class='container'>
            <h1>Error en el Registro</h1>
            <div class='errores'>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>";
    
    foreach ($errores as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    
    echo "      </ul>
            </div>
            <a href='nuevo.php' class='link-volver'>← Volver al formulario</a>
        </div>
    </body>
    </html>";
    exit;
}

// ¡AHORA USAMOS SENTENCIA PREPARADA!
// ¡CAMBIO IMPORTANTE EN EL CÓDIGO!
$stmt = mysqli_prepare($conn, "INSERT INTO cultivos (nombre, tipo, dias_cosecha) VALUES (?, ?, ?)");
if ($stmt === false) {
    // Error al preparar la sentencia
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head><meta charset='UTF-8'><title>Error</title></head>
    <body>
        <h1>Error interno</h1>
        <p>No se pudo preparar la consulta.</p>
        <a href='nuevo.php'>← Volver al formulario</a>
    </body>
    </html>";
    exit;
}

// Vincular parámetros: "s" = string, "i" = integer
mysqli_stmt_bind_param($stmt, "ssi", $nombre, $tipo, $dias_cosecha);

// Ejecutar
if (mysqli_stmt_execute($stmt)) {
    // Éxito
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Cultivo Registrado</title>
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
                color: #155724;
                text-align: center;
            }
            .mensaje {
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 4px;
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
                text-align: center;
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
        <div class='container'>
            <h1>¡Cultivo Registrado!</h1>
            <div class='mensaje'>
                El cultivo <strong>" . htmlspecialchars($nombre) . "</strong> ha sido registrado correctamente.
            </div>
            <a href='index.php' class='link-volver'>← Volver al listado</a>
            <a href='nuevo.php' class='link-volver'>+ Registrar otro cultivo</a>
        </div>
    </body>
    </html>";
   
} else {
    // Registrar el error técnico en el log
    error_log("Error al insertar cultivo: " . mysqli_stmt_error($stmt));
    
    // Redirigir a una página con mensaje genérico
    header("Location: nuevo.php?error=error_insercion");
    exit;
}

// Cerrar sentencia y conexión
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>