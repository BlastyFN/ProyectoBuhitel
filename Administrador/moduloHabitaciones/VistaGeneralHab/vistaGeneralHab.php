<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link rel="stylesheet" href="vistaGeneralHab.css">
    <link rel="stylesheet" href="../../recursos/OwlCarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="../../recursos/OwlCarousel/owl.theme.default.min.css">
    <title>Nuevo tipo de habitacion</title>
</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <h1 >
        Estas son las habitaciones de tu hotel
    </h1>
    <section class="search">
        <input type="text" class="searchElement" placeholder="busca habitaciones, tipos de habitaciones..." id="">
        <button class="searchButton">Buscar</button>
    </section>

    
    <div id="divMenu">
            <span>⋮</span>
                    <ul>

                        <li><a href="../NuevoTipoHab/nuevoTipoHab.php">Añadir nuevo tipo de habitacion</a></li>

                        <li><a href="../ModificacionTipoHab/modificacionTipoHab.php">Modificar tipo de habitación</a></li>

                        <li><a href="../modificarPisosYHabs/modificarPisosYHabs.php">Modificar pisos y habitaciones</a></li>
                    </ul>
     </div>
     
    <div class="vistaHabs">
           
    </div>

    <div class="overlay">
        <div class="popup">
            <a href="#" id="cerrarPopup" class="cerrarPopup">
                x
            </a>
            <h4 class="nombreHab">Habitación 101</h4>
            Tipo de habitación <select name="tipoHabs" id="opcDesplegable" class="popupContent">

                
            </select>
            <h5 class="precioNoche popupContent">Precio por noche: $2</h5>
            <h5 class="numCamas popupContent">Número de camas: 1</h5>
            <h5 class="limpiezaNormal popupContent ">Tiempo de limpieza normal: 2 horas</h5>
            <h5 class="limpiezaProfunda popupContent ">Tiempo de limpieza profunda: 2 horas</h5> 
            <button class="desactivar">Desactivar</button>
            <button class="guardar">Guardar</button>
        </div>
    </div>


    <script src="../../recursos/OwlCarousel/jquery.min.js"></script>
    <script src="../../recursos/OwlCarousel/owl.carousel.min.js"></script>
    <script src="owlCarousel.js"></script>
    <script src="vistaGeneralHab.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
  

</body>
</html>