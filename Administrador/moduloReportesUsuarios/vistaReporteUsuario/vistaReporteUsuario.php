<?php 
session_start();
//if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
 //           header("Location: /index.php", TRUE, 301);
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link rel="stylesheet" href="vistaReporteUsuario.css">
    <title>Reporte</title>
    
    <? include('../../../Recursos/includeHead.php') ?>


</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <h1 class="titulo">
        Vista específica de reporte
    </h1>

    <div class="contenedorReporte">
        <section class="infoReporte">
            <h3>
                Detalles 
            </h3>
            <br>
            <p class="categoria">
                Cat
            </p>
            <br>
            <select name="Categoria" id="selectCategoria" class = "formText">

            </select>
            <br>
            <br>
            <p class="estatus">
                Status
            </p>
            <br>
            <p id="fecha">

            </p>
            <br>
            <p class="descripcionReporte">
                Mensaje
            </p>

        </section>

        <section class="eleccionPersonal ">
            <div class="listaPersonal">
                <select name="tipoPersonal" id="tipoPersonal" class="formText">
                    <option selected="true" disabled>Tipo de personal</option>
                    <option value="Recepcion">Recepcionista</option>
                    <option value="Limpieza">Personal de limpieza</option>
                    <option value="Valet">Valet parking</option>
                    <option value="Servicio">Personal de servicio</option>
                    
                </select>
                <div class="listaSeleccionPersonal">
                   

                </div>
                <button class="asignarPersonal" disabled="true">Asignar</button>

            </div>
        </section>

        <section class="chat" >


            <p class="destinatario" id ="PAsignado">Personal asignado: </p>
            <div class="cuerpoChat">
                <div class="contenedorMensajes">

                    </div>
                        <form class="envioMensaje" id="envioMensaje">
                            <input type="text" class="nuevoMensaje" id="mensajeChat">
                            <button class="enviarMensaje" type="submit" >></button>

                        </form>
                    </div>

                </div>
            </div>    
            <div class="botones">
                
            </div>
            
        </section>
    </div>
    <div class="acciones">
        <button class="spam">Spam</button>
        <button class="notificar">Notificar Manualmente</button>
        <button class="completado">Completado</button>
        
    </div>




    <script src="../../../Recursos/clase-menu.js"></script>
    
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="vistaReporteUsuario.js"></script>


</body>
</html>