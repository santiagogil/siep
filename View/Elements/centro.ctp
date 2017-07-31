<div class="col-md-6">
	<div class="unit">
	    <span class="name"><span class="glyphicon glyphicon-user"></span> <b>CUE:</b> <?php echo ($centro['Centro']['cue']); ?></span><br/>

	   	<span class="name"><span class="glyphicon glyphicon-user"></span> <b>Nombre:</b> <?php echo ($centro['Centro']['sigla']); ?></span><br/>

        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Sector:</b> <?php echo ($centro['Centro']['sector']); ?></span><br/>    	    

   	    <span class="name"><span class="glyphicon glyphicon-map-marker"></span> <b>Dirección:</b> <?php echo ($centro['Centro']['direccion']); ?></span><br/> 

   	    <span class="name"><span class="glyphicon glyphicon-map-marker"></span> <b>Ciudad:</b> <?php echo ($centro['Centro']['ciudad']); ?></span><br/>
  
        <span class="name"><span class="glyphicon glyphicon-earphone"></span> <b>Tel:</b> <?php echo ($centro['Centro']['telefono']); ?> </span><br/>

        <span class="name"><span class="glyphicon glyphicon-envelope"></span> <b>Email:</b> <?php echo $this->Html->link($centro['Centro']['email'], 'mailto:'.$centro['Centro']['email']); ?> </span><br/>
                 
        <div class="text-right">
	        <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-eye-open"></i>', array('action' => 'view', $centro['Centro']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
	      <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>  
	        <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-edit"></i>', array('action' => 'edit', $centro['Centro']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
	        <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-trash"></i>', array('action' => 'delete', $centro['Centro']['id']), array('confirm' => 'Está seguro de borrar a '.$centro['Centro']['sigla'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
	      <?php endif; ?>
        </div>
	</div>
</div>
