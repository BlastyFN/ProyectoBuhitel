<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host localhost= localhost;dbname=corpo206_buhitel','root','');
	}

	function obtenerInfoGeneralServicio($fechaInicio,$fechaFin){
        $sql = $this->con->prepare("SELECT Servicio_PrecioTotal FROM servicio WHERE BINARY
        (Servicio_Fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."') ");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['Servicio_PrecioTotal'];      
        }
        return  $resSuma;
    
        
    }

    
	function obtenerEncuestaSalida($hotel,$fechaInicio,$fechaFin,$numPregunta){
        $sql = $this->con->prepare("SELECT Respuesta_NumPregunta, Respuesta_Valor, 
        tipohabitacion.tipohab_hotel FROM `respuestasencuesta` 
        INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Respuestas_HabReservadas 
        INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion 
        INNER JOIN habitacion ON habitacion.Habitacion_ID = habitacionreservada.HabReservada_Habitacion 
        INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo 
        WHERE reservacion.Reservacion_CheckOut BETWEEN '".$fechaInicio."' AND '".$fechaFin."' AND TipoHab_Hotel = '".$hotel."';");
        $sql->execute();
        $res = $sql->fetchall();
       

        return  $resSuma;
    
        
    }

    function obtenerIngresosPorEstancia($fechaInicio,$fechaFin,$hotel){
        $sql = $this->con->prepare("
        SELECT SUM(tipohabitacion.TipoHab_Precio) as suma FROM `habitacionreservada` 
         JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID 
         INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID 
         INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID 
         WHERE  reservacion.Reservacion_CheckIN BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
         AND reservacion.Reservacion_CheckOut AND tipohabitacion.TipoHab_Hotel = '".$hotel."';");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['suma'];      
        }
        return  $resSuma;
    }

    function obtenerNumeroOcupaciones($fechaInicio,$fechaFin,$hotel){
        $sql = $this->con->prepare("
        SELECT count(*) as suma FROM `habitacionreservada` 
         JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID 
         INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID 
         INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID 
         WHERE  reservacion.Reservacion_CheckIN BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
         AND reservacion.Reservacion_CheckOut AND tipohabitacion.TipoHab_Hotel = '".$hotel."';");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['suma'];      
        }
        return  $resSuma;
    }

    function obtenerNumeroDesocupaciones($fechaInicio,$fechaFin,$hotel){
        $sql = $this->con->prepare("
        SELECT count(*) as suma FROM `habitacionreservada` 
         JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID 
         INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID 
         INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID 
         WHERE  reservacion.Reservacion_CheckOUT BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
         AND reservacion.Reservacion_CheckOut AND tipohabitacion.TipoHab_Hotel = '".$hotel."';");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['suma'];      
        }
        return  $resSuma;
    }

    function obtenerNumeroLimpiezas($fechaInicio,$fechaFin,$hotel){
        $sql = $this->con->prepare("
        SELECT count(*) as num FROM limpieza
        INNER JOIN habitacion ON limpieza.limpieza_Habitacion = habitacion.Habitacion_ID 
        INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID
        WHERE Limpieza_HoraInicio BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
        AND tipohabitacion.TipoHab_Hotel = '".$hotel."';");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['num'];      
        }
        return  $resSuma;
    }

    function obtenerProductos($hotel){
        $sql = $this->con->prepare("SELECT * FROM `producto` 
        INNER JOIN categoriaproductos ON Producto_Categoria = categoriaproductos.CatProd_ID 
        WHERE Producto_Hotel = '".$hotel."';");
        $sql->execute();
        $res = $sql->fetchall();
        return $res;
    }

    function obtenerTiempoOcupaciones($hotel,$diasInicio,$diasFin){
        $sql = $this->con->prepare("SELECT count(TIMESTAMPDIFF(DAY, Reservacion_CheckIn, Reservacion_CheckOut)) AS dias 
        FROM reservacion 
        INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Reservacion = Reservacion_ID 
        INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID 
        INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID 
        WHERE tipohabitacion.TipoHab_Hotel = '".$hotel."' 
        AND TIMESTAMPDIFF(DAY, Reservacion_CheckIn, Reservacion_CheckOut) > '".$diasInicio."' 
        AND TIMESTAMPDIFF(DAY, Reservacion_CheckIn, Reservacion_CheckOut) <= '".$diasFin."';");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['dias'];      
        }
        return $resSuma;
    }
}
?>