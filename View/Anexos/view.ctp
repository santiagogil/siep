<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<?php echo $this->Html->css('slider'); ?>
<!-- start main -->
<div class="TituloSec">Anexo <?php echo ($anexo['Anexo']['numero']); ?></div>
<div id="ContenidoSec">
    <div class="row">
        <div class="col-md-8">  
            <div class="unit">
                <div class="row perfil">
                    <!--Datos generales-->
                    <div class="col-md-6 col-sm-4 col-xs-12">   
                        <b><?php echo __('Creación del Registro:'); ?></b>
                           <?php echo h($anexo['Anexo']['created']); ?></p>
                        <b><?php echo __('Resolución relacionada:'); ?></b>
                           <?php echo h($anexo['Anexo']['resolucion_id']); ?></p>
                        <b><?php echo __('Año:'); ?></b>
                           <?php echo $anexo['Anexo']['anio']; ?></p>
                        <b><?php echo __('Documento:'); ?></b>
                           <?php echo h($anexo['Anexo']['documento']); ?></p>   
                    </div><!--/Datos generales-->
                    <div class="col-md-6 col-sm-4 col-xs-12">
                    <!--Datos específicos-->
                        <div id="click_01" class="titulo_acordeon_datos">Descripción <span class="caret"></span></div>
                            <div id="acordeon_01">
                                <div class="unit">
                                    <?php echo h($anexo['Anexo']['descripcion']); ?></p>
                                </div>
                            </div><!--/Datos específicos-->
                    </div>
                </div>
             </div>
          </div>
          <div class="col-md-4">
          <div class="unit">
            <div class="subtitulo">Opciones</div>
            <div class="opcion"><?php echo $this->Html->link(__('Listar Anexos'), array('action' => 'index')); ?> </div>
            <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $anexo['Anexo']['id'])); ?> </div>
            <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $anexo['Anexo']['id']), null, sprintf(__('Esta seguro de borrar el Anexo %s?'), $anexo['Anexo']['id'])); ?></div>
            </div>
     </div>
</div>
<!-- end main -->
