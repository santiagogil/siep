<?php echo $this->Html->css(array('/js/select2/select2.min')); ?>
<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker','select2/select2.min')); ?>

<script>
    $(function(){
/*
        $('.s2_centro').select2({
            ajax: {
                delay: 250,
                url: "<?php echo $this->Html->url(array('controller'=>'centros', 'action'=>'autocompleteCentro'));?>",
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
*/

        $('.s2_centro').select2();
        $('.s2_seccion').select2();

        $('.s2_centro').on("change", function(){
            // Remueve datos de secciones
            $(".s2_seccion").empty();
            // Obtener secciones dependientes al centro
            $.ajax({
                type:"GET",
                url: "/centros/autocompleteSeccionDependiente?id=" + $(this).val(),
                success: function(lista){

                    $(".s2_centro").append('<option value="' +''+ '"> ' + 'Seleccione una sección'+ '</option>');

                    for (var key  in lista) {
                        $(".s2_seccion").append('<option value="' +key+ '"> ' + lista[key] + '</option>');
                    }
                }
            });
        });

    });
</script>

<div class="row">
  <div class="col-xs-6 col-sm-3">
      <?php
          echo $this->Form->input('ciclo_id', array('label'=>'Ciclo lectivo*', 'default'=>$cicloIdActual, 'disabled' => true, 'empty' => 'Ingrese un ciclo lectivo...', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?>
      <?php echo $this->Form->input('usuario_id', array('type' => 'hidden')); ?>
  </div>
  <div class="col-xs-6 col-sm-3">
      <?php
          $estados_inscripcion = array('CONFIRMADA'=>'CONFIRMADA','NO CONFIRMADA'=>'NO CONFIRMADA');
           echo $this->Form->input('estado_inscripcion', array('label'=>'Estado de la inscripción*', /*'default'=>'NO CONFIRMADA', 'disabled' => true,*/ 'empty' => 'Ingrese un estado de la inscripción...', 'options'=>$estados_inscripcion, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?>
  </div>
</div><hr />
<div class="row">
  <!-- Datos generales -->
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
        <!-- Autocomplete para nombre de Personas -->
        <div>
            <strong><h5>Nombre y apellidos del alumno*</h5></strong>
            <input id="PersonaNombreCompleto" class="form-control" data-toggle="tooltip" data-placemente="bottom" placeholder="Ingrese el nombre completo">
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
            if (($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')) {
                echo $this->Form->input('centro_id', array('label'=>'Institución*', 'empty' => 'Ingrese una institución...', 'class' => 's2_centro form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                echo '<br>';
            }
        ?>

        <?php
            echo $this->Form->input('Curso', array('multiple' => true, 'label'=>'Sección*', 'empty' => 'Ingrese una sección...', 'between' => '<br>', 'class' => 's2_seccion form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
            /*
            if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Colegio Secundario') || ($current_user['puesto'] == 'Supervisión Secundaria') || ($current_user['puesto'] == 'Dirección Instituto Superior') || ($current_user['puesto'] == 'Supervisión Secundaria')) {
              echo $this->Form->input('Inscripcion.Materia', array('multiple' => true, 'label'=>'Unidades Curriculares*', 'empty' => 'Ingrese una unidad...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
            }
            */
            echo $this->Form->input('legajo_nro', array('type' => 'hidden'));
      ?>
    </div>
  </div>
  <!-- End Datos generales -->

   <!-- Datos de alta -->
   <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="unit">
        <strong><h3>Datos del Alta</h3></strong>
        <hr />
      <?php
            $tipos_inscripcion = array('Común'=>'Común','Hermano de alumno regular'=>'Hermano de alumno regular','Pase'=>'Pase','Situación social'=>'Situación social', 'Integración'=>'Integración');
            echo $this->Form->input('tipo_inscripcion', array('id'=>'tipoInscripcion','disabled'=>true,'default'=>'Común', 'label'=>'Tipo de inscripción*', 'disabled' => true, 'empty' => 'Ingrese un tipo de inscripción...', 'options'=>$tipos_inscripcion, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?>

    <hr>
    <!-- Autocomplete -->
    <?php /*
    <div id="formHermanoDeAlumnoRegular">
        <strong><h5>Hermano de Alumno Regular</h5></strong>
        <input id="AutocompleteHermanoAlumno" class="form-control" placeholder="Indique Alumno por DNI, nombre y/o apellido">
        <input id="AutocompleteHermanoAlumnoId" type="hidden" name="data[Inscripcion][hermano_id]">
        <div class="alert alert-danger" role="alert" id="AutocompleteHermanoAlumnoError" style="display:none;">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            No se encontraron resultados de busqueda
        </div>
    </div>
    <script>
        $( function() {
            $( "#AutocompleteHermanoAlumno" ).autocomplete({
                source: "<?php echo $this->Html->url(array('controller'=>'Alumnos', 'action'=>'autocompleteNombreAlumno'));?>",
                minLength: 2,
                select: function( event, ui ) {
                    var nombre_completo = ui.item.Persona.nombres +" "+ ui.item.Persona.apellidos;
                    $("#AutocompleteHermanoAlumno").val( nombre_completo );
                    $("#AutocompleteHermanoAlumnoId").val(ui.item.Alumno.id);
                    //window.location.href = "<?php echo $this->Html->url(array('controller'=>'alumnos','action'=>'view'));?>/"+ui.item.Alumno.id;
                    return false;
                },
                response: function(event, ui) {
                    if (ui.content.length === 0)
                    {
                        $("#AutocompleteHermanoAlumnoError").show();
                    } else {
                        $("#AutocompleteHermanoAlumnoError").hide();
                    }
                }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                var nombre_completo = item.Persona.nombres +" "+ item.Persona.apellidos +' - ' +item.Persona.documento_nro;
                return $( "<li>" )
                    .append( "<div>" +nombre_completo+ "</div>" )
                    .appendTo( ul );
            };
        });
    </script>
    <!-- End Autocomplete -->

    <div id="formPase" style="display:none;">
      <strong><h5>Pase</h5></strong>
      <input id="AutocompleteForm" class="form-control" placeholder="Indique institucion origen por nombre o CUE">
      <input id="centroId" type="hidden" name="data[Inscripcion][centro_origen_id]">
    </div>
      <script>
         $( function() {
            $( "#AutocompleteForm" ).autocomplete({
               source: "<?php echo $this->Html->url(array('controller'=>'centros', 'action'=>'autocompleteCentro'));?>",
               minLength: 2,
               select: function( event, ui ) {
                  $("#AutocompleteForm").val( ui.item.Centro.sigla );
                  $('#centroId').val(ui.item.Centro.id);
                  return false;
               }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
               return $( "<li>" )
                   .append( "<div>" +item.Centro.sigla + "</div>" )
                   .appendTo( ul );
            };
            $("#formularioBusqueda").submit(function(e){
               e.preventDefault();

               var centroId = $('#centroId').val();
               window.location.href = "<?php echo $this->Html->url(array('controller'=>'centros','action'=>'view'));?>/"+centroId;
            });
         });
      </script>

    <div id="formSituacionSocial" style="display:none;">
      <?php
            $situaciones_sociales = array('Mudanza de la familia' => 'Mudanza de la familia', 'Pasó a educación de jóvenes y adultos' => 'Pasó a educación de jóvenes y adultos', 'Pasó a educación especial' => 'Pasó a educación especial', 'No le gustaba la escuela' => 'No le gustaba la escuela', 'Tenía muchas materias previas' => 'Tenía muchas materias previas', 'Problemas disciplinarios' => 'Problemas disciplinarios',  'Decisión de la escuela' => 'Decisión de la escuela', 'Problemas de salud' =>  'Problemas de salud', 'Cambio en la situación económica' => 'Cambio en la situación económica', 'Comenzó a trabajar' => 'Comenzó a trabajar', 'Quedó embarazada' => 'Quedó embarazada', 'Debe colaborar en la casa' => 'Debe colaborar en la casa');
            echo $this->Form->input('situacion_social', array('label' => 'Situación social', 'empty' => 'Ingrese una opción...', 'options' => $situaciones_sociales, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?>
    </div>
    */ ?>   
    <?php
      /*
            $tipos_alta = array('Regular' => 'Regular', 'Equivalencia'=>'Equivalencia');
            echo $this->Form->input('tipo_alta', array('label' => 'Alta tipo*', 'default' => 'Ingrese un tipo...', 'options' => $tipos_alta, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));

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
      */
      ?>


    </div>
   </div>
   <!-- End Datos de alta -->

    <!-- Documentacion presentada -->
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="unit"><strong><h3>Documentación Presentada</h3></strong><hr />
        <div class="row"><br>
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
        <div class="input-group">
          <span class="input-group-addon">
            <?php echo $this->Form->input('partida_nacimiento_alumno', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Partida de Nacimiento Alumno</label>'));?>
          </span>
        </div>
        <div class="input-group">
          <span class="input-group-addon">
           <?php echo $this->Form->input('partida_nacimiento_tutor', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Partida de Nacimiento Tutor</label>'));?>
          </span>
        </div>
        <div class="input-group">
          <span class="input-group-addon">
            <?php echo $this->Form->input('libreta_sanitaria', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Libreta Sanitaria</label>'));?>
          </span>
        </div>
      </div><br>
    </div>
  </div>
  <!-- End documentacion presentada -->
  <div class="row">
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

        $(function() {
            $( "#tipoInscripcion" ).change(function(e){

                // Por defecto oculta todas las opciones de inscripcion
                $('#formHermanoDeAlumnoRegular').hide();
                $('#formPase').hide();
                $('#formSituacionSocial').hide();

                // Resetea los formularios al cambiar el tipo de carga
                $('#formHermanoDeAlumnoRegular input').val('');
                $('#formPase input').val('');
                $('#formSituacionSocial select').val('');

                var opt = $( this ).val();
                switch(opt) {
                    case 'Hermano de alumno regular':
                        $('#formHermanoDeAlumnoRegular').show();
                    break;
                    case 'Pase':
                        $('#formPase').show();
                    break;
                    case 'Situación social':
                        $('#formSituacionSocial').show();
                    break;
                }
            });

            // Quita el modo disabled del formulario, para enviar los datos!
            $('form').submit(function(e) {
                $(':disabled').each(function(e) {
                    $(this).removeAttr('disabled');
                })
            });
        });
    </script>

</div>
