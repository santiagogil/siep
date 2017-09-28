<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
  <div class="col-xs-6 col-sm-3">
      <?php
          echo $this->Form->input('ciclo_id', array('label'=>'Ciclo lectivo*', 'empty' => 'Ingrese un ciclo lectivo...', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?>
      <?php echo $this->Form->input('usuario_id', array('type' => 'hidden')); ?>
  </div>
  <div class="col-xs-6 col-sm-3">
      <?php
          $estados_inscripcion = array('CONFIRMADA'=>'CONFIRMADA','NO CONFIRMADA'=>'NO CONFIRMADA','BAJA'=>'BAJA','EGRESO'=>'EGRESO');
           echo $this->Form->input('estado_inscripcion', array('label'=>'Estado de la inscripción*', 'empty' => 'Ingrese un estado de la inscripción...', 'options'=>$estados_inscripcion, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?>
      <?php echo $this->Form->input('usuario_id', array('type' => 'hidden')); ?>
  </div>
</div><hr />
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
        <?php
            $tipos_inscripcion = array('Común'=>'Común','Hermano de alumno regular'=>'Hermano de alumno regular','Pase'=>'Pase','Integración'=>'Integración','Situación social'=>'Situación social','Hijo de personal de la institución'=>'Hijo de personal de la institución');
            echo $this->Form->input('tipo_inscripcion', array('label'=>'Tipo de inscripción*', 'empty' => 'Ingrese un tipo de inscripción...', 'options'=>$tipos_inscripcion, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?><br>
        <!-- Autocomplete para nombre de Personas -->
        <div>
            <strong><h5>Nombre y apellidos del alumno*</h5></strong>
            <input id="PersonaNombreCompleto" class="form-control" label= "Nombre y apellidos del alumno*" data-toggle="tooltip" data-placemente="bottom" placeholder="Ingrese el nombre completo">
            <input id="PersonaId" name="data[Persona][persona_id]" type="text" style="display:none;">
            <div class="alert alert-danger" role="alert" id="AutocompleteError" style="display:none;">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    La persona no fue localizada.
                    <?php echo $this->Html->link("Crear persona",array('controller'=>'personas','action'=>'add'));?>
            </div>
        </div><br>
        <script>
                $( function() {
                    $( "#PersonaNombreCompleto" ).autocomplete({
                        source: "<?php echo $this->Html->url(array('controller'=>'Alumnos','action'=>'autocompleteNombrePersona'));?>",
                        minLength: 2,
                        // Evento: se ejecuta al seleccionar el resultado
                        select: function( event, ui ) {
                            // Elimina ID de persona previo a establecer la seleccion
                            $("#PersonaId").val("");
                            if(ui.item != undefined) {
                                var nombre_completo = ui.item.Persona.nombre_completo_persona;
                                $("#PersonaNombreCompleto").val(nombre_completo);
                                $("#PersonaId").val(ui.item.Persona.id);
                                return false;
                            }
                        },
                        response: function(event, ui) {
                            // Elimina ID de persona al obtener respuesta
                            $("#PersonaId").val("");
                            if (ui.content.length === 0) {
                                $("#AutocompleteError").show();
                                $("#PersonaId").val("");
                            } else {
                                $("#AutocompleteError").hide();
                            }
                        }
                    }).autocomplete("instance")._renderItem = function( ul, item ) {
                        // Renderiza el resultado de la respuesta
                        var nombre_completo = item.Persona.nombre_completo_persona + " - "+item.Persona.documento_nro;
                        return $( "<li>" )
                            .append( "<div>" +nombre_completo+ "</div>" )
                            .appendTo( ul );
                    };
                });
        </script>
        <!-- End Autocomplete -->
        <?php 
            echo $this->Form->input('Curso', array('multiple' => true, 'label'=>'Sección*', 'empty' => 'Ingrese una sección...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
            /*
            if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Colegio Secundario') || ($current_user['puesto'] == 'Supervisión Secundaria') || ($current_user['puesto'] == 'Dirección Instituto Superior') || ($current_user['puesto'] == 'Supervisión Secundaria')) {
              echo $this->Form->input('Inscripcion.Materia', array('multiple' => true, 'label'=>'Unidades Curriculares*', 'empty' => 'Ingrese una unidad...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
            }
            */
            echo $this->Form->input('legajo_nro', array('type' => 'hidden'));
      ?><br>
    </div>
      <?php echo '</div><div class="col-md-4 col-sm-6 col-xs-12">'; ?>
    <div class="unit"><strong><h3>Datos del Alta</h3></strong><hr />
      <!--<?php
            echo $this->Form->input('fecha_alta', array('label' => 'Fecha de Alta*', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'Placeholder' => 'Ingrese una fecha...'));
      ?><br>-->
      <!--<?php
            $tipos_alta = array('Regular' => 'Regular', 'Equivalencia'=>'Equivalencia');
            echo $this->Form->input('tipo_alta', array('label' => 'Alta tipo*', 'default' => 'Ingrese un tipo...', 'options' => $tipos_alta, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?><br>-->
<span class="input-group-addon">
  <h4> Documentación presentada:</h4>
</span>
<div class="row">
  <br>
    <div class="input-group">
      <span class="input-group-addon">
        <?php echo $this->Form->input('fotocopia_dni', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Fotocopia DNI</label>'));?>
      </span>
    </div>
      <div class="input-group">
        <span class="input-group-addon">
         <?php echo $this->Form->input('certificado_septimo', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Certificado Primario Completo</label>'));?>
        </span>
      </div>
    <div class="input-group">
      <span class="input-group-addon">
        <?php echo $this->Form->input('analitico', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Certificado Analítico</label>'));?>
      </span>
    </div>
</div><br>
<!--<?php
    if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Colegio Secundario') || ($current_user['puesto'] == 'Supervisión Secundaria') || ($current_user['puesto'] == 'Dirección Instituto Superior') || ($current_user['puesto'] == 'Supervisión Secundaria')) {
          echo $this->Form->input('estado', array('type' => 'hidden'));
          $condiciones_aprobacion = array('Promocion directa' => 'Promocion directa', 'Examen regular' => 'Examen regular', 'Examen libre' => 'Examen libre', 'Examen de reválida' => 'Examen de reválida', 'Equivalencia' => 'Equivalencia', 'Saberes adquiridos' => 'Saberes adquiridos', 'Examen regular y Equivalencia' => 'Examen regular y equivalencia');
          echo $this->Form->input('condicion_aprobacion', array('label' => 'Condición de aprobación*', 'options' => $condiciones_aprobacion, 'empty' => 'Ingrese una opción...', 'between' => '<br>', 'class' => 'form-control'));?><br>
          <div class="row">
            <div class="input-group">
              <span class="input-group-addon">
                  <?php  echo $this->Form->input('recursante', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Recursante</label>'));?>
              </span>
            </div>
          </div>
          <?php  $tipos_cursa = array('Cursa algun espacio curricular'=>'Cursa algun espacio curricular', 'Sólo se inscribe a rendir final' =>'Sólo se inscribe a rendir final', 'Cursa espacio curricular y rinde final'=>'Cursa espacio curricular y rinde final');
            echo $this->Form->input('cursa', array('label' => 'Cursa*', 'empty' => 'Ingrese una opción...', 'options' => $tipos_cursa, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
            $tipos_fines = array('No' => 'No', 'Sí línea deudores de materias.' => 'Sí línea deudores de materias.', 'Sí línea trayectos educativos.' => 'Sí línea   trayectos educativos.');
            echo $this->Form->input('fines', array('label' => 'Fines*', 'empty' => 'Ingrese una opción...', 'options' => $tipos_fines, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
          }
      ?>-->
    </div>
  </div>
</div>

  <div class="row">
    <div class="unit">
      <div class="col-md-12 col-sm-6 col-xs-12">
        <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
      </div>
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
</div>
