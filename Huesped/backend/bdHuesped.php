<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        public function consultarSesion($Numero, $Hoy){
            $sql = $this->con->prepare("SELECT hotel.Hotel_Nombre, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, habitacion.Habitacion_Nombre, habitacion.Habitacion_ID FROM habitacionreservada
            INNER JOIN habitacion ON habitacion.Habitacion_ID = HabReservada_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            INNER JOIN hotel ON hotel.Hotel_ID = tipohabitacion.TipoHab_Hotel
            WHERE BINARY habitacionreservada.HabReservada_NumWhatsapp = '".$Numero."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarFecha($Habitacion, $Hoy){
            $sql = $this->con->prepare("SELECT reservacion.Reservacion_CheckOut, HabReservada_ID FROM habitacionreservada
            INNER JOIN habitacion ON habitacion.Habitacion_ID = HabReservada_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            WHERE BINARY HabReservada_Habitacion = '".$Habitacion."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarCodigo($codigo){
            $sql = $this->con->prepare("SELECT habitacion.Habitacion_Nombre, hotel.Hotel_Nombre, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, HabReservada_ID FROM habitacionreservada
            INNER JOIN habitacion ON habitacion.Habitacion_ID = habitacionreservada.HabReservada_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            INNER JOIN hotel ON hotel.Hotel_ID = tipohabitacion.TipoHab_Hotel
            WHERE HabReservada_CodigoWhatsapp = '".$codigo."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        
        public function registrarNumero($Numero, $Habitacion){
            $sql = $this->con->prepare("UPDATE habitacionreservada SET HabReservada_NumWhatsapp = '".$Numero."'
            WHERE BINARY HabReservada_ID = '".$Habitacion."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        public function consultarVehiculo($Hoy, $Habitacion){
            $sql = $this->con->prepare("SELECT Vehiculo_Placas, Vehiculo_Modelo, Vehiculo_Estatus, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, huesped.Huesped_Contacto
            FROM vehiculo
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Vehiculo_Habitacion
            INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID
            INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID
            INNER JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            WHERE BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            AND BINARY habitacion.Habitacion_ID = '".$Habitacion."'
            ");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function solicitudVehiculo($Placas, $Estatus){
            $sql = $this->con->prepare("UPDATE `vehiculo` SET 
            Vehiculo_Estatus= '".$Estatus."'
             WHERE Vehiculo_Placas = '".$Placas."'");
            $sql->execute();
            return true;
        }

        public function verificarOcupacion($Habitacion, $Fecha){
            $sql = $this->con->prepare("SELECT tipohabitacion.TipoHab_TiempoLimpNormal, tipohabitacion.TipoHab_Hotel FROM habitacion 
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = Habitacion_Tipo
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Habitacion = Habitacion_ID
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            WHERE BINARY Habitacion_ID = '".$Habitacion."'
            AND BINARY '".$Fecha."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        public function consultarPersonal($HInicio, $HFin, $Hotel){
            $sql = $this->con->prepare("SELECT Personal_Nombre, Personal_APaterno, Personal_AMaterno, Personal_ID, infousuariolimpieza.InfoLimpieza_InicioDescanso, infousuariolimpieza.InfoLimpieza_FinDescanso FROM personal
            INNER JOIN infousuariolimpieza ON infousuariolimpieza.InfoLimpieza_Personal = Personal_ID
            WHERE BINARY '".$HInicio."' BETWEEN infousuariolimpieza.InfoLimpieza_InicioJornada AND infousuariolimpieza.InfoLimpieza_FinJornada
            AND BINARY '".$HFin."' BETWEEN infousuariolimpieza.InfoLimpieza_InicioJornada AND infousuariolimpieza.InfoLimpieza_FinJornada
            AND BINARY infousuariolimpieza.InfoLimpieza_InicioDescanso NOT BETWEEN '".$HInicio."' AND '".$HFin."'
            AND BINARY infousuariolimpieza.InfoLimpieza_FinDescanso NOT BETWEEN '".$HInicio."' AND '".$HFin."'
            AND BINARY '".$HInicio."' NOT BETWEEN infousuariolimpieza.InfoLimpieza_InicioDescanso AND infousuariolimpieza.InfoLimpieza_FinDescanso
            AND BINARY '".$HFin."' NOT BETWEEN infousuariolimpieza.InfoLimpieza_InicioDescanso AND infousuariolimpieza.InfoLimpieza_FinDescanso
            AND BINARY Personal_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarLimpiezasPersonal($Personal, $Dia, $Hotel){

            $sql = $this->con->prepare("SELECT Limpieza_HoraInicio, Limpieza_HoraFin FROM limpieza
            INNER JOIN personal ON personal.Personal_ID = Limpieza_Usuario
            INNER JOIN infousuariolimpieza ON infousuariolimpieza.InfoLimpieza_Personal = personal.Personal_ID
            WHERE BINARY Limpieza_HoraInicio BETWEEN '".$Dia." 00:00' AND '".$Dia." 23:59'
            AND BINARY personal.Personal_ID = '".$Personal."'
            AND BINARY personal.Personal_Hotel = '".$Hotel."';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        public function consultarDisponbilidad($Personal, $Inicio, $Final){

            $sql = $this->con->prepare("SELECT Limpieza_ID, habitacion.Habitacion_Nombre FROM limpieza
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Limpieza_Habitacion
            WHERE BINARY Limpieza_Usuario = '".$Personal."' 
            AND BINARY 
            ('".$Inicio."' BETWEEN Limpieza_HoraInicio AND Limpieza_HoraFin
             OR '".$Final."' BETWEEN Limpieza_HoraInicio AND Limpieza_HoraFin
             OR Limpieza_HoraInicio BETWEEN '".$Inicio."' AND '".$Final."'
             OR Limpieza_HoraFin BETWEEN '".$Inicio."' AND '".$Final."'
            );");
            $sql->execute();
            $res = $sql->fetchall();
            $disponibilidad = "Disponible";
            if (isset($res[0])) {
                $disponibilidad = "Ocupado";
            }
            return $disponibilidad;
        }

        public function registrarLimpieza($Habitacion, $Usuario, $Inicio, $Fin, $Tipo){
            $sql = $this->con->prepare("INSERT INTO limpieza(Limpieza_Habitacion, Limpieza_Usuario, Limpieza_HoraInicio, Limpieza_HoraFin, Limpieza_Tipo) 
            VALUES ('".$Habitacion."','".$Usuario."','".$Inicio."','".$Fin."','".$Tipo."')");
            $sql->execute();
            $sql = $this->con->prepare("SELECT Limpieza_ID FROM limpieza 
            WHERE BINARY Limpieza_Usuario = '".$Usuario."'
            AND BINARY Limpieza_HoraInicio = '".$Inicio."'
            AND BINARY Limpieza_HoraFin = '".$Fin."'");
            $sql->execute();
            $res = $sql->fetchall();
            $ID = $res[0]['Limpieza_ID'];
            return $ID;
        }
        public function consultarHorario($Personal){
            $sql = $this->con->prepare("SELECT InfoLimpieza_InicioJornada, InfoLimpieza_FinJornada, InfoLimpieza_InicioDescanso, InfoLimpieza_FinDescanso from infousuariolimpieza
            WHERE InfoLimpieza_Personal = '".$Personal."';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res[0];
        }
        public function consultarLimpiezasPeriodo($Hotel, $Inicio, $Fin){
            $sql = $this->con->prepare("SELECT personal.Personal_ID, Limpieza_HoraInicio, Limpieza_HoraFin FROM limpieza
            INNER JOIN personal ON personal.Personal_ID = `Limpieza_Usuario`
             WHERE BINARY personal.Personal_Hotel = '".$Hotel."' 
             AND BINARY 
             ('".$Inicio."' BETWEEN Limpieza_HoraInicio AND Limpieza_HoraFin
              OR '".$Fin."' BETWEEN Limpieza_HoraInicio AND Limpieza_HoraFin
              OR Limpieza_HoraInicio BETWEEN '".$Inicio."' AND '".$Fin."'
              OR Limpieza_HoraFin BETWEEN '".$Inicio."' AND '".$Fin."'
             );");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarDescansosPeriodo($Hotel, $Inicio, $Fin){
            $sql = $this->con->prepare("SELECT InfoLimpieza_Personal, InfoLimpieza_InicioDescanso, InfoLimpieza_FinDescanso FROM infousuariolimpieza
            INNER JOIN personal ON personal.Personal_ID = InfoLimpieza_Personal
             WHERE BINARY personal.Personal_Hotel = '".$Hotel."' 
             AND BINARY 
             ('".$Inicio."' BETWEEN InfoLimpieza_InicioDescanso AND InfoLimpieza_FinDescanso
              OR '".$Fin."' BETWEEN InfoLimpieza_InicioDescanso AND InfoLimpieza_FinDescanso
              OR InfoLimpieza_InicioDescanso BETWEEN '".$Inicio."' AND '".$Fin."'
              OR InfoLimpieza_FinDescanso BETWEEN '".$Inicio."' AND '".$Fin."'
             );");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarPersonalSinDescansos($Hotel, $Inicio, $Fin){
            $sql = $this->con->prepare("SELECT Personal_ID, Personal_Nombre from personal 
            INNER JOIN infousuariolimpieza ON infousuariolimpieza.InfoLimpieza_Personal = Personal_ID
            WHERE BINARY Personal_Hotel = '".$Hotel."'
            AND BINARY '".$Inicio."' BETWEEN infousuariolimpieza.InfoLimpieza_InicioJornada AND infousuariolimpieza.InfoLimpieza_FinJornada
            AND BINARY '".$Fin."' BETWEEN infousuariolimpieza.InfoLimpieza_InicioJornada AND infousuariolimpieza.InfoLimpieza_FinJornada;");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarHotel($HabID){
            $sql = $this->con->prepare("SELECT tipohabitacion.TipoHab_Hotel FROM habitacion 
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = Habitacion_Tipo
            WHERE BINARY Habitacion_ID = '".$HabID."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res[0]['TipoHab_Hotel'];
        }

        public function consultarCategorias($HID){
            $sql = $this->con->prepare("SELECT CatProd_Categoria, CatProd_ID FROM categoriaproductos
            WHERE BINARY CatProd_Hotel = '".$HID."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarProductos($Categoria){
            $sql = $this->con->prepare("SELECT Producto_Nombre, Producto_Precio, Producto_ID FROM producto 
            WHERE BINARY Producto_Categoria = '".$Categoria."'
            AND BINARY Producto_Existencia = '1'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function crearPedido($Habitacion, $Fecha){
            $sql = $this->con->prepare("INSERT INTO servicio(Servicio_Habitacion, Servicio_Fecha, Servicio_Estatus) 
            VALUES ('".$Habitacion."','".$Fecha."','4')");
            $sql->execute();
            $sql = $this->con->prepare("SELECT Servicio_ID FROM servicio 
            WHERE BINARY Servicio_Habitacion = '".$Habitacion."'
            AND BINARY Servicio_Fecha = '".$Fecha."'");
            $sql->execute();
            $res = $sql->fetchall();
            $ID = $res[0]['Servicio_ID'];
            return $ID;
        }

        public function registrarCarrito($Servicio, $Producto, $Cantidad){
            $sql = $this->con->prepare("INSERT INTO carritoproductos( CarroProd_NumServicio, CarroProd_Producto, CarroProd_NumProductos)
            VALUES ('".$Servicio."','".$Producto."','".$Cantidad."')");
            $sql->execute();
            $sql = $this->con->prepare("SELECT Producto_Precio FROM producto 
            WHERE BINARY Producto_ID = '".$Producto."'");
            $sql->execute();
            $res = $sql->fetchall();
            $Precio = $res[0]['Producto_Precio'];
            $PrecioTotal = $Precio * $Cantidad;
            return $PrecioTotal;
        }
        public function registrarRespuesta($HabRes, $Numero, $Valor){
            $sql = $this->con->prepare("INSERT INTO respuestasencuesta(Respuestas_HabReservadas, Respuesta_NumPregunta, Respuesta_Valor) 
            VALUES ('".$HabRes."','".$Numero."','".$Valor."')");
            $sql->execute();
            return true;
        }

        public function actualizarEstatus($Servicio, $Estatus){
            $sql = $this->con->prepare("UPDATE servicio SET Servicio_Estatus ='".$Estatus."' WHERE Servicio_ID = '".$Servicio."' ");
            $sql->execute();

            return true;
        }

        public function actualizarPrecio($Servicio, $Precio){
            $sql = $this->con->prepare("SELECT Servicio_PrecioTotal FROM servicio 
            WHERE BINARY Servicio_ID = '".$Servicio."'");
            $sql->execute();
            $res = $sql->fetchall();
            $PrecioAntiguo = $res[0]['Servicio_PrecioTotal'];
            $NuevoPrecio = $PrecioAntiguo + $Precio;
            $sql = $this->con->prepare("UPDATE servicio SET Servicio_PrecioTotal ='".$NuevoPrecio."' WHERE Servicio_ID = '".$Servicio."' ");
            $sql->execute();

            return true;
        }

        public function consultarLimpiezasPendientes($Hoy, $Habitacion){
            $sql = $this->con->prepare("SELECT Limpieza_ID, Limpieza_Usuario, Limpieza_HoraInicio, Limpieza_HoraFin FROM limpieza 
            WHERE BINARY Limpieza_Habitacion = '".$Habitacion."'
            AND BINARY Limpieza_HoraInicio > '".$Hoy."'
            AND BINARY '".$Hoy."' NOT BETWEEN Limpieza_HoraInicio AND Limpieza_HoraFin
            AND BINARY Limpieza_Tipo = 'Normal'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarLimpiezasEnCurso($Hoy, $Habitacion){
            $sql = $this->con->prepare("SELECT Limpieza_ID, Limpieza_Usuario, Limpieza_HoraInicio, Limpieza_HoraFin FROM limpieza 
            WHERE BINARY Limpieza_Habitacion = '".$Habitacion."'
            AND BINARY '".$Hoy."' BETWEEN Limpieza_HoraInicio AND Limpieza_HoraFin
            AND BINARY Limpieza_Tipo = 'Normal'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function cancelarLimpieza($Limpieza){
            $sql = $this->con->prepare("DELETE FROM limpieza WHERE Limpieza_ID = '".$Limpieza."'");
            $sql->execute();
            return true;
        }

        public function consultarServicios($Hoy, $Habitacion, $Estatus){
            $sql = $this->con->prepare("SELECT Servicio_ID, Servicio_Fecha, Servicio_PrecioTotal FROM servicio 
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Habitacion = Servicio_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            WHERE BINARY Servicio_Habitacion = '".$Habitacion."'
            AND BINARY Servicio_Estatus = '".$Estatus."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarProductosServicio($Servicio){
            $sql = $this->con->prepare("SELECT producto.Producto_Nombre, CarroProd_NumProductos FROM carritoproductos 
            INNER JOIN producto ON producto.Producto_ID = CarroProd_Producto
            WHERE BINARY CarroProd_NumServicio = '".$Servicio."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function cancelarServicio($Servicio){
            $sql = $this->con->prepare("DELETE FROM carritoproductos WHERE CarroProd_NumServicio = '".$Servicio."'");
            $sql->execute();
            $sql = $this->con->prepare("DELETE FROM servicio WHERE Servicio_ID = '".$Servicio."'");
            $sql->execute();
            
            return true;
        }

        public function consultarCategoriasReportes($HID){
            $sql = $this->con->prepare("SELECT * FROM categoriareporte
            WHERE BINARY CatReporte_Hotel = '".$HID."'
            AND BINARY CatReporte_Nombre != 'Spam'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarHabReservada($HID, $Hoy){
            $sql = $this->con->prepare("SELECT HabReservada_ID FROM habitacionreservada 
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            WHERE BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            AND BINARY HabReservada_Habitacion = '".$HID."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res[0]['HabReservada_ID'];
        }

        public function crearReporte($Habitacion, $Categoria, $Nombre, $Contenido){
            $sql = $this->con->prepare("INSERT INTO reporte(Reporte_Nombre, Reporte_HabReservadas, Reporte_Categoria, Reporte_Contenido, Reporte_Estatus, Reporte_Servicio) 
            VALUES ('".$Nombre."','".$Habitacion."','".$Categoria."', '".$Contenido."', '1', '1')");
            $sql->execute();
            return true;
        }

        public function consultarReportes($Habitacion, $Hoy){
            $sql = $this->con->prepare("SELECT Reporte_Nombre, estatusreporte.EstatusReporte_Estatus FROM reporte
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Reporte_HabReservadas
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            INNER JOIN habitacion ON habitacion.Habitacion_ID = habitacionreservada.HabReservada_Habitacion
            INNER JOIN categoriareporte ON categoriareporte.CatReporte_ID = Reporte_Categoria
            INNER JOIN estatusreporte ON estatusreporte.EstatusReporte_ID = Reporte_Estatus
            WHERE BINARY habitacion.Habitacion_ID = '".$Habitacion."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            AND BINARY Reporte_Estatus != '6'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function solucionarReporte($Reporte){
            $sql = $this->con->prepare("UPDATE reporte SET Reporte_Estatus = '6'
            WHERE  BINARY Reporte_ID = '".$Reporte."'");
            $sql->execute();
            return true;
        }
        
    }

?>