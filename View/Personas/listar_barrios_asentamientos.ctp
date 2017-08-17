
	<?php echo $this->Form->input('barrio_id', array('label' => 'Barrio*','options'=>$lista_barrios ,'empty' => 'Ingrese un barrio...','between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción.'));
  echo $this->Form->input('asentamiento_id', array('label' => 'Asentamiento', 'empty' => 'Ingrese un asentamiento...',  'options' => $lista_asentamientos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción.'));

?>
