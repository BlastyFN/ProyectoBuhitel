<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
    }

	function obtenerInfoGeneralServicio($hotel, $fechaInicio,$fechaFin, $condicionalHabs){
        $sql = $this->con->prepare("SELECT Servicio_PrecioTotal FROM servicio 
        INNER JOIN habitacion ON habitacion.Habitacion_ID = servicio.Servicio_habitacion 
        INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo 
        WHERE (Servicio_Fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."') 
        AND TipoHab_Hotel = '".$hotel."'
        ".$condicionalHabs.";");
    
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['Servicio_PrecioTotal'];      
        }
        return  $resSuma;
    
        
    }

    
	function obtenerEncuestaSalida($hotel,$fechaInicio,$fechaFin,$numPregunta, $condicionalHabs){
        $sql = $this->con->prepare("SELECT Respuesta_NumPregunta, Respuesta_Valor, 
        tipohabitacion.tipohab_nombre, tipohab_hotel FROM respuestasencuesta 
        INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Respuestas_HabReservadas 
        INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion 
        INNER JOIN habitacion ON habitacion.Habitacion_ID = habitacionreservada.HabReservada_Habitacion 
        INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo 
        WHERE reservacion.Reservacion_CheckOut BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
        AND TipoHab_Hotel = '".$hotel."'
        AND Respuesta_NumPregunta = '".$numPregunta."' 
         ".$condicionalHabs.";");
        $sql->execute();
        $res = $sql->fetchall();
        return  $res;
    
        
    }



    function obtenerIngresosPorEstancia($fechaInicio,$fechaFin,$hotel, $condicionalHabs){
        $sql = $this->con->prepare("
        SELECT SUM(tipohabitacion.TipoHab_Precio) as suma FROM `habitacionreservada` 
        INNER JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID 
         INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID 
         INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID 
         WHERE  reservacion.Reservacion_CheckIN BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
         AND reservacion.Reservacion_CheckOut AND tipohabitacion.TipoHab_Hotel = '".$hotel."' 
        ".$condicionalHabs.";");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['suma'];      
        }
        return  $resSuma;
    }

    function obtenerNumeroOcupaciones($fechaInicio,$fechaFin,$hotel, $condicionalHabs){
        $sql = $this->con->prepare("
        SELECT count(*) as suma FROM `habitacionreservada` 
         JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID 
         INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID 
         INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID 
         WHERE  reservacion.Reservacion_CheckIN BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
         AND reservacion.Reservacion_CheckOut AND tipohabitacion.TipoHab_Hotel = '".$hotel."'
          ".$condicionalHabs.";");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['suma'];      
        }
        return  $resSuma;
    }

    function obtenerNumeroDesocupaciones($fechaInicio,$fechaFin,$hotel, $condicionalHabs){
        $sql = $this->con->prepare("
        SELECT count(*) as suma FROM `habitacionreservada` 
         JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID 
         INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID 
         INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID 
         WHERE  reservacion.Reservacion_CheckOUT BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
         AND reservacion.Reservacion_CheckOut AND tipohabitacion.TipoHab_Hotel = '".$hotel."' 
          ".$condicionalHabs.";");;
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['suma'];      
        }
        return  $resSuma;
    }

    function obtenerNumeroLimpiezas($fechaInicio,$fechaFin,$hotel, $condicionalHabs){
        $sql = $this->con->prepare("
        SELECT count(*) as num FROM limpieza
        INNER JOIN habitacion ON limpieza.limpieza_Habitacion = habitacion.Habitacion_ID 
        INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID
        WHERE Limpieza_HoraInicio BETWEEN '".$fechaInicio."' AND '".$fechaFin."' 
        AND tipohabitacion.TipoHab_Hotel = '".$hotel."' 
         ".$condicionalHabs.";");
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

    function obtenerTiempoOcupaciones($hotel,$dias, $condicionalHabs){
        $diasInicio = $dias - 2;
        $sql = $this->con->prepare("SELECT count(habitacionreservada.habreservada_id) as numero FROM habitacionreservada 
        INNER JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID 
        INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID 
        INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID 
        WHERE tipohabitacion.TipoHab_Hotel = '".$hotel."' 
        AND TIMESTAMPDIFF(DAY, Reservacion_CheckIn, Reservacion_CheckOut) < '".$dias."'
        AND TIMESTAMPDIFF(DAY, Reservacion_CheckIn, Reservacion_CheckOut) >=  '".$diasInicio."'
        ".$condicionalHabs.";"
    );
        $sql->execute();
        $res = $sql->fetchall();
		if (count($res) > 0)
		{
			foreach ($res as $dato)
			return $dato['numero'];
		}
        return $res;
    }

    function tiempoRespuestaReportes($hotel,$minutos, $condicionalHabs){
        $minutosInicio = $minutos - 5;
        $sql = $this->con->prepare("SELECT count(reservacion_id) 
        as numero FROM reservacion 
        WHERE tipohabitacion.TipoHab_Hotel = '".$hotel."' 
        AND TIMESTAMPDIFF(MINUTE, reservacion_inicio, reservacion_final) < '".$minutos."'
        AND TIMESTAMPDIFF(MINUTE, reservacion_inicio, reservacion_final) >=  '".$minutosInicio."'
        ".$condicionalHabs.";"
    );
        $sql->execute();
        $res = $sql->fetchall();
		if (count($res) > 0)
		{
			foreach ($res as $dato)
			return $dato['numero'];
		}
        return $res;
    }

    function obtenerTiposHabs($hotel){
		$sql = $this->con->prepare("SELECT tipohab_ID, tipohab_nombre FROM tipohabitacion WHERE
		tipohab_hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;

	}

    function obtenerNombreHotel($hotel){
        $sql = $this->con->prepare("SELECT Hotel_Nombre FROM hotel WHERE
		hotel_ID = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
    }
}
?>