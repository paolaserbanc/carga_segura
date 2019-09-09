<table class="table table-hover">
<thead class="text-warning">
    <tr>
        <th>Data</th>
        <td>Cantidad de Casos</td>
        <td>Monto Total</td>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Archivo asignación</td>
        <td><?php echo number_format($cuadratura_archivos['cantidad'],0,',','.') ?> </td>
        <td><?php echo '$'.number_format($cuadratura_archivos['monto'],0,',','.') ?> </td>
    </tr>
    <tr>
        <td>Cargados en Ecollection</td>
        <td><?php echo number_format($cuadratura_ecoll['cantidad'],0,',','.') ?> </td>
        <td><?php echo '$'.number_format($cuadratura_ecoll['monto'],0,',','.') ?> </td>
    </tr>
</tbody>
</table>