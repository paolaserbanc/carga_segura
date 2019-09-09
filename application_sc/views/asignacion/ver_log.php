<?php
if($log['finalizo_exito'] == 'S') {
    echo 'La carga se realizó con éxito, la carga empezó '.$log['fecha_hora_inicio'].' y culminó '.$log['fecha_hora_fin'];
} else {
    echo 'La carga no ha sido procesada, se encuentra con observacion <b>"'.$log['observacion'].'"</b>';
}
?>