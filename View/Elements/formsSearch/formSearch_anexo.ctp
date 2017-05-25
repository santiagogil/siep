<?php echo $this->Form->create('Anexo',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<div class="form-group">
   	<?php 
   		echo $this->Form->input('numero', array('label' => false, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el número de anexo', 'Placeholder' => 'Ingrese número de anexo...'));
        echo $this->Form->input('anio', array('label' => false, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el año del anexo', 'Placeholder' => 'Ingrese año del anexo...'));
   	?>	
</div>
<hr>
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
