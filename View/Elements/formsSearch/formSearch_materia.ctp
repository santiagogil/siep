<?php echo $this->Form->create('Materia',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')): ?>
<div class="form-group">
	<?php
		echo $this->Form->input('centro_id', array('label' => false, 'empty' => 'Ingrese una institución...', 'class' => 'form-control'));
    ?>
</div><br>
<?php endif; ?>
<div class="form-group">
	<?php
		echo $this->Form->input('curso_id', array('label' => false, 'empty' => 'Ingrese una sección...', 'class' => 'form-control'));
    ?>
</div><br>
<div class="form-group">
	<?php
		echo $this->Form->input('alia', array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese un alia...'));
    ?>
</div><br>
<<<<<<< HEAD
<div class="form-group">
	<?php
		echo $this->Form->input('plan_de_estudio', array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese un plan de estudio...'));
    ?>
</div><br>
=======
>>>>>>> c7995caecfa37091c952f6bab236d376020c7a7e
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
