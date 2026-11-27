<?php
// PRIMERA APROXIMACIÓN AL MODELO VISTA CONTROLADOR.
// Funciones auxiliares Ej- usuarioOK
include_once 'app/funciones.php';

// Salida hacia buffer
ob_start();
$msg = "";

// Según la orden
if (!isset($_REQUEST['orden'])) {
    include_once 'app/plantillas/entrada.php';
}
else {
    switch ($_REQUEST['orden']) {

        case "Entrar":
            // Chequear usuario
            if (isset($_REQUEST['nombre']) && isset($_REQUEST['contraseña']) &&
                usuarioOK($_REQUEST['nombre'], $_REQUEST['contraseña'])) {
                echo " Bienvenido <b>" . limpiar($_REQUEST['nombre']) . "</b><br>";
                include_once 'app/plantillas/comentario.html';
            }
            else {
                $msg = " Usuario no válido ";
                include_once 'app/plantillas/entrada.php';
            }
            break;

        case "Nueva opinión": // Formulario vacío
            echo " Nueva opinión <br>";
            include_once 'app/plantillas/comentario.html';
            break;

        case "Detalles": // Mensaje y detalles
            $tema       = leerCampo('tema', 100);
            $comentario = leerCampo('comentario', MAX_COMENTARIO);
            if ($tema === '' || $comentario === '') {
                $msg = "Debe escribir un tema y un comentario.";
                include_once 'app/plantillas/comentariorelleno.php';
            } else {
                echo "Detalles de su opinión";
                include_once 'app/plantillas/comentariorelleno.php';
                include_once 'app/plantillas/detalles.php';
            }
            break;

        case "Terminar": // Formulario inicial
        default:
            include_once 'app/plantillas/entrada.php';
    }
}

$contenido_php = ob_get_clean();

include_once "app/plantillas/principal.php";
