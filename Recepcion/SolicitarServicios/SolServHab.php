<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/styleServicios.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <title>Solicitar Servicio a la Habitación</title>
</head>
<body>
    <h2 class="alinearTexto">Servicio a la Habitación</h2>
     <!-- Contenedor global -->
    <section class="contenedor">
        <!-- Mitad Izquierda -->
        <section class="Mitad">
            <br><br><br>
            
        <form action="" method="post">
            <input type="text" name="" id="" placeholder="Habitación" class="CamposCentrados">
            <br><br>
            <!-- Contenedor Datos Extensbles-->
        <div class="CamposExtensibles">
            <div class="Disposicion">
            <h1 class="">Categoría</h1>
            <h1>Elemento</h1>
            <h1>Cant</h1>
            
            </div>
            
            <br>
            <!-- Campos de tipos-->
            <section id="ContenedorEntradas" class="">
                <div class="Entradas">
                    <select placeholder="Categoria" class="EntradaTexto Campo30" name="Categoria1" id="Categoria1">
                        <option value="1" class="CatOriginal">Comida</option>
                        <option value="2" class="CatOriginal">Desayuno</option>
                        <option value="3" class="CatOriginal">Cena</option>
                    </select>
                    <select placeholder="Elemento" class="EntradaTexto Campo30" name="Elemento1" id="Elemento1">
                        <option value="1" class="EleOriginal">Hamburguesa</option>
                        <option value="2" class="EleOriginal">Pizza</option>
                        <option value="3" class="EleOriginal">Pastel</option>
                    </select>
                    <input type="number" name="CampoCantidad1" class="EntradaTexto Campo10" value="1" min="1">
                    <h1>$0</h1>
                    <br>
                </div>
            </section>
            <button class="Naranja Completo ModelBtn" id="addImput">AÑADIR</button>
            
        </div>
            <br><br>
            <button type="submit" class="Naranja CamposCentrados ModelBtn">Verificar</button>
        </form>
        </section>
        <!-- Mitad Izquierda -->
        <!-- Mitad Derecha -->
        <section class="Mitad">
        <br><br><br>
        <div class="Tarjeta Azul" id="Gerencia">
            <h1 class="Info">9</h1>
            <div class="Info">
                
                <p> Marcelo</p>
                <p> Ebrard Casaubón</p>
                <p> 5 Elementos</p>
                <p> Precio Total = $412</p>
                
                
            </div>
                <button class="Verde ModelBtn Ult"> Completar</button>
        </section>
        <!-- Mitad Derecha -->
    </section>
    <!-- Contenedor global -->
    
</body>
<script src= "JSSolServHab.js"></script>
</html>