<!-- start main -->
<?php echo $this->Html->script(array('/js/datatables/jquery.dataTables.min')); ?>
<?php echo $this->Html->css(array('/js/datatables/jquery.dataTables.min')); ?>

<div class="TituloSec">Matriculas</div>
<div id="ContenidoSec">
  <div id="main">
    <table id="matriculasDatatable" class="display" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Centro</th>
          <th>Año</th>
          <th>Division</th>
          <th>Turno</th>
          <th>Plazas</th>
          <th>Matricula</th>
          <th>Vacantes</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <script>
      $(function(){
        $('#matriculasDatatable').DataTable({
          "language": {
               "url": "/js/datatables/Spanish.json"
           },
          "ajax": {
            "url": "<?php echo $this->Html->url('/matriculas/requestDatatable'); ?>"
          },
          "columns" : [
            { "data" : "Centro.sigla" },
            { "data" : "Curso.anio" },
            { "data" : "Curso.division" },
            { "data" : "Curso.turno" },
            { "data" : "Curso.plazas" },
            { "data" : "Curso.matricula" },
            { "data" : "Curso.vacantes" },
          ]
        });
      });
    </script>
  </div>
</div>
<!-- end main -->
