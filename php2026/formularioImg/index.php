<?php
/*
 * index.php
 *  - GET  -> muestra el formulario (captura.html)
 *  - POST -> procesa los datos y la imagen, y muestra la ficha del jugador
 */

// ---------- GET: mostrar el formulario ----------
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    readfile(__DIR__ . "/captura.html");     // lo envía tal cual, sin ejecutarlo
    exit;
}

// ---------- POST: procesar ----------
const TAM_MAXIMO = 10240;                        // 10 KB
const DIR_SUBIDAS = __DIR__ . "/uploads/";
const ARMAS_VALIDAS = ["Maza", "Antorcha", "Martillo", "Látigo"];

// Evita la inyección de código (XSS): convierte < > & " ' en entidades HTML
function limpiar(string $texto): string {
    return htmlspecialchars(trim($texto), ENT_QUOTES, "UTF-8");
}

$nombre = limpiar($_POST["nombre"] ?? "");
$alias  = limpiar($_POST["alias"] ?? "");
$edad   = filter_input(INPUT_POST, "edad", FILTER_VALIDATE_INT,
                       ["options" => ["min_range" => 1, "max_range" => 120]]);
$edad   = $edad ? $edad : "No indicada";

// Armas: llega un array; solo se aceptan las de la lista (lista blanca)
$armas = $_POST["armas"] ?? [];
if (!is_array($armas)) $armas = [];
$armas = array_intersect($armas, ARMAS_VALIDAS);
$textoArmas = $armas ? implode(", ", $armas) : "Ninguna";

$magia = (($_POST["magia"] ?? "no") === "si") ? "Sí" : "No";

// ---------- Imagen (validación en el SERVIDOR) ----------
$rutaImagen   = "calavera.png";   // por defecto, la calavera
$tituloImagen = "No se subió ninguna imagen.";
$errorImagen  = "";                   // mensaje de error (vacío si no hay)

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $fich = $_FILES["imagen"];

    if ($fich["error"] === UPLOAD_ERR_INI_SIZE || $fich["error"] === UPLOAD_ERR_FORM_SIZE
        || $fich["size"] > TAM_MAXIMO) {
        $errorImagen = "Error al subir la imagen: supera los 10 KB.";
    } elseif ($fich["error"] !== UPLOAD_ERR_OK) {
        $errorImagen = "Error al subir la imagen.";
    } else {
        // Tipo REAL leyendo el contenido (el "type" que manda el navegador se puede falsificar)
        $tipoReal  = mime_content_type($fich["tmp_name"]);
        $extension = strtolower(pathinfo($fich["name"], PATHINFO_EXTENSION));
        if ($tipoReal !== "image/png" || $extension !== "png") {
            $errorImagen = "Error al subir la imagen: solo se permiten ficheros PNG.";
        } elseif (!is_dir(DIR_SUBIDAS) || !is_writable(DIR_SUBIDAS)) {
            $errorImagen = "Error al subir la imagen: la carpeta uploads no existe o no tiene permisos.";
        } else {
            // Nombre único para no sobrescribir otras imágenes
            $nombreFinal = uniqid("jugador_") . ".png";
            if (move_uploaded_file($fich["tmp_name"], DIR_SUBIDAS . $nombreFinal)) {
                $rutaImagen   = "uploads/" . $nombreFinal;
                $tituloImagen = "Imagen subida:";
            } else {
                $errorImagen = "Error al subir la imagen.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Jugador</title>
    <style>
body { font-family: Arial, sans-serif; margin: 0; padding: 30px 10px; }

.fondo-datos { background: #f0eef7; }
.ficha { background: #ffff44; max-width: 450px; margin: 0 auto; padding: 18px 20px; border-radius: 10px; }
.ficha h2 { text-align: center; }
.columnas { display: flex; gap: 20px; align-items: center; }
.datos, .imagen { flex: 1; }
.imagen img { width: 180px; height: auto; border: 1px solid #00a; background: #fff; }
.error { color: #000; }
.volver { text-align: center; margin-top: 16px; }
    </style>
</head>
<body class="fondo-datos">
    <div class="ficha">
        <h2>Datos del Jugador</h2>
        <div class="columnas">
            <div class="datos">
                <p><b>Nombre:</b> <?= $nombre ?></p>
                <p><b>Alias:</b> <?= $alias ?></p>
                <p><b>Edad:</b> <?= $edad ?></p>
                <p><b>Armas seleccionadas:</b> <?= htmlspecialchars($textoArmas) ?></p>
                <p><b>¿Practica artes mágicas?:</b> <?= $magia ?></p>
            </div>
            <div class="imagen">
                <p><b><?= $tituloImagen ?></b></p>
                <img src="<?= $rutaImagen ?>" alt="Imagen del jugador">
                <?php if ($errorImagen !== ""): ?>
                    <p class="error"><?= htmlspecialchars($errorImagen) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <p class="volver"><a href="index.php">Volver al formulario</a></p>
    </div>
</body>
</html>
