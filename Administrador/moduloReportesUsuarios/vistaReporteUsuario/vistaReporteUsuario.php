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
    
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-firestore.js"></script>
    
    <script>
       
       const firebaseConfig = {
            apiKey: "AIzaSyBrHawuSKbh1cqGl5rAAldb6JBhnClp6z0",
            authDomain: "chatbuhitel.firebaseapp.com",
            projectId: "chatbuhitel",
            storageBucket: "chatbuhitel.appspot.com",
            messagingSenderId: "483326716419",
            appId: "1:483326716419:web:05f9f5595cc415e3567c36"
        };
        firebase.initializeApp(firebaseConfig);
    </script>


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
            <p class="descripcionReporte">
                Mensaje
            </p>

        </section>

        <section class="eleccionPersonal">
            <div class="listaPersonal">
                <select name="tipoPersonal" id="tipoPersonal" class="formText">
                    <option selected="true" disabled>Tipo de personal</option>
                    <option value="Recepcion">Recepcionista</option>
                    <option value="Limpieza">Personal de limpieza</option>
                    <option value="Valet">Valet parking</option>
                    <option value="Servicio">Personal de servicio</option>
                    
                </select>
                <label class="formTextRadio">
                    <input type="radio" name="color" value=""> Personal1
                </label>
                <br>
                <label class="formTextRadio">
                    <input type="radio" name="color" value=""> Personal2
                </label>
            </div>
        </section>

        <section class="chat" >


            <p class="destinatario">Personal asignado: </p>
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




    <script src="../../../Recursos/clase-menu.js"></script>
    
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="vistaReporteUsuario.js"></script>


</body>
</html>