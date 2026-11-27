<?php

// MUESTRA TODOS LOS PRODUCTOS
function mostrarDatos (){
    
    $titulos = [ "Código","Nombre","Stock","Stock mínimo","Precio"];
    $msg = "<table>\n";
     // Identificador de la tabla
    $msg .= "<tr>";
    for ($j=0; $j < count($titulos); $j++){
        $msg .= "<th>$titulos[$j]</th>";
    }  
    $msg .= "</tr>";
    $auto = $_SERVER['PHP_SELF'];
    $db = AccesoDatos::getModelo();
    $tprod = $db->getProductos();
    foreach ($tprod as $prod) {
        $nombre = htmlspecialchars($prod->nombre);
        // Marco en rojo los productos con stock por debajo del mínimo
        $clase = ($prod->stock < $prod->stock_min) ? ' class="bajo-stock"' : '';
        $msg .= "<tr$clase>";
        $msg .= "<td>$prod->codigo</td>";
        $msg .= "<td>$nombre</td>";
        $msg .= "<td>$prod->stock</td>";
        $msg .= "<td>$prod->stock_min</td>";
        $msg .= "<td>".number_format((float)$prod->precio, 2, ',', '.')." €</td>";
        $msg .="<td><a href=\"#\" onclick=\"confirmarBorrar('".addslashes($nombre)."','$prod->codigo');\" >🗑️</a></td>\n";
        $msg .="<td><a href=\"".$auto."?orden=Modificar&id=$prod->codigo\">✏️</a></td>\n";
        $msg .="<td><a href=\"".$auto."?orden=Detalles&id=$prod->codigo\" >👁️</a></td>\n";
        $msg .="</tr>\n";
    }
    $msg .= "</table>";
    $msg .= "<p class=\"leyenda\">En rojo: productos con stock por debajo del mínimo.</p>";
   
    return $msg;    
}

// Guarda un mensaje para mostrarlo encima de la tabla
function mensaje(string $texto, bool $error = false){
    global $contenido;
    $clase = $error ? "msg error" : "msg";
    $contenido .= "<p class=\"$clase\">".htmlspecialchars($texto)."</p>";
}

// Comprueba los datos de un producto. Devuelve el error o "" si es correcto
function validarProducto(Producto $prod): string {
    if (filter_var($prod->codigo, FILTER_VALIDATE_INT, ["options"=>["min_range"=>1,"max_range"=>9999]]) === false)
        return "El código debe ser un número entre 1 y 9999.";
    if ($prod->nombre === "" || mb_strlen($prod->nombre) > 30)
        return "El nombre es obligatorio (máximo 30 caracteres).";
    if (filter_var($prod->stock, FILTER_VALIDATE_INT, ["options"=>["min_range"=>0]]) === false)
        return "El stock debe ser un número entero mayor o igual que 0.";
    if (filter_var($prod->stock_min, FILTER_VALIDATE_INT, ["options"=>["min_range"=>0]]) === false)
        return "El stock mínimo debe ser un número entero mayor o igual que 0.";
    if (filter_var($prod->precio, FILTER_VALIDATE_FLOAT) === false || $prod->precio < 0)
        return "El precio debe ser un número mayor o igual que 0.";
    return "";
}

/*
 *  Funciones para limpiar la entrada de posibles inyecciones
 */
function limpiarEntrada(string $entrada):string{
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = strip_tags($salida); // Elimina marcas
    return $salida;
}
// Función para limpiar todos elementos de un array
function limpiarArrayEntrada(array &$entrada){
    foreach ($entrada as $key => $value ) {
        $entrada[$key] = limpiarEntrada($value);
    }
}
