<div>
<form name='entrada' method="POST">
<table>
<tr>
<td>Nombre:</td><td> <input type="text" name="nombre"
    value="<?= limpiar($_REQUEST['nombre'] ?? '') ?>"></td></tr>
<tr>
<td>Contraseña: </td><td><input type="password" name="contraseña" value=""></td>
</tr>
</table>
<input type="submit" name="orden" value="Entrar">
</form>
<?php if ($msg !== ''): ?>
<p class="error"><?= $msg ?></p>
<?php endif; ?>
</div>
