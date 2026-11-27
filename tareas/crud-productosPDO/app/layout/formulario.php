<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD DE PRODUCTOS</title>
    <link href="web/default.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="container">
    <div id="header">
       <h1>GESTIÓN DE PRODUCTOS + BD (PDO)</h1>
    </div>

    <div id="content">
        <form method="POST">
            <table>
                <tr>
                    <td><label for="codigo">Código</label></td>
                    <td>
                        <input type="number" id="codigo" name="codigo" min="1" max="9999" required
                               value="<?= htmlspecialchars($prod->codigo) ?>" 
                               <?= ($orden == "Detalles" || $orden == "Modificar") ? "readonly" : "autofocus" ?>>
                    </td>
                </tr>
                <tr>
                    <td><label for="nombre">Nombre</label></td>
                    <td>
                        <input type="text" id="nombre" name="nombre" maxlength="30" required
                               value="<?= htmlspecialchars($prod->nombre) ?>" 
                               <?= ($orden == "Detalles") ? "readonly" : "" ?>>
                    </td>
                </tr>
                <tr>
                    <td><label for="stock">Stock</label></td>
                    <td>
                        <input type="number" id="stock" name="stock" min="0" required
                               value="<?= htmlspecialchars($prod->stock) ?>" 
                               <?= ($orden == "Detalles") ? "readonly" : "" ?>>
                    </td>
                </tr>
                <tr>
                    <td><label for="stock_min">Stock mínimo</label></td>
                    <td>
                        <input type="number" id="stock_min" name="stock_min" min="0" required
                               value="<?= htmlspecialchars($prod->stock_min) ?>" 
                               <?= ($orden == "Detalles") ? "readonly" : "" ?>>
                    </td>
                </tr>
                <tr>
                    <td><label for="precio">Precio (€)</label></td>
                    <td>
                        <input type="number" id="precio" name="precio" min="0" step="0.01" required
                               value="<?= htmlspecialchars($prod->precio) ?>" 
                               <?= ($orden == "Detalles") ? "readonly" : "" ?>>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 20px;">
                <?php if ($orden != "Detalles"): ?>
                <input type="submit" name="orden" value="<?= $orden ?>">
                <?php endif; ?>
                <input type="submit" name="orden" value="Volver" formnovalidate>
            </div>
        </form> 
    </div>
</div>

</body>
</html>
<?php exit(); ?>
