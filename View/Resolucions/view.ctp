<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<?php echo $this->Html->css('slider'); ?>
<!-- start main -->
<div class="TituloSec">Resolución <?php echo ($resolucion['Resolucion']['numero']); ?></div>
<div id="ContenidoSec">
    <div class="row">
        <div class="col-md-8">	
	        <div class="unit">
 		        <div class="row perfil">
                    <!--Datos generales-->
                    <div class="col-md-6 col-sm-4 col-xs-12">	
                        <b><?php echo __('Año:'); ?></b>
                           <?php echo $resolucion['Resolucion']['anio']; ?></p>
                        <b><?php echo __('Tipo:'); ?></b>
                           <?php echo $resolucion['Resolucion']['tipo']; ?></p>
                        <b><?php echo __('Creación del registro:'); ?></b>
                           <?php echo h($resolucion['Resolucion']['created']); ?></p>
                        <b><?php echo __('Documento:'); ?></b>
                           <?php echo h($resolucion['Resolucion']['documento']); ?></p>
                    </div><!--/Datos generales-->
                    <div class="col-md-6 col-sm-4 col-xs-12">
                    <!--Datos específicos-->
                        <div id="click_01" class="titulo_acordeon_datos">Descripción <span class="caret"></span></div>
                            <div id="acordeon_01">
                                <div class="unit">
                                    <?php echo h($resolucion['Resolucion']['descripcion']); ?></p>
                                </div>
                            </div><!--/Datos específicos-->
                    </div>
                </div>
             </div>
          </div>
          <div class="col-md-4">
          <div class="unit">
            <div class="subtitulo">Opciones</div>
            <div class="opcion"><?php echo $this->Html->link(__('Listar Resoluciones'), array('action' => 'index')); ?> </div>
            <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $resolucion['Resolucion']['id'])); ?> </div>
            <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $resolucion['Resolucion']['id']), null, sprintf(__('Esta seguro de borrar la Resolución %s?'), $resolucion['Resolucion']['id'])); ?></div>
            </div>
     </div>
</div>
<!-- end main -->
<!-- Anexos Relacionados -->
    <div id="click_02" class="titulo_acordeon">Anexos Relacionados <span class="caret"></span></div>
    <div id="acordeon_02">
        <div class="row">
            <?php if (!empty($resolucion['Anexo'])):?>
            <div class="col-xs-12 col-sm-6 col-md-8">
    <?php foreach ($resolucion['Anexo'] as $anexo): ?>
    <div class="col-md-4">
        <div class="unit">
            <?php echo '<b>Anexo N°:</b> '.($this->Html->link($anexo['numero'], array('controller' => 'anexos', 'action' => 'view', $anexo['id'])));?><br>
            <?php echo '<b>Anexo N°:</b> '.$anexo['anio'];?><br>
            <hr>
            <div class="text-right">
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'anexos', 'action' => 'view', $anexo['id']), array('class' => 'btn btn-success','escape' => false)); ?>
            <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'anexos', 'action' => 'edit', $anexo['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'anexos', 'action' => 'delete', $anexo['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
        <?php endforeach; ?>
            </div>
        <?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
        <?php endif; ?>
    </div>
</div>
<!-- end Anexos Relacionados -->