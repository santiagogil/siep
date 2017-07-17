<!-- start main -->
<div class="TituloSec">Instituciones</div>
<div id="ContenidoSec">
	<div id="main">
	<!-- start second nav -->
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-8">
	    		<div id="second-nav">
				    <div class="unit text-center">
<<<<<<< HEAD
			  	     <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>  
		                <span class="link"><?php echo $this->Html->link(' <i class="glyphicon glyphicon-plus "></i> AGREGAR', array('action' => 'add'), array('class' => 'btn btn-primary','escape' => false)); ?>
		                </span>
		               <?php endif; ?>  
		            </div>
=======
					   <?php if($current_user['role'] == 'superadmin'): ?> 
					    <span class="link"><?php echo $this->Html->link('Agregar', array('action' => 'add'), array('class' => 'btn btn-primary btn-lg')); ?>
					    </span>
					   <?php endif; ?> 
					</div>
>>>>>>> c7995caecfa37091c952f6bab236d376020c7a7e
			    </div>
		<!-- end second nav -->
				<div class="row">
				    <?php foreach ($centros as $centro): ?>
				    <?php echo $this->element('centro',array( 'centro' => $centro )); ?>
				    <?php endforeach; ?>
			    </div>
	  		    <div class="unit text-center">
					<?php echo $this->element('pagination'); ?> 
				</div>
			</div>
		    <div class="col-xs-12 col-sm-4 col-md-4">
			  	<div class="unit">
			  	    <div class="subtitulo">Búsqueda</div>
					</br>
					<?php echo $this->element('formsSearch/formSearch_centro'); ?>
			  	</div>
			</div>
	    </div>
    </div>
<!-- end main -->
