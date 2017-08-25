<?php echo $this->Form->create('Persona',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<div class="form-group">
   <?php echo $this->Form->input('documento_nro' , array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese un nº de documento...'));	?>
</div>
<hr>
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>

<!-- Autocomplete -->
<div>
    <input id="AutocompleteForm" class="form-control" placeholder="Buscar por nombre y/o apellido">
</div>
<script>
    $( function() {
        $( "#AutocompleteForm" ).autocomplete({
            source: "<?php echo $this->Html->url(array('action'=>'autocompletePersonas'));?>",
            minLength: 2,
            select: function( event, ui ) {
                $("#AutocompleteForm").val( ui.item.Persona.nombre_completo_persona );

                window.location.href = "<?php echo $this->Html->url(array('controller'=>'personas','action'=>'view'));?>/"+ui.item.Persona.id;

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
