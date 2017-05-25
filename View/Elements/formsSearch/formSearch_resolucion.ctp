<?php echo $this->Form->create('Resolucion',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<div class="form-group">
   	<?php 
   		echo $this->Form->input('numero', array('label' => false, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el número de resolución', 'Placeholder' => 'Ingrese número de resolución...'));
        echo $this->Form->input('anio', array('label' => false, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el año de la resolución', 'Placeholder' => 'Ingrese año de la resolución...'));
   		$tipos = array('PROVINCIAL' => 'PROVINCIAL', 'NACIONAL' => 'NACIONAL', 'HOMOLOGACIÓN' => 'HOMOLOGACIÓN');
   		echo $this->Form->input('tipo', array('label' => false, 'empty' => 'Ingrese un tipo...', 'options' => $tipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el tipo de resolución'));
   	?>	
</div>
<hr>
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
