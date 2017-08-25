<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>

<div class="row">
	<div class="col-xs-6 col-sm-3">
	    <?php echo $this->Form->input('created', array('label' => 'Creado*', 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar')); ?>
  </div>
  <!--<div class="col-xs-6 col-sm-3">
	    <?php echo $this->Form->input('pendiente', array('between' => '<br>', 'class' => 'form-control')); ?>
  </div>-->
</div><hr />
<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
  	  <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />

          <!-- Autocomplete para nombre de Personas -->
          <div>
              <label for="AlumnoPersonaId">Nombre completo*: </label>
              <br>
              <input id="AlumnoPersonaId" class="form-control" data-toggle="tooltip" data-placemente="bottom" title="Ingrese el nombre completo">
          </div>

          <script>
              $( function() {
                  $( "#AlumnoPersonaId" ).autocomplete({
                      source: "<?php echo $this->Html->url(array('action'=>'autocompleteNombreAlumno'));?>",
                      minLength: 2,
                      select: function( event, ui ) {
                          console.log(ui.item);
                          $("#AlumnoPersonaId").val( ui.item.Persona.nombre_completo_persona );
                          return false;
                      }
                  }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                      return $( "<li>" )
                          .append( "<div>" +item.Persona.nombre_completo_persona+ "</div>" )
                          .appendTo( ul );
                  };
              });
          </script>
          <!-- End Autocomplete -->

      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />
      <?php
            echo $this->Form->input('legajo_fisico_nro', array('label'=>'Número de Legajo Físico*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Indique el número sin puntos, ni guiones, ni espacios', 'placeholder' => 'Ingrese un nº de legajo físico...'));
        ?>
      </div>
  </div>
  <div class="col-md-12 col-sm-6 col-xs-12">
    <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
  </div>
</div>

    <script type="text/javascript">
        $('#datetimepicker1').datetimepicker({
        useCurrent: true, //this is important as the functions sets the default date value to the current value
        format: 'YYYY-MM-DD hh:mm',
        }).on('dp.change', function (e) {
              var specifiedDate = new Date(e.date);
              if (specifiedDate.getMinutes() == 0)
              {
                  specifiedDate.setMinutes(1);
                  $(this).data('DateTimePicker').date(specifiedDate);
              }
           });
    </script>

