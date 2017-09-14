<div class="col-md-6">
	<div class="unit">
        <div class="col-md-4 col-sm-6 col-xs-12 thumbnail text-center">
            <?php if($pase['Pase']['estado'] == "COMPLETA"): ?>
            <span class="checked"></span><?php echo $this->Html->image('../img/inscription_image.png', array('class' => 'img-thumbnail img-responsive')); ?>
            <?php endif; ?>
            <?php if($pase['Pase']['estado'] == "PENDIENTE"): ?>
            <span class="error"></span><?php echo $this->Html->image('../img/inscription_image.png', array('class' => 'img-thumbnail img-responsive')); ?>
                <?php endif; ?>
        </div>
        <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Ciclo:</b> <?php echo $this->Html->link($ciclosNombre[$pase['Pase']['ciclo_id']], array('controller' => 'ciclos', 'action' => 'view', $pase['Pase']['ciclo_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Centro Destino:</b> <?php echo $this->Html->link($centrosNombre[$pase['Pase']['centro_id_destino']], array('controller' => 'centros', 'action' => 'view', $pase['Pase']['centro_id_destino'])); ?></span><br/>
        <!--<span class="name"><span class="glyphicon glyphicon-user"></span> <b>Código:</b> <?php echo $inscripcion['Inscripcion']['legajo_nro']; ?></span><br/>-->
        <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Alumno:</b><?php echo ($this->Html->link($personaNombre[$alumnosId[$pase['Pase']['alumno_id']]], array('controller' => 'alumnos', 'action' => 'view', $pase['Pase']['alumno_id']))); ?></p>
        <div class="text-right">
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'pases', 'action' => 'view', $pase['Pase']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
          <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-edit"></i>', array('controller' => 'pases', 'action' => 'edit', $pase['Pase']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
          <?php endif; ?>
          <?php if($current_user['role'] == 'superadmin'): ?>
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-trash"></i>', array('controller' => 'pases', 'action' => 'delete', $pase['Pase']['id']), array('confirm' => 'Está seguro de borrar el pase nro.'.$pase['Pase']['id'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
          <?php endif; ?>
		</div>
	</div>
</div>
