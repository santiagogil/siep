<?php echo $this->Form->create('Anexo',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<div class="form-group">
   	<?php 
   		echo $this->Form->input('titulacion_id', array('label' => false, 'empty' => 'Ingrese una titulación...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'Placeholder' => 'Ingrese una titulación...'));
        echo $this->Form->input('resolucion_id', array('label' => false, 'empty' => 'Ingrese una resolución...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'Placeholder' => 'Ingrese número de resolución...'));
   	?>	
</div>
<hr>
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
