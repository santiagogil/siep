<!-- start main -->
<?php echo $this->Html->script(array('/js/datatables/jquery.dataTables.min')); ?>
<?php echo $this->Html->css(array('/js/datatables/jquery.dataTables.min')); ?>
<?php echo $this->Html->css(array('/js/datatables/dataTables.bootstrap.min')); ?>

<div class="TituloSec">Matriculas</div>
<div id="ContenidoSec">
  <div id="main">
    <table id="matriculasDatatableAjax" class="table table-striped table-bordered" width="100%" cellspacing="0">
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
      <tfoot>
      <tr>
        <th>Centro</th>
        <th>Año</th>
        <th>Division</th>
        <th>Turno</th>
        <th>Plazas</th>
        <th>Matricula</th>
        <th>Vacantes</th>
      </tr>
      </tfoot>
    </table>

    <script>

      // definir unidad
      var ALERTA_POCAS_VACANTES = 23;

      $(function(){

        $('#matriculasDatatableAjax tfoot th').each( function (i) {
          var title = $(this).text();
          var inputFind = $(this).html( '<input type="text" data-column="'+ i +'" class="form-control" placeholder="Buscar '+title+'" />' );

          inputFind.find('input').on( 'keypress', function (e) {
            if(e.which == 13) {
              var i = $(this).attr('data-column');
              var find =$(this).val();

              matriculasTable.columns(i).search(find).draw();
            }
          });
        });

        var matriculasTable = $('#matriculasDatatableAjax').DataTable({
          createdRow: function( row, data, dataIndex){
            if( data.Curso.vacantes <=  0){
              $(row).addClass('danger');
            }

            if( data.Curso.vacantes <=  ALERTA_POCAS_VACANTES){
              $(row).addClass('warning');
            }
          },
          "processing": true,
          "serverSide": true,
          "language": {
               "url": "/js/datatables/Spanish.json"
           },
          "ajax": {
            "url": "<?php echo $this->Html->url('/matriculas/requestDatatable'); ?>",
            "method" : "POST"
          },
          "columns" : [
            { "data" : "Centro.sigla" },
            { "data" : "Curso.anio" },
            { "data" : "Curso.division" },
            { "data" : "Curso.turno" },
            { "data" : "Curso.plazas" },
            { "data" : "Curso.matricula" },
            { "data" : "Curso.vacantes" }
          ]
        });
      });
    </script>

  </div>
</div>
<!-- end main -->
