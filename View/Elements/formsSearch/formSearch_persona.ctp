<?php echo $this->Form->create('Persona',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<!-- Autocomplete -->
<div>
    <input id="AutocompleteForm" class="form-control" placeholder="Ingrese documento, nombre o apellido">
</div>
<hr />

<?php echo $this->Form->end(); ?>
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
