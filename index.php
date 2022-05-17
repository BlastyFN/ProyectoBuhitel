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
            <li> <a href="">Funcionalidades</a></li>
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
                <p>Buhitel es la opción lorem Lorem ipsum dolor sit 
                    amet, consectetur adipiscing elit, sed do eiusmod 
                    tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam . . .</p>
            </div>
            <br>
            <div class="Boton_Central">
                <button class="Naranja">
                    Acerca de
                </button>
            </div>
            
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
                <p>Buhitel es la opción lorem Lorem ipsum dolor sit 
                    amet, consectetur adipiscing elit, sed do eiusmod 
                    tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam Lorem ipsum dolor sit amet 
                    consectetur adipisicing elit. Pariatur harum minima 
                    ea! . . .</p>
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
                
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia nemo perferendis tempora deserunt repellat neque aliquam praesentium facilis quos, cupiditate, quas culpa porro ipsum impedit fugit exercitationem voluptate fuga assumenda.</p>
            </div>
        </div>
        <!-- PRIMERA TARJETA -->

        <!-- SEGUNDA TARJETA -->
        <div class="Tarjeta" id="Recepcion">
            <h1>Recepción</h1>
            <div class="Info">
                
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia nemo perferendis tempora deserunt repellat neque aliquam praesentium facilis quos, cupiditate, quas culpa porro ipsum impedit fugit exercitationem voluptate fuga assumenda.</p>
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
    <section class="contenedor Funcs">
        <div class="Tarjeta" id="Limpieza">
            <h1>Limpieza</h1>
            <div class="Info">
                
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia nemo perferendis tempora deserunt repellat neque aliquam praesentium facilis quos, cupiditate, quas culpa porro ipsum impedit fugit exercitationem voluptate fuga assumenda.</p>
            </div>
        </div>
        <!-- TERCERA TARJETA -->

        <!-- CUARTA TARJETA -->
        <div class="Tarjeta" id="Servicio">
            <h1>Servicio</h1>
            <div class="Info">
                
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia nemo perferendis tempora deserunt repellat neque aliquam praesentium facilis quos, cupiditate, quas culpa porro ipsum impedit fugit exercitationem voluptate fuga assumenda.</p>
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
                
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia nemo perferendis tempora deserunt repellat neque aliquam praesentium facilis quos, cupiditate, quas culpa porro ipsum impedit fugit exercitationem voluptate fuga assumenda.</p>
            </div>
        </div>
        <!-- QUINTA TARJETA -->

        <!-- SEXTA TARJETA -->
        <div class="Tarjeta" id="Huesped">
            <h1>Huésped</h1>
            <div class="Info">
                
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia nemo perferendis tempora deserunt repellat neque aliquam praesentium facilis quos, cupiditate, quas culpa porro ipsum impedit fugit exercitationem voluptate fuga assumenda.</p>
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