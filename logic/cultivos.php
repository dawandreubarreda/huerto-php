<?php
/**
 * Funciones de lógica de negocio relacionadas con cultivos.
 * ¡Nada de $_POST, mysqli, echo ni HTML aquí!
 */

/**
 * Verifica si un tipo de cultivo es válido.
 */
function esTipoValido(string $tipo): bool {
    $tipos_validos = ['Hortaliza', 'Fruto', 'Aromática', 'Legumbre', 'Tubérculo'];
    return in_array($tipo, $tipos_validos);
}

/**
 * Verifica si un nombre de cultivo es válido.
 */
function esNombreValido(string $nombre): bool {
    return !empty($nombre) && strlen($nombre) >= 3;
}

/**
 * Calcula el ciclo de cultivo según los días.
 */
function calcularCicloCultivo(int $dias): string {
    if ($dias < 60) {
        return "Corto";
    } elseif ($dias >= 60 && $dias <= 180) {
        return "Medio";
    } else {
        return "Tardío";
    }
}