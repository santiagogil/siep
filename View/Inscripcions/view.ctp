<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<?php echo $this->Html->css('slider'); ?>
<!-- start main -->
<div class="TituloSec">Inscripción: <?php echo ($inscripcion['Inscripcion']['legajo_nro']); ?></div>
<div id="ContenidoSec">
    <div class="row">
        <div class="col-md-8">	
	        <div class="unit">
 		        <div class="row perfil">
                <!--<h3>Datos del Alumno</h3>-->
                    <div class="col-md-4 col-sm-4 col-xs-12">	
                        <b><?php echo __('Ciclo:'); ?></b>
                        <?php echo ($this->Html->link($inscripcion['Ciclo']['nombre'], array('controller' => 'ciclos', 'action' => 'view', $inscripcion['Ciclo']['nombre']))); ?></p>
                        <b><?php echo __('Institución:'); ?></b>
                        <?php echo($this->Html->link($inscripcion['Centro']['sigla'], array('controller' => 'centros', 'action' => 'view', $inscripcion['Centro']['sigla']))); ?></p>
                        <b><?php echo __('Alumno:'); ?></b>
                        <?php echo ($this->Html->link($alumnoNombre[$inscripcion['Alumno']['persona_id']], array('controller' => 'alumnos', 'action' => 'view', $inscripcion['Alumno']['id']))); ?></p>                     
                        <b><?php echo __('Estado:'); ?></b>
                        <?php if($inscripcion['Inscripcion']['estado'] == "COMPLETA"){; ?>
                        <span class="label label-success"><?php echo $inscripcion['Inscripcion']['estado']; ?></span>
                        <?php } else{; ?>
                        <span class="label label-danger"><?php echo $inscripcion['Inscripcion']['estado']; ?></span>
                        <?php } ?></p>
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <!--<h3>Datos previos</h3>-->
                    <div id="click_03" class="titulo_acordeon_datos">Datos previos <span class="caret"</span></div>
                        <div id="acordeon_03">
                             <div class="unit">
                                <b><?php echo __('Cursa:'); ?></b>
                                <?php echo $inscripcion['Inscripcion']['cursa']; ?></p>
                                <b><?php echo __('Fines:'); ?></b>
                                <?php echo $inscripcion['Inscripcion']['fines']; ?></p>
                                <b><?php echo __('Recursante:'); ?></b>
                                    <?php if($inscripcion['Inscripcion']['recursante'] == 1): ?>
                                    <?php echo "SI"; ?>
                                    <?php endif; ?>
                                    <?php echo "No"; ?></p>
                                <b><?php echo __('Condición de aprobación:'); ?></b>
                                <?php echo $inscripcion['Inscripcion']['condicion_aprobacion']; ?></p>
                             </div>
                        </div>
                        <!--<h3>Datos del alta baja y egreso del Alumno</h3>-->
                        <div id="click_04" class="titulo_acordeon_datos">Datos del Alta <span class="caret"</span></div>
                        <div id="acordeon_04">
                            <div class="unit">
                                <!--<b><?php echo __('Tipo:'); ?></b>
                                <?php echo ($inscripcion['Inscripcion']['tipo_alta']); ?></p>-->
                                <b><?php echo __('Fecha:'); ?></b>
                                <?php echo $this->Html->formatTime($inscripcion['Inscripcion']['fecha_alta']);
                                 ?></p>
                                <b><?php echo __('Documentación:'); ?></b>
                                  <ul>
                                    <?php if(!$inscripcion['Inscripcion']['fotocopia_dni'] == 1): ?>
                                    <li><span class="label label-danger"><?php echo 'Falta Fotocopia DNI'; ?></span></li><?php endif; ?>
                                    <?php if(!$inscripcion['Inscripcion']['certificado_septimo'] == 1): ?>
                                    <li><span class="label label-danger"><?php echo 'Falta Certificado de Séptimo'; ?></span></li><?php endif; ?>
                                    <?php if(!$inscripcion['Inscripcion']['analitico'] == 1): ?>
                                    <li><span class="label label-danger"><?php echo 'Falta Analítico'; ?></span></li><?php endif; ?>
                                  </ul>
                            </div>
                        </div>
                        <div id="click_05" class="titulo_acordeon_datos">Baja <span class="caret"</span></div>
                        <div id="acordeon_05">
                            <div class="unit">
                                <b><?php echo __('Tipo:'); ?></b>
                                <?php echo ($inscripcion['Inscripcion']['tipo_baja']); ?></p>
                                <b><?php echo __('Fecha:'); ?></b>
                                <?php echo ($this->Html->formatTime($inscripcion['Inscripcion']['fecha_baja'])); ?></p>
                                <b><?php echo __('Motivo:'); ?></b>
                                <?php echo $inscripcion['Inscripcion']['motivo_baja']; ?></p>
                             </div>
                             <!--<h3>Datos del egreso</h3>-->
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div id="click_06" class="titulo_acordeon_datos">Egreso <span class="caret"</span></div>
                            <div id="acordeon_06">
                                <div class="unit">
                                    <b><?php echo __('Fecha:'); ?></b>                                    
                                    <?php echo ($this->Html->formatTime($inscripcion['Inscripcion']['fecha_egreso'])); ?></p>
                                    <b><?php echo __('Acta Nº:'); ?></b>                                    
                                    <?php echo $inscripcion['Inscripcion']['acta_nro']; ?></p>                                    
                                    <b><?php echo __('Libro Matriz Nº:'); ?></b>                                    
                                    <?php echo $inscripcion['Inscripcion']['libro_nro']; ?></p>                                    
                                    <b><?php echo __('Folio Nº:'); ?></b>                                    
                                    <?php echo $inscripcion['Inscripcion']['folio_nro']; ?></p>

                                    <b><?php echo __('Título Nº:'); ?></b>                                    
                                    <?php echo $inscripcion['Inscripcion']['titulo_nro']; ?></p>
                                </div>
                            </div>
                    <!--<h3>Datos de la titulación</h3>-->
                    <div id="click_07" class="titulo_acordeon_datos">Titulación <span class="caret"</span></div>
                        <div id="acordeon_07">
                           <div class="unit">
                                <b><?php echo __('Emitido el:'); ?></b>                                
                                <?php echo ($this->Html->formatTime($inscripcion['Inscripcion']['fecha_emision_titulo'])); ?></p>
                                <b><?php echo __('Nota:'); ?></b>                                
                                <?php ($inscripcion['Inscripcion']['nota']); ?></p>                                
                                <b><?php echo __('Fecha Nota:'); ?></b>                                
                                <?php echo ($inscripcion['Inscripcion']['fecha_nota']); ?></p>                                        
                                <b><?php echo __('Agente: '); ?></b>                                
                                <?php echo ($this->Html->link($inscripcion['Empleado']['apellidos'], array('controller' => 'empleados', 'action' => 'view', $inscripcion['Empleado']['apellidos']))
                                    ." ".($this->Html->link($inscripcion['Empleado']['nombres'], array('controller' => 'empleados', 'action' => 'view', $inscripcion['Empleado']['nombres']))));
                                ?></p>
                           </div>
                        </div>
                    <!--<h3>Observaciones</h3>-->
                    <div id="click_08" class="titulo_acordeon_datos">Observaciones <span class="caret"</span></div>
                        <div id="acordeon_08">
                           <div class="unit">
                                <b><?php echo __('Observaciones:'); ?></b>                                
                                <?php echo ($inscripcion['Inscripcion']['observaciones']); ?></p>                                
                           </div>
                        </div>
                    </div>
                 </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="unit">
 			      <div class="subtitulo">Opciones</div>
                  <div class="opcion"><?php echo $this->Html->link(__('Listar Inscripciones'), array('action' => 'index')); ?></div>
                <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>  
                  <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $inscripcion['Inscripcion']['id'])); ?> </div>
                  <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $inscripcion['Inscripcion']['id']), null, sprintf(__('Esta seguro de borrar la inscripción %s?'), $inscripcion['Inscripcion']['id'])); ?></div>
                <?php endif; ?>  
              </div>
          </div>
     </div>
