<?php echo $this->Form->create('Alumno', array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<div class="form-group">
   <?php echo $this->Form->input('legajo_fisico_nro', array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese un nº de legajo físico...'));	?>
</div>
<hr>
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>

<!-- Autocomplete -->
<div>
    <input id="AlumnoPersonaId" class="form-control" placeholder="Buscar por nombre y/o apellido">
</div>
<script>
    $( function() {
        $( "#AlumnoPersonaId" ).autocomplete({
            source: "<?php echo $this->Html->url(array('action'=>'autocompleteNombreAlumno'));?>",
            minLength: 2,
            select: function( event, ui ) {
                $("#AlumnoPersonaId").val( ui.item.Persona.nombre_completo_persona );

                window.location.href = "<?php echo $this->Html->url(array('controller'=>'alumnos','action'=>'view'));?>/"+ui.item.Persona.id;

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
