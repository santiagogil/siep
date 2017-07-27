<?php echo $this->Html->script(array('tooltip', 'moment', 'bootstrap-datetimepicker')); ?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<div class="row">
	<div class="col-xs-6 col-sm-3">
	    <?php echo $this->Form->input('created', array('label' => 'Creado*', 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar')); ?>
    </div>
</div><hr />
<div class="row">
   	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="unit"><strong>Datos Generales</strong><hr />
			<?php
	            echo $this->Form->input('Alumno', array('label'=>'Alumno*', 'empty' => 'Ingrese un alumno...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
	            echo $this->Form->input('persona_id', array('label'=>'Persona*', 'empty' => 'Ingrese una persona...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
	        ?>
	  	</div>
	  	<?php echo '</div><div class="col-md-6 col-sm-6 col-xs-12">'; ?>
      	<div class="unit"><strong>Datos Específicos</strong><hr />
        	<?php
			  	$vinculos = array('Padre' => 'Padre', 'Madre'=>'Madre', 'Tutor'=>'Tutor');
			  	echo $this->Form->input('vinculo', array('label'=>'Vinculo*', 'empty' => 'Ingrese un vinculo...', 'options' => $vinculos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
			?>
        </div>
    </div>
    <div class="col-md-12 col-sm-6 col-xs-12">
        <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
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
    <script>tinymce.init({ selector:'textarea' });</script>
   </div>
</div>
