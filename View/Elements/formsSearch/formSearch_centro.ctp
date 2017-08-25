<?php echo $this->Form->create('Centro',array('type'=>'get','url'=>'index'));?>
<div class="form-group">
   <?php echo $this->Form->input('cue', array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese Nº de CUE...'));	?>
</div>
<div class="text-center">
   <?php echo $this->Form->end(array('label' => 'BUSCAR', 'class' => 'btn btn-primary'));?>
</div>

<!-- Autocomplete -->
<div>
   <input id="AutocompleteForm" class="form-control" placeholder="Buscar por institucion por nombre">
</div>
<script>
   $( function() {
      $( "#AutocompleteForm" ).autocomplete({
         source: "<?php echo $this->Html->url(array('action'=>'autocompleteCentro'));?>",
         minLength: 2,
         select: function( event, ui ) {
            $("#AutocompleteForm").val( ui.item.Centro.sigla );

            window.location.href = "<?php echo $this->Html->url(array('controller'=>'centros','action'=>'view'));?>/"+ui.item.Centro.id;

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
