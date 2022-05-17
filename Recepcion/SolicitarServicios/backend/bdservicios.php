<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        

        public function consultarVehiculo($Hotel, $Hoy, $Habitacion){
            $sql = $this->con->prepare("SELECT Vehiculo_Placas, Vehiculo_Modelo, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, huesped.Huesped_Contacto
            FROM vehiculo
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Vehiculo_Habitacion
            INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID
            INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID
            INNER JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            AND BINARY habitacion.Habitacion_Nombre = '".$Habitacion."'
            ");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function actualizarEstatus($Placas, $Estatus){
            $sql = $this->con->prepare("UPDATE `vehiculo` SET 
            Vehiculo_Estatus= '".$Estatus."'
             WHERE Vehiculo_Placas = '".$Placas."'");
            $sql->execute();
            return 1;
        }

        public function verificarOcupacion($Habitacion, $Fecha, $Hotel){
            $sql = $this->con->prepare("SELECT Habitacion_ID, tipohabitacion.TipoHab_TiempoLimpNormal FROM habitacion 
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = Habitacion_Tipo
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Habitacion = Habitacion_ID
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY Habitacion_Nombre = '".$Habitacion."'
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

        public function consultarHorario($Personal){
            $sql = $this->con->prepare("SELECT InfoLimpieza_InicioJornada, InfoLimpieza_FinJornada, InfoLimpieza_InicioDescanso, InfoLimpieza_FinDescanso from infousuariolimpieza
            WHERE InfoLimpieza_Personal = '".$Personal."';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res[0];
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

        public function cancelarLimpieza($Hotel, $Limpieza){
            $sql = $this->con->prepare("DELETE l FROM limpieza l
            INNER JOIN personal p ON p.Personal_ID = l.Limpieza_Usuario
            WHERE BINARY p.Personal_Hotel = '".$Hotel."'
            AND BINARY l.Limpieza_ID = '".$Limpieza."'");
            $sql->execute();
            return "Cancelada con exito";
        }

        public function consultarOcupacion($Hotel, $Habitacion, $Hoy){
            $sql = $this->con->prepare("SELECT Reservacion_ID, habitacion.Habitacion_ID, habitacion.Habitacion_Nombre, huesped.Huesped_Nombre, huesped.Huesped_Apellidos FROM `reservacion` 
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Reservacion = Reservacion_ID
            INNER JOIN habitacion ON habitacion.Habitacion_ID = habitacionreservada.HabReservada_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            INNER JOIN huesped ON huesped.Huesped_ID = Reservacion_Huesped
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY habitacion.Habitacion_Nombre = '".$Habitacion."'
            AND BINARY '".$Hoy."' BETWEEN Reservacion_CheckIn AND Reservacion_CheckOut;");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarLimpiezas($Hotel, $Habitacion, $Hoy){
            $sql = $this->con->prepare("SELECT Limpieza_ID, Limpieza_HoraInicio, Limpieza_HoraFin, personal.Personal_Nombre, personal.Personal_APaterno, personal.Personal_AMaterno, habitacion.Habitacion_Nombre FROM limpieza
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Limpieza_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            INNER JOIN personal ON personal.Personal_ID = Limpieza_Usuario
            WHERE BINARY Limpieza_Habitacion = '".$Habitacion."'
            AND BINARY Limpieza_HoraFin > '".$Hoy."'
            AND BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarCategorias($Hotel){
            $sql = $this->con->prepare("SELECT CatProd_ID, CatProd_Categoria FROM categoriaproductos WHERE CatProd_Hotel = '".$Hotel."';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarProductos($Hotel, $Categoria){
            $sql = $this->con->prepare("SELECT Producto_ID, Producto_Nombre, Producto_Precio FROM producto
            INNER JOIN categoriaproductos ON categoriaproductos.CatProd_ID = Producto_Categoria
            WHERE BINARY categoriaproductos.CatProd_Hotel= '".$Hotel."'
            AND BINARY Producto_Existencia = '1'
            AND BINARY Producto_Categoria = '".$Categoria."';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function registrarServicio($Habitacion, $Fecha, $Precio){
            $sql = $this->con->prepare("INSERT INTO servicio(Servicio_Habitacion, Servicio_Fecha, Servicio_PrecioTotal, Servicio_Estatus) 
            VALUES ('".$Habitacion."','".$Fecha."','".$Precio."','1')");
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
            
            return 1;
        }

        public function cancelarServicio($Hotel, $Servicio){
            $sql = $this->con->prepare("DELETE FROM carritoproductos WHERE CarroProd_NumServicio = '".$Servicio."'");
            $sql->execute();
            $sql = $this->con->prepare("DELETE FROM servicio WHERE Servicio_ID = '".$Servicio."'");
            $sql->execute();
            
            return "Cancelado";
        }

        public function consultarServicios($Hotel, $Habitacion, $Hoy){
            $sql = $this->con->prepare("SELECT Servicio_ID, Servicio_Fecha, Servicio_PrecioTotal, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, estatusservicio.EstatusServicio_Nombre, habitacion.Habitacion_Nombre FROM servicio 
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Habitacion = Servicio_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Servicio_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            INNER JOIN estatusservicio ON estatusservicio.EstatusServicio_ID = Servicio_Estatus
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY Servicio_Habitacion = '".$Habitacion."'
            AND BINARY Servicio_Fecha > '".$Hoy."'
            AND BINARY Servicio_Fecha BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            AND BINARY Servicio_Estatus = '1';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarInfoServicio($Hotel, $Servicio){
            $sql = $this->con->prepare("SELECT huesped.Huesped_Nombre, huesped.Huesped_Apellidos, Servicio_PrecioTotal, Servicio_Fecha FROM servicio
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Habitacion = Servicio_Habitacion
                        INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
                        INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
                        INNER JOIN habitacion ON habitacion.Habitacion_ID = Servicio_Habitacion
                        INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
                        WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
                        AND BINARY Servicio_ID = '".$Servicio."'
                        AND BINARY Servicio_Fecha BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut;");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarCarritos($Hotel, $Servicio){
            $sql = $this->con->prepare("SELECT CarroProd_Producto, CarroProd_NumProductos, categoriaproductos.CatProd_ID, categoriaproductos.CatProd_Categoria, producto.Producto_Nombre, producto.Producto_Precio FROM carritoproductos
            INNER JOIN producto ON producto.Producto_ID = CarroProd_Producto
            INNER JOIN categoriaproductos ON categoriaproductos.CatProd_ID = producto.Producto_Categoria
            WHERE BINARY categoriaproductos.CatProd_Hotel = '".$Hotel."'
            AND BINARY carritoproductos.CarroProd_NumServicio = '".$Servicio."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function actualizarHabitacion($Hotel, $Habitacion, $Servicio){
            $sql = $this->con->prepare("UPDATE servicio  
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Servicio_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            SET Servicio_Habitacion = '".$Habitacion."'
            WHERE BINARY Servicio_ID = '".$Servicio."'
            AND BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."';");
            $sql->execute();
            //SEGUNDA CONSULTA
            $sql = $this->con->prepare("SELECT huesped.Huesped_Nombre, huesped.Huesped_Apellidos, habitacion.Habitacion_Nombre FROM servicio
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Habitacion = Servicio_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Servicio_Habitacion
            WHERE BINARY Servicio_Habitacion = '".$Habitacion."'
            AND BINARY Servicio_Fecha BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut;");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;

        }

        public function actualizarServicio($Hotel, $Servicio, $Hoy, $Precio){
            $sql = $this->con->prepare("UPDATE servicio 
            INNER JOIN habitacion ON habitacion.Habitacion_ID = servicio.Servicio_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            SET Servicio_Fecha ='".$Hoy."', Servicio_PrecioTotal='".$Precio."' 
            WHERE BINARY Servicio_ID = '".$Servicio."'
            AND BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."';");
            $sql->execute();
            $sql = $this->con->prepare("DELETE c FROM carritoproductos c
            INNER JOIN producto p ON p.Producto_ID =c.CarroProd_Producto
            INNER JOIN categoriaproductos t ON t.CatProd_ID = p.Producto_Categoria
            WHERE BINARY t.CatProd_Hotel = '".$Hotel."'
            AND BINARY c.CarroProd_NumServicio = '".$Servicio."';");
            $sql->execute();
            
            return "Completado";
        }
    }

?>