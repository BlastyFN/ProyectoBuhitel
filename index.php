<?php 
session_start();
if (isset($_SESSION['sesionPersonal'])) {
    switch ($_SESSION['sesionPersonal']['Tipo']) {
        case 'Administrador':
            header("Location: /Administrador/pagina principal admin/pagPrincipalAdmin.php", TRUE, 301);
            exit();
        break;
        case 'Valet':
            header("Location: /ValetParking/Vehiculos/VisualizarVehiculos/AgregarVehiculos.php", TRUE, 301);
            exit();
        break;
        case 'Recepcion':
            header("Location: /Recepcion/Reservacion/ConsultarReservaciones/ConsultaReservaciones.php", TRUE, 301);
            exit();
        break;
        case 'Limpieza':
            header("Location: /Recepcion/Reservacion/ConsultarReservaciones/ConsultaReservaciones.php", TRUE, 301);
            exit();
        break;
        case 'Servicio':
            header("Location: /Servicio/ConsultarServicios/VisualizarPedidos/GestionarPedidos.php", TRUE, 301);
            exit();
        break;
        default:
            # ValetParking/Vehiculos/GestionarVehiculos/GestionVehiculos.php
            break;
    }
}
else {
    # code...
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buhitel</title>
    <link rel="shortcut icon" href="PaginaPrincipal/assets/LogoBT.png">
    <link rel="stylesheet" href="PaginaPrincipal/design/stylesP.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <!-- NAVEGACION -->
    <nav>
        <div class="logo">
            <img class="img_logo" src="PaginaPrincipal/assets/LogoT.png" alt="Logo">
        </div>
        <ul class="links_nav"> 
            <li> <a href="">Inicio</a></li>
            <li> <a href="">Acerca De</a></li>
            <li> <a href="#TarsServicios">Funcionalidades</a></li>
            <li> <a href="PaginaPrincipal/Registro.php">Registrar</a></li>
            <li> <a href="PaginaPrincipal/InicioSesion.php">Ingresar</a></li>
        </ul>
    </nav>
    <!-- /NAVEGACION -->
    <hr>
    <br>
    <!-- /INICIO -->
    <section class="contenedor PrimerContenedor">
        <div class="inicio_content">

            <h1 class="Texto TituloInicio">Un sistema de administración de servicios hoteleros</h1>
            
            <br>
            <div class="Texto">
                <p>Buhitel es la opción para gestionar los servicios 
                    de tu hotel si tu objetivo es que la 
                    experiencia del huésped sea lo más agradable posible, 
                    mediante un sistema que integra todos
                    los elementos a solicitar y poder satisfacer las 
                    necesidades de la forma más rápida y eficiente
                    posible.</p>
            </div>
            <br>
            
            
        </div>
        <aside class="inicio_foto">
            <img class="Transparente" src="PaginaPrincipal/assets/Fotos/Foto_inicio.jpg" alt="Hotel">
        </aside>
    </section>
    <!-- /INICIO -->
    <br>
    <br>
    <!-- ACERCA DE -->
    <section class="contenedor">
        <aside class="acerca_foto">
            <img class="Transparente" src="PaginaPrincipal/assets/Fotos/Foto_Acerca.jpg" alt="Habitación">
        </aside>
        <div class="inicio_content">
            <h1 class="Texto TituloInicio Centrado" id="Grande">Acerca De</h1>
            <br>
            <br>
            <div class="Texto">
                <p>Buhitel es un sistema que permite al administrador
                    contar con información de la más alta relevancia de su 
                    hotel, permite al personal usar una herramienta para su 
                    trabajo del día a día y al huésped experimentar una estadía
                    con la mejor de las atenciones.
                </p>
            </div>
        </div>
    </section>
    <!-- /ACERCA DE -->
    <br>
    <br>
    <!-- FUNCIONALIDADES -->
    <div class="titulo_Funcionalidades">
        <h1 class="Texto TituloInicio Centrado" id="Grande">Funcionalidades</h1>
    </div>
    <br>
    <br>
    <br>
    
    <!-- PRIMERA FILA -->
    <!-- PRIMERA TARJETA -->
    <section class="contenedor Funcs">
        <div class="Tarjeta" id="Gerencia">
            <h1>Gerencia</h1>
            <div class="Info">
                
                <p>La gerencia podrá consultar información estadística de su hotel basado en el procesamiento de los
                    datos generados en el sistema, así como manejar los asuntos que le competen como los servicios y la
                    configuración del personal y el hotel.
                </p>
            </div>
        </div>
        <!-- PRIMERA TARJETA -->

        <!-- SEGUNDA TARJETA -->
        <div class="Tarjeta" id="Recepcion">
            <h1>Recepción</h1>
            <div class="Info">
                
                <p>El personal de recepción podrá crear, editar y consultar las reservaciones en interfaces dinámicas e 
                    intuitivas, solicitar y manejar los servicios solicitados a las habitaciones ocupadas y editar montos
                    y conceptos cargados a las reservaciones.
                </p>
            </div>
        </div>
        <!-- SEGUNDA TARJETA -->
    </section>
    <!-- PRIMERA FILA -->
    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- SEGUNDA FILA -->
    <!-- TERCERA TARJETA -->
    <section class="contenedor Funcs" id="TarsServicios">
        <div class="Tarjeta" id="Limpieza">
            <h1>Limpieza</h1>
            <div class="Info">
                
                <p>Para el personal de limpieza existirá un manejo automático en la asignación de las limpiezas solicitadas, 
                    que equilibre la carga de trabajo de manera equitativa y poder registrar su trabajo en el sistema para
                    una mejor administración.
                </p>
            </div>
        </div>
        <!-- TERCERA TARJETA -->

        <!-- CUARTA TARJETA -->
        <div class="Tarjeta" id="Servicio">
            <h1>Servicio</h1>
            <div class="Info">
                
                <p>Para el personal encargado del servicio a la habitación, se contará con interfaces dinámicas 
                    que permiten una gestión de los pedidos solicitados más eficiente y un manejo de los servicios y
                    productos que se ofrecen.
                </p>
            </div>
        </div>
        <!-- CUARTA TARJETA -->
    </section>
    <!-- SEGUNDA FILA -->
    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- TERCERA FILA -->
    <!-- QUINTA TARJETA -->
    <section class="contenedor Funcs">
        <div class="Tarjeta" id="Valet">
            <h1>Valet</h1>
            <div class="Info">
                
                <p>El personal de valet verá facilitado su trabajo al contar con un sistema que le permita registrar 
                    y consultar los vehículos según lo requiera, desplegando los contextuales al momento que requiere
                    así como los servicios solicitados.
                </p>
            </div>
        </div>
        <!-- QUINTA TARJETA -->

        <!-- SEXTA TARJETA -->
        <div class="Tarjeta" id="Huesped">
            <h1>Huésped</h1>
            <div class="Info">
                
                <p>Quién se hospede en un hotel con Buhitel, contará con una experiencia de interacción única, 
                    a través de un chatbot de WhatsApp sin necesidad de descargar ninguna aplicación para pedir
                    los servicios que el hotel ofrezca.
                </p>
            </div>
        </div>
        <!-- SEXTA TARJETA -->
    </section>
    <!-- TERCERA FILA -->
    <!-- /FUNCIONALIDADES -->
    <br>
    <br>
    <!-- FOOTER -->
    <footer>
        <div class="logo">
            <img class="img_Logo_Footer" src="PaginaPrincipal/assets/LogoInvertidoT.png" alt="Logo">
        </div>
        <div class="Segmento_footer">
            <h2 class="Correos">Contacto: a18100071@ceti.mx / a18100084@ceti.mx</h2>
        </div>
        
    </footer>
    <!-- /FOOTER -->
    
</body>
</html>