<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<?php echo $this->Html->css(array('/js/select2/select2.min')); ?>
<?php echo $this->Html->script(array('/js/select2/select2.min')); ?>
<?php echo $this->Html->script(array('/js/select2/es')); ?>
<fieldset>
    <?php
        echo $this->Form->input('usuario_id', array('type' => 'hidden'));
        echo $this->Form->input('legajo_nro', array('type' => 'hidden'));
    ?>
<div class="row">
    <div class="col-xs-6 col-sm-3">
        <?php echo $this->Form->input('created', array('label' => 'Creado*', 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar'));
        ?>
        <?php
            $estados_inscripcion = array('CONFIRMADA'=>'CONFIRMADA','NO CONFIRMADA'=>'NO CONFIRMADA','BAJA'=>'BAJA','EGRESO'=>'EGRESO');
            echo $this->Form->input('estado_inscripcion', array('label'=>'Estado de la inscripción*', 'empty' => 'Ingrese un estado de la inscripción...', 'options'=>$estados_inscripcion, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
        ?>
    </div>
</div><hr />
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
      <?php if (($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')) { ?> 
        <?php echo $this->Form->input('centro_id', array('label'=>'Institución*',  'empty' => 'Ingrese una institución...', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));  
        ?><br>
      <?php } ?>
        <?php 
            echo $this->Form->input('Curso', array('multiple' => true, 'label'=>'Sección*', 'empty' => 'Ingrese una sección...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
        ?><br>
        <?php
            $tipos_inscripcion = array('Común'=>'Común','Hermano de alumno regular'=>'Hermano de alumno regular','Pase'=>'Pase','Hijo de docente de la institución'=>'Hijo de docente de la institución');
            echo $this->Form->input('tipo_inscripcion', array('label'=>'Tipo de inscripción*', 'empty' => 'Ingrese un tipo de inscripción...', 'options'=>$tipos_inscripcion, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
        ?><br>
        <!-- Autocomplete para nombre de Personas -->
        <div>
            <input id="PersonaNombreCompleto" class="form-control" label= "Nombre y apellidos del alumno*" data-toggle="tooltip" data-placemente="bottom" placeholder="Ingrese el nombre completo">
            <input id="PersonaId" name="data[Persona][persona_id]" type="text" style="display:none;">
            <div class="alert alert-danger" role="alert" id="AutocompleteError" style="display:none;">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    La persona no fue localizada.
                    <?php echo $this->Html->link("Crear persona",array('controller'=>'personas','action'=>'add'));?>
            </div>
        </div>
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
        <!--
            if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Colegio Secundario') || ($current_user['puesto'] == 'Supervisión Secundaria') || ($current_user['puesto'] == 'Dirección Instituto Superior') || ($current_user['puesto'] == 'Supervisión Secundaria')) {
              echo $this->Form->input('Inscripcion.Materia', array('multiple' => true, 'label'=>'Unidades Curriculares*', 'empty' => 'Ingrese una unidad...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
            }
        -->
    
    </div>
</div>
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
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
        $('select').select2({
            language: "es"
        });
</script>
</div>