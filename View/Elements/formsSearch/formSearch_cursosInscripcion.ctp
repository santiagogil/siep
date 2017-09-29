<?php echo $this->Form->create('CursosInscripcion',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')): ?>
<div class="form-group">
   <?php echo $this->Form->input('centro_id', array('label' => false, 'empty' => 'Ingrese una centro...', 'class' => 'form-control'));	?>
</div><br>
<?php endif; ?>
<div class="form-group">
   <?php echo $this->Form->input('Inscripcion.ciclo_id', array('label' => false, 'default' => $cicloIdActual, 'class' => 'form-control'));	?>
</div><br>
<div class="form-group">
   <?php
   		$turnos = array('Mañana' => 'Mañana', 'Tarde' =>'Tarde', 'Mañana Extendida' =>'Mañana Extendida', 'Tarde Extendida' => 'Tarde Extendida', 'Doble Extendida' =>'Doble Extendida', 'Vespertino' => 'Vespertino', 'Noche' =>'Noche', 'Otro' =>'Otro'); 
   		echo $this->Form->input('Curso.turno', array('label' => false, 'empty'=>'Ingrese un turno...', 'options'=>$turnos, 'class' => 'form-control'));	?>
</div><br>
<div class="form-group">
   <?php echo $this->Form->input('curso_id', array('label' => false, 'empty' => 'Ingrese una sección...', 'class' => 'form-control'));	?>
</div><br>
<div class="form-group">
   <?php echo $this->Form->input('inscripcion_id', array('label' => false, 'empty' => 'Ingrese un código de inscripción...', 'class' => 'form-control'));	?>
</div>
<hr />
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
