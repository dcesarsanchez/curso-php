<?php
// Longitud máxima permitida para el comentario
const MAX_COMENTARIO = 300;

// Invierte una cadena respetando los caracteres multibyte (ñ, tildes...)
function invertir(string $texto): string {
    return implode('', array_reverse(mb_str_split($texto)));
}

// Usuario válido: 8 o más caracteres y la contraseña es el nombre al revés
function usuarioOk($usuario, $contraseña): bool {
    $usuario = trim($usuario);
    return mb_strlen($usuario) >= 8 && $contraseña === invertir($usuario);
}

// Evita la inyección de código: convierte < > & " ' en entidades HTML
function limpiar(?string $texto): string {
    return htmlspecialchars(trim($texto ?? ''), ENT_QUOTES, 'UTF-8');
}

// Devuelve el texto recibido, sin espacios sobrantes y recortado a $max caracteres
function leerCampo(string $campo, int $max = 0): string {
    $valor = trim($_REQUEST[$campo] ?? '');
    if ($max > 0) $valor = mb_substr($valor, 0, $max);
    return $valor;
}

// Lista de palabras del texto (letras y números), en minúsculas
function palabras(string $texto): array {
    return preg_split('/[^\p{L}\p{N}]+/u', mb_strtolower($texto), -1, PREG_SPLIT_NO_EMPTY);
}

// Elemento que más se repite de un array (y cuántas veces)
function masRepetido(array $elementos): array {
    if (!$elementos) return ['-', 0];
    $cuenta = array_count_values($elementos);
    arsort($cuenta);                       // de mayor a menor frecuencia
    return [array_key_first($cuenta), reset($cuenta)];
}

// Informe completo sobre el comentario
function analizarTexto(string $texto): array {
    $lista = palabras($texto);
    // Solo letras para la "letra más repetida" (sin espacios ni signos)
    preg_match_all('/\p{L}/u', mb_strtolower($texto), $m);
    $letras = $m[0];

    $vocales = preg_match_all('/[aeiouáéíóúü]/iu', $texto);
    $frases  = count(preg_split('/[.!?]+/u', $texto, -1, PREG_SPLIT_NO_EMPTY));

    $larga = '-';
    foreach ($lista as $p) {
        if ($larga === '-' || mb_strlen($p) > mb_strlen($larga)) $larga = $p;
    }

    return [
        'longitud'     => mb_strlen($texto),
        'sinEspacios'  => mb_strlen(preg_replace('/\s+/u', '', $texto)),
        'palabras'     => count($lista),
        'letra'        => masRepetido($letras),
        'palabra'      => masRepetido($lista),
        'vocales'      => $vocales,
        'consonantes'  => count($letras) - $vocales,
        'frases'       => $texto === '' ? 0 : $frases,
        'larga'        => $larga,
        'media'        => $lista ? round(array_sum(array_map('mb_strlen', $lista)) / count($lista), 2) : 0,
    ];
}
