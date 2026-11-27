<?php $info = analizarTexto($comentario); ?>
<div>
<b> Detalles:</b><br>
<table>
<tr><td>Tema:                    </td><td><?= limpiar($tema) ?></td></tr>
<tr><td>Longitud:                </td><td><?= $info['longitud'] ?></td></tr>
<tr><td>Caracteres sin espacios: </td><td><?= $info['sinEspacios'] ?></td></tr>
<tr><td>Nº de palabras:          </td><td><?= $info['palabras'] ?></td></tr>
<tr><td>Letra + repetida:        </td><td><?= limpiar($info['letra'][0]) ?> (<?= $info['letra'][1] ?> veces)</td></tr>
<tr><td>Palabra + repetida:      </td><td><?= limpiar($info['palabra'][0]) ?> (<?= $info['palabra'][1] ?> veces)</td></tr>
<tr><td>Palabra más larga:       </td><td><?= limpiar($info['larga']) ?></td></tr>
<tr><td>Longitud media palabra:  </td><td><?= $info['media'] ?></td></tr>
<tr><td>Vocales / consonantes:   </td><td><?= $info['vocales'] ?> / <?= $info['consonantes'] ?></td></tr>
<tr><td>Nº de frases:            </td><td><?= $info['frases'] ?></td></tr>
</table>
</div>
