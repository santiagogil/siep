<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped table-condensed">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Seccion</th>
                <th>Centro</th>
                <th>Ciclo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cursosInscripcions as $cursosInscripcion) : ?>
            <tr>
                <td><?php echo $cursosInscripcion['Persona']['nombres']." ".$cursosInscripcion['Persona']['apellidos']; ?> </td>
                <td><?php echo $cursosInscripcion['Curso']['anio']." ".$cursosInscripcion['Curso']['division']; ?> </td>
                <td><?php echo $cursosInscripcion['Centro']['nombre']; ?> </td>
                <td><?php echo $cursosInscripcion['Ciclo']['nombre']; ?> </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>