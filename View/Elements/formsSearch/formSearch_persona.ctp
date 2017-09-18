<?php echo $this->Form->create('Persona',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<div class="form-group">
    <?php echo $this->Form->input('documento_nro' , array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese Nº de documento...'));	?>
</div>
<!-- Autocomplete -->
<div>
    <input id="AutocompleteForm" class="form-control" placeholder="Buscar persona por nombre y/o apellido">
</div>
<hr />
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    $( function() {
        $( "#AutocompleteForm" ).autocomplete({
            source: "<?php echo $this->Html->url(array('action'=>'autocompletePersonas'));?>",
            minLength: 2,
            select: function( event, ui ) {
                var nombre_completo = ui.item.Persona.nombres +" "+ui.item.Persona.apellidos + " - "+ui.item.Persona.documento_nro;
                $("#AutocompleteForm").val( nombre_completo );

                window.location.href = "<?php echo $this->Html->url(array('controller'=>'personas','action'=>'view'));?>/"+ui.item.Persona.id;

                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            var nombre_completo = item.Persona.nombres +" "+item.Persona.apellidos + " - "+item.Persona.documento_nro;

            return $( "<li>" )
                .append( "<div>" +nombre_completo+ "</div>" )
                .appendTo( ul );
        };
    });
</script>
<!-- End Autocomplete -->
