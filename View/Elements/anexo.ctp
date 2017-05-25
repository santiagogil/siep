<div class="col-md-4">
	<div class="unit">
        <span class="name"><span class="glyphicon glyphicon-calendar"></span> <b>Anexo N°:</b> 
        <?php echo $anexo['Anexo']['numero']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Año: </b> <?php echo $anexo['Anexo']['anio']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Resolución: </b> <?php echo $this->Html->link($resolucions[$anexo['Anexo']['resolucion_id']], array('controller' => 'resolucions', 'action' => 'view', $anexo['Anexo']['resolucion_id'])); ?></span><br/>
        <hr/>
        <div class="text-right">
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'anexos', 'action' => 'view', $anexo['Anexo']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
           <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
            <span class="link"><?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('action' => 'edit', $anexo['Anexo']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('controller' => 'anexos', 'action' => 'delete', $anexo['Anexo']['id']), array('confirm' => 'Está seguro de borrar la Resolucion '.$anexo['Anexo']['numero'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
           <?php endif; ?>  
 		</div>
	</div>
</div>
