<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <link rel="STYLESHEET" href="css/print_static.css" type="text/css" />
</head>
<body>
    <div id="body">
        <div id="section_header"></div>
        <div id="content">
            <div class="page" style="font-size: 11pt">
                <img src="img/encabezado.jpg" style="float: center; margin: 0.5em;">
                <table style="width: 100%;" class="header">
                    <tr>
                        <td><h1 style="text-align: right">INSCRIPCIÓN NÚMERO | <?php echo ($inscripcion['Inscripcion']['legajo_nro']); ?></h1></td>
                    </tr>
                </table>
                <br>
                <h3>CONSTANCIA DE INSCRIPCIÓN <?php echo ($inscripcion['Inscripcion']['estado_inscripcion']); ?></h3> 
                <br>
                <p> La Supervisión Técnica de Supervisión Escolar, deja constancia que el/la niño/a <?php echo ($personaNombre[$personaId[$inscripcion['Alumno']['id']]]); ?>, ha sido INSCRIPTO/A en esta dependencia, para la Escuela Provincial/Jardín de Infantes: <?php echo ($inscripcion['Centro']['nombre']); ?> en el grado/sala ________________ para el Ciclo Escolar <?php echo ($inscripcion['Ciclo']['nombre']); ?>
                en Ushuaia el día: ___/____/_______
                </p>
                <br>
                <p>IMPORTANTE: El padre/tutor tiene 24 horas para presentarse en la Escuela indicada, caso contrario el/la niño/a perderá la vacante.</p>
                <br>
                <br>
                <table style="width: 100%;" class="header">
                    <tr>
                        <td><h1 style="text-align: right" class="overline stylex block">Sello y firma de supervisor</h1></td>
                    </tr>
                </table>
                <img src="img/footerPdf.png" style="float: center; margin: 0.5em;">
                <hr />
            </div>
            <div class="page" style="font-size: 11pt">
                <img src="img/encabezado.jpg" style="float: center; margin: 0.5em;">
                <table style="width: 100%;" class="header">
                    <tr>
                        <td><h1 style="text-align: right">INSCRIPCIÓN NÚMERO | <?php echo ($inscripcion['Inscripcion']['legajo_nro']); ?></h1></td>
                    </tr>
                </table>
                <br>
                <h3>CONSTANCIA DE INSCRIPCIÓN <?php echo ($inscripcion['Inscripcion']['estado_inscripcion']); ?></h3> 
                <br>
                <p> La Supervisión Técnica de Supervisión Escolar, deja constancia que el/la niño/a <?php echo ($personaNombre[$personaId[$inscripcion['Alumno']['id']]]); ?>, ha sido INSCRIPTO/A en esta dependencia, para la Escuela Provincial/Jardín de Infantes: <?php echo ($inscripcion['Centro']['nombre']); ?> en el grado/sala ________________ para el Ciclo Escolar <?php echo ($inscripcion['Ciclo']['nombre']); ?>
                en Ushuaia el día: ___/____/_______
                </p>
                <br>
                <p>IMPORTANTE: El padre/tutor tiene 24 horas para presentarse en la Escuela indicada, caso contrario el/la niño/a perderá la vacante.</p>
                <br>
                <br>
                <table style="width: 100%;" class="header">
                    <tr>
                        <td><h1 style="text-align: right" class="overline stylex block">Sello y firma de supervisor</h1></td>
                    </tr>
                </table>
                <img src="img/footerPdf.png" style="float: center; margin: 0.5em;">
                <hr />
            </div>
        </div>
    </div>  
</body>
</html>
