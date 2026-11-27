<?php
require_once "app/dat/Producto.php";
require_once 'app/dat/AccesoDatos.php';

function accionBorrar ($codigo){    
    $db = AccesoDatos::getModelo();
    if ($db->borrarProducto((int)$codigo)) {
        mensaje("Producto $codigo eliminado.");
    } else {
        mensaje("No se ha podido eliminar el producto $codigo.", true);
    }
}

function accionTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
    header("Refresh:0 url='./index.php'");
}
 
function accionAlta(){
    $prod = new Producto();
    $prod->codigo    = "";
    $prod->nombre    = "";
    $prod->stock     = "";
    $prod->stock_min = "";
    $prod->precio    = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
}

function accionDetalles($codigo){
    $db = AccesoDatos::getModelo();
    $prod = $db->getProducto((int)$codigo);
    if (!$prod) { mensaje("El producto $codigo no existe.", true); return; }
    $orden = "Detalles";
    include_once "layout/formulario.php";
}

function accionModificar($codigo){
    $db = AccesoDatos::getModelo();
    $prod = $db->getProducto((int)$codigo);
    if (!$prod) { mensaje("El producto $codigo no existe.", true); return; }
    $orden="Modificar";
    include_once "layout/formulario.php";
}

// Crea un Producto con los datos del formulario
function productoDesdePost(): Producto {
    $prod = new Producto();
    $prod->codigo    = $_POST['codigo'] ?? '';
    $prod->nombre    = $_POST['nombre'] ?? '';
    $prod->stock     = $_POST['stock'] ?? '';
    $prod->stock_min = $_POST['stock_min'] ?? '';
    $prod->precio    = $_POST['precio'] ?? '';
    return $prod;
}

function accionPostAlta(){
    $prod = productoDesdePost();
    if ($error = validarProducto($prod)) { mensaje($error, true); return; }
    $db = AccesoDatos::getModelo();
    if ($db->addProducto($prod)) {
        mensaje("Producto $prod->codigo dado de alta.");
    } else {
        mensaje("No se ha podido dar de alta: el código $prod->codigo ya existe.", true);
    }
}

function accionPostModificar(){
    $prod = productoDesdePost();
    if ($error = validarProducto($prod)) { mensaje($error, true); return; }
    $db = AccesoDatos::getModelo();
    if ($db->modProducto($prod)) {
        mensaje("Producto $prod->codigo modificado.");
    } else {
        mensaje("No se ha modificado ningún dato del producto $prod->codigo.");
    }
}