<!-- end main -->
<!-- Cursos Relacionados -->
<div id="click_01" class="titulo_acordeon">Secciones Relacionadas <span class="caret"</span></div>
<div id="acordeon_01">
		<div class="row">
	        <?php if (!empty($inscripcion['Curso'])):?>
  			<div class="col-xs-12 col-sm-6 col-md-8">
	            <?php foreach ($inscripcion['Curso'] as $curso): ?>
                <div class="col-md-4">
                    <div class="unit">
                        <?php echo '<b>Año:</b> '.$curso['anio'];?><br>
                        <?php echo '<b>División:</b> '.$curso['division'];?><br>
                        <?php echo '<b>Turno:</b> '.$curso['turno'];?><br>
                        <?php echo '<b>Tipo:</b> '.$curso['tipo'];?><br>
                        <!--<?php echo '<b>Cursada:</b> '.$curso['organizacion_cursada'];?><br>
                        <?php echo '<b>Titulación:</b> '.($this->Html->link($curso['titulacion_id'], array('controller' => 'titulacions', 'action' => 'view', $curso['titulacion_id'])));?><br>-->
                        <hr>
                        <div class="text-right">
                            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'cursos', 'action' => 'view', $curso['id']), array('class' => 'btn btn-success','escape' => false)); ?>
                          <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
                            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'cursos', 'action' => 'edit', $curso['id']), array('class' => 'btn btn-warning','escape'  => false)); ?>
                            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'cursos', 'action' => 'delete', $curso['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
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
<!-- end Cursos Relacionados -->
<!-- Materias Relacionados --> 
<div id="click_02" class="titulo_acordeon">Unidades Curriculares Relacionadas <span class="caret"</span></div>
<div id="acordeon_02">
		<div class="row">
	        <?php if (!empty($inscripcion['Materia'])):?>
  	  	    <!-- Swiper -->
            <div class="swiper-container" style="height: 200px;">
                <div class="swiper-wrapper" >
	                <?php foreach ($inscripcion['Materia'] as $materia): ?>
                    <div class="swiper-slide">
                        <div class="col-md-12">
                            <div class="unit" >
                                <?php echo '<b>Nombre:</b> '.$materia['nombre'];?><br>
                                <?php echo '<b>Alia:</b> '.$materia['alia'];?><br>
                                <?php echo '<b>Carga horaria:</b> '.$materia['carga_horaria_semanal'].' '.$materia['carga_horaria_en'];?>
                            <br>
                              <div class="text-right">
                                <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'materias', 'action' => 'view', $materia['id']), array('class' => 'btn btn-success','escape' => false)); ?>
                               <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
                                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'materias', 'action' => 'edit', $materia['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
                                <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-trash"></i>'), array('controller' => 'materias', 'action' => 'delete', $materia['id']), array('class' => 'btn btn-danger','escape' => false)); ?>

                              <?php endif; ?>
                             </div>
                            </div>
                        </div>
                    </div>
		            <?php endforeach; ?>
			</div>
			<!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- Include plugin after Swiper --> 
	<?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
    <?php endif; ?>
  </div>
</div>
<!-- end Materias Relacionados -->
</div>
<!-- Initialize Swiper -->
    <script>
		  var swiper = new Swiper('.swiper-container', {
			  pagination: '.swiper-pagination',
			  paginationClickable: true,
		  });
    </script>