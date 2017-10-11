<?php echo $this->Form->create('CursosInscripcion',array('type'=>'get','url'=>'index', 'novalidate' => true));?>

<div class="form-group">
    <?php
    // Si la persona que navega no es Admin, muestro autocomplete de todas las secciones
    if(!$this->Siep->isAdmin()) :
        ?>
            <!-- Autocomplete -->
            <input id="Autocomplete" class="form-control" placeholder="Buscar institucion por nombre" type="text">
            <input id="AutocompleteId" type="hidden" name="centro_id">
            <script>
                $( function() {
                    $( "#Autocomplete" ).autocomplete({
                        source: "<?php echo $this->Html->url(array('controller'=>'Centros','action'=>'autocompleteCentro'));?>",
                        minLength: 2,
                        select: function( event, ui ) {
                            $("#Autocomplete").val( ui.item.Centro.sigla );
                            $("#AutocompleteId").val( ui.item.Centro.id );
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
        <?php
    endif;
    ?>
</div>

<br>

<div class="form-group">
    <div class="input select">
        <select name="ciclo_id" class="form-control" data-toggle="tooltip" data-placement="bottom">
            <option value="">Seleccione un ciclo...</option>
            <?php
            foreach($comboCiclo as $ciclo_id => $ciclo_value) :
                ?>
                <option value="<?php echo $ciclo_id;  ?>"><?php echo $ciclo_value; ?></option>
                <?php
            endforeach;
            ?>
        </select>
    </div>
</div>

<br>
<div class="form-group">
   <?php
   		$turnos = array('Mañana' => 'Mañana', 'Tarde' =>'Tarde', 'Mañana Extendida' =>'Mañana Extendida', 'Tarde Extendida' => 'Tarde Extendida', 'Doble Extendida' =>'Doble Extendida', 'Vespertino' => 'Vespertino', 'Noche' =>'Noche', 'Otro' =>'Otro'); 
   		echo $this->Form->input('Curso.turno', array('label' => false, 'empty'=>'Ingrese un turno...', 'options'=>$turnos, 'class' => 'form-control'));	?>
</div><br>
<div class="form-group">
    <div class="input select">
        <select name="seccion" class="form-control" data-toggle="tooltip" data-placement="bottom">
            <option value="">Seleccione una seccion...</option>
            <?php
            foreach($comboSecciones as $seccion_id=> $seccion_value) :
                ?>
                <option value="<?php echo $seccion_id;  ?>"><?php echo $seccion_value; ?></option>
                <?php
            endforeach;
            ?>
        </select>
    </div>
</div><br>
<hr />
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
