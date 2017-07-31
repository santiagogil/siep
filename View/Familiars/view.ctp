<div class="TituloSec">Familiares </div>
<div id="ContenidoSec">	
    <div class="row"><div class="col-md-8">
        <div class="unit perfil">
		    <div class="subtitulo"><?php echo ($familiar['Familiar']['vinculo']); ?></div>
	        <div class="row">
	            <div class="col-md-6 col-sm-6">
                    <b>Nombre completo:</b>		
                    <?php echo ($personaNombre[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Nacionalidad:</b>		
                    <?php echo ($personaNacionalidad[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Cuil/Cuit:</b>		
                    <?php echo ($personaCuilCuit[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Ocupación:</b>		
                    <?php echo ($personaOcupacion[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Lugar de trabajo:</b>		
                    <?php echo ($personaLugarTrabaja[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Observaciones:</b>
                    <?php echo ($familiar['Familiar']['observaciones']); ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <b>Ciudad:</b>
                    <?php echo ($personaCiudad[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Domicilio:</b>
                    <?php echo ($personaCalleNombre[$familiar['Familiar']['persona_id']]). ' ' . ($personaCalleNumero[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Telefono:</b>
                    <?php echo ($personaTelefono[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Email:</b>
                    <?php echo ($personaEmail[$familiar['Familiar']['persona_id']]); ?><br>
                </div>
		    </div>
	    </div>
    </div>
    <div class="col-md-4">
        <div class="unit">
            <div class="subtitulo">Opciones</div>
            <div class="opcion"><?php echo $this->Html->link(__('Listar Alumnos'), array('action' => 'index', 'controller' => 'alumnos')); ?></div>
            <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $familiar['Familiar']['id'])); ?></div>
            <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $familiar['Familiar']['id'] ), null, sprintf(__('Esta seguro de borrar el familiar "'.$familiar['Familiar']['id'].'"'), $this->Form->value('Familiar.id'))); ?>
            </div>
        </div>
    </div>	
  </div>
</div>
