<div class="col-md-4">
        <div class="unit">
        <!--<div class="col-md-4 col-sm-6 col-xs-12 thumbnail text-center">
        <?php if($inscripcion['Inscripcion']['estado'] == true): ?>
        <span class="checked"></span><?php echo $this->Html->image('../img/inscription_image.png', array('class' => 'img-thumbnail img-responsive')); ?>
        <?php endif; ?>
        <?php if($inscripcion['Inscripcion']['estado'] == false): ?>
        <span class="error"></span><?php echo $this->Html->image('../img/inscription_image.png', array('class' => 'img-thumbnail img-responsive')); ?>
        <?php endif; ?>
        </div>-->
        <span class="name"><span class="glyphicon glyphicon-calendar"></span> <b>Ciclo:</b> 
        <?php echo $this->Html->link($ciclos[$cursosInscripcion['Inscripcion']['ciclo_id']], array('controller' => 'ciclos', 'action' => 'view', $cursosInscripcion['Inscripcion']['ciclo_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-calendar"></span> <b>Centro:</b> 
        <?php echo $this->Html->link($centros[$cursosInscripcion['Inscripcion']['centro_id']], array('controller' => 'centros', 'action' => 'view', $cursosInscripcion['Inscripcion']['centro_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Sección:</b> <?php echo $this->Html->link($cursosInscripcion['Curso']['nombre_completo_curso'], array('controller' => 'cursos', 'action' => 'view', $cursosInscripcion['Curso']['id']));?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Alumno:</b>  <?php echo $this->Html->link($alumnoNombre[$cursosInscripcion['Inscripcion']['alumno_id']], array('controller' => 'alumnos', 'action' => 'view', $cursosInscripcion['Inscripcion']['alumno_id'])); ?></span><br/>
        <span class="name
        "><span class="glyphicon glyphicon-info-sign"></span> <b>Legajo Nº:</b> <?php echo $this->Html->link($cursosInscripcion['Inscripcion']['legajo_nro'], array('controller' => 'inscripcions', 'action' => 'view', $cursosInscripcion['Inscripcion']['id'])); ?></span><br/> 		   
	</div>
</div>
