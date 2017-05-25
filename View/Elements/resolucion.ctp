<div class="col-md-4">
	<div class="unit">
        <span class="name"><span class="glyphicon glyphicon-calendar"></span> <b>Resolución N°:</b> 
        <?php echo $resolucion['Resolucion']['numero']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Año: </b> <?php echo $resolucion['Resolucion']['anio']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Tipo: </b> <?php echo $resolucion['Resolucion']['tipo']; ?></span><br/>
        <hr />
        <div class="text-right">
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'resolucions', 'action' => 'view', $resolucion['Resolucion']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
           <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
            <span class="link"><?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('action' => 'edit', $resolucion['Resolucion']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('controller' => 'resolucions', 'action' => 'delete', $resolucion['Resolucion']['id']), array('confirm' => 'Está seguro de borrar la Resolucion '.$resolucion['Resolucion']['numero'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
           <?php endif; ?>  
 		</div>
	</div>
</div>
