<?php echo $this->Form->create('Centro',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<!-- Autocomplete -->
<div>
   <input id="AutocompleteForm" class="form-control" placeholder="Ingrese institucion por nombre o CUE">
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
