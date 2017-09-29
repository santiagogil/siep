
<div class="TituloSec">Matriculas</div>
<div id="ContenidoSec">
    <div class="table-responsive">
      <table id="tablaPieBuscador" class="table table-bordered table-hover table-striped table-condensed">
      <thead>
        <tr>
          <th><?php echo $this->Paginator->sort('Centro.sigla', 'Centro');?>  </th>
          <th><?php echo $this->Paginator->sort('anio','Año');?></th>
          <th><?php echo $this->Paginator->sort('division', 'Division');?></th>
          <th><?php echo $this->Paginator->sort('turno', 'Turno');?></th>
          <th><?php echo $this->Paginator->sort('plazas', 'Plazas');?></th>
          <th><?php echo $this->Paginator->sort('matricula', 'Matriculas');?></th>
          <th><?php echo $this->Paginator->sort('vacantes', 'Vacantes');?></th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php $count=0; ?>
        <?php foreach($matriculas as $matricula): ?>
            <td>
              <?php echo $matricula['Centro']['sigla']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['anio']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['division']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['turno']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['plazas']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['matricula']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['vacantes']; ?>
            </td>
            <td >
              <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Cursos', 'action'=> 'view', $matricula['Curso']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th>
            <!-- Autocomplete -->
              <input id="AutocompleteForm" class="form-control" placeholder="Buscar institucion por nombre" type="text">

            <script>
              $( function() {
                $( "#AutocompleteForm" ).autocomplete({
                  source: "<?php echo $this->Html->url(array('controller'=>'Centros','action'=>'autocompleteCentro'));?>",
                  minLength: 2,
                  select: function( event, ui ) {
                    $("#AutocompleteForm").val( ui.item.Centro.sigla );

                    window.location.href = "<?php echo $this->Html->url(array('controller'=>'matriculas'));?>/index/centro_id:"+ui.item.Centro.id;
                    return false;
                  }
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                  return $( "<li>" )
                      .append( "<div>" +item.Centro.sigla + "</div>" )
                      .appendTo( ul );
                };
              });
            </script>
            <!-- End Autocomplete -->

          </th>
        </tr>
      </tfoot>
    </table>

      <script>
        $(function(){

          $('#tablaPieBuscador_DESACTIVADO tfoot th').each( function (i) {
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
        });
      </script>
    </div>

  <div class="unit text-center">
    <?php echo $this->element('pagination'); ?>
  </div>
</div>
