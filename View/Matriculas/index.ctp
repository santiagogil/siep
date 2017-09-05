<!-- start main -->
<?php echo $this->Html->script(array('/js/datatables/jquery.dataTables.min')); ?>
<?php echo $this->Html->css(array('/js/datatables/jquery.dataTables.min')); ?>

<div class="TituloSec">Matriculas</div>
<div id="ContenidoSec">
  <div id="main">

    <table id="matriculasDatatable" class="display" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Año</th>
          <th>Division</th>
          <th>Turno</th>
          <th>Matricula</th>
          <th>Curso</th>
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
            { "data" : "Curso.id" },
            { "data" : "Curso.anio" },
            { "data" : "Curso.division" },
            { "data" : "Curso.turno" },
            { "data" : "Curso.matricula" },
            { "data" : "Curso.nombre_completo_curso" }
          ]
        });
      });
    </script>

  </div>
</div>
<!-- end main -->
