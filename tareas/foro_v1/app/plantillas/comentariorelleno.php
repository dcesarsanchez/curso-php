<div>
<form name='mensaje' method="POST">
Tema<br>
 <input type="text" name="tema" size=30 maxlength="100"
   value="<?= limpiar($tema) ?>"><br>
Comentario: <br>
<textarea name="comentario" rows="4" cols="50" maxlength="300"><?= limpiar($comentario) ?></textarea>
<br><br>
<input type="submit" name="orden" value="Detalles">
<input type="submit" name="orden" value="Nueva opinión">
<input type="submit" name="orden" value="Terminar">
</form>
<?php if ($msg !== ''): ?>
<p class="error"><?= $msg ?></p>
<?php endif; ?>
</div>
