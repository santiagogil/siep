<!-- start main -->
<div class="TituloSec">Promocion de alumnos</div>
<div id="ContenidoSec">
    <div id="main">
        <!-- start second nav -->
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8">
                <div class="row">
                    <?php
                    echo $this->element('promocion_lista',array( 'cursosInscripcions' => $cursosInscripcions ));
                    ?>
                </div>
                <div class="unit text-center">
                    <?php echo $this->element('pagination'); ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="unit">
                    <div class="subtitulo">Búsqueda</div>
                    <br>
                    <?php echo $this->element('formsSearch/formSearch_promocion'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end main -->
