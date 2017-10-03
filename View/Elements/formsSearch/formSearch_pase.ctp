<?php echo $this->Form->create('Pase',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<div class="form-group">
   <?php echo $this->Form->input('ciclo_id', array('label' => false, 'between' => '<br>', 'class' => 'form-control', 'empty' => 'Ingrese un ciclo...')); ?>
</div>
<?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')): ?>
    <div class="form-group">
       <?php echo $this->Form->input('centro_id_origen', array('label' => false, 'options'=>$centrosNombre, 'between' => '<br>', 'class' => 'form-control', 'empty' => 'Ingrese una institución de origen...')); ?>
    </div>

<?php endif; ?>
<div class="form-group">
   <?php echo $this->Form->input('centro_id_destino', array('label' => false, 'options'=>$centrosNombre, 'between' => '<br>', 'class' => 'form-control', 'empty' => 'Ingrese una institución de destino...')); ?>
</div>
<!--<div class="form-group">
   <?php echo $this->Form->input('alumno_id', array('label' => false, 'between' => '<br>', 'class' => 'form-control', 'empty' => 'Ingrese un alumno...')); ?>
</div>-->
<div class="form-group">
    <?php
        $documentacion_estados = array('COMPLETA' => 'COMPLETA', 'PENDIENTE' => 'PENDIENTE');
        echo $this->Form->input('estado_documentacion', array('label' => false, 'empty' => 'Ingrese un estado de la documentación...', 'options' => $documentacion_estados, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
    ?>
</div>
<div class="form-group">
    <?php
    $pase_estados = array('CONFIRMADO'=>'CONFIRMADO','NO-CONFIRMADO'=>'NO-CONFIRMADO','BAJA'=>'BAJA');
    echo $this->Form->input('estado_pase', array('label' => false, 'empty' => 'Ingrese un estado del pase...', 'options' => $pase_estados, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
    ?>
</div>
<hr>
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
