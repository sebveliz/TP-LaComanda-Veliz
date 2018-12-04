<?php

require_once 'pedidos.php';
require_once 'mesas.php';
require_once 'empleados.php';
require_once 'carta.php';

class pedidosApi extends pedidos
{

    public function CargarUno($request, $response, $args)
    {
        $body = json_decode(json_encode($request->getParsedBody()));
        $res = new stdClass();
        $resNro = 500;
        if (isset($body->cliente, $body->mesa, $body->pedido)) //el pedido viene array json
        {
            $idMesa = mesas::TraerIdDesocupado($body->mesa);
            if($idMesa != null)
            {
                $pedido = json_decode($body->pedido, true);
                $mens = "";
                $esValido = $this->validoCodigos($pedido, $mens);

                if($esValido)
                {
                    $todoElPedido = array();

                    $key = pedidos::generarCodigo(5);
                    $titulo = $body->mesa .'_'.$key ;
                    $fotoMens = "";
                    $this->guardarArchivoSubido($request,$titulo,$fotoMens);
                    foreach ($pedido as $articulo)
                    {
                        $miPedido = new pedidos();
                        $miPedido->codigo = $key;
                        $miPedido->mesa = $body->mesa;
                        $miPedido->idArticulo = $articulo['id'];
                        //$miPedido->idEmpleado 
                        $miPedido->cliente = $body->cliente;
                        $miPedido->cantidad = $articulo['cantidad'];
                        $miPedido->importe  = carta::obtenerPrecio($articulo['id']);
                        
                        
                        
                        $miPedido->foto = $fotoMens;
                        $miPedido->estado = "pendiente";
                        //$miPedido->estimado;
                        $miPedido->horaInicio = date("Y-m-d H:i:s");
                        //$miPedido->horaFin;
                        
                        $id =$miPedido->InsertarUno();
                        $miPedido->id = $id;
                        
                        if($id)
                        {
                            $miPedido->$id = $id;
                            array_push($todoElPedido, $miPedido);                        
                        }
                        else
                        {
                            $res->error = "Error al insertar el pedido";
                            break;
                        }
                    }
                    $res->mensaje = "Pedido dado de alta";
                    $res->codigo = $key;
                    $res->pedido = $todoElPedido;

                    $mesa = new mesas();
                    $mesa->id = $idMesa;
                    $mesa->estado = "con cliente esperando pedido";
                    $mesa->codigo = $body->mesa;
                    $mesa->ModificarEstado();


                    $resNro = 200;
                }
                else
                    $res->error = "El pedido informado tiene items no validos";
            }
            else
                $res->error = "Debe informar una mesa válida o desocupada";
                        
        }
        
        return $response->withJson($res,$resNro);
    }

    public function validoCodigos($pedido,$mens)
    {
        //var_dump($pedido);
        foreach($pedido as $articulo)
        {
            $mens = "Articulo ".$articulo['id']." no pertenece a la carta";
            if(!carta::verificarArticulo($articulo['id']))
                return false;
        }
        $mens = "";
        return true;
    }

    public function guardarArchivoSubido($request,$titulo,&$dir)
    {
        $archivos = $request->getUploadedFiles();
        $destino="./fotos/";
        // $res->variableArchivo = json_decode(json_encode($archivos));
        // $res->rutaDestino = "";       

        if(isset($archivos['foto']))
        {
            $idAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $idAnterior)  ;
            $extension=array_reverse($extension);
            $archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
            $dir = $destino.$titulo.".".$extension[0];
        } 
    }




    public function ModificarUno($request, $response, $args)
    {
        $arrayConToken = $request->getHeader('token');
        $token = $arrayConToken[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);

        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;

        $objDelaRespuesta = new stdclass();
        $body = json_decode(json_encode($request->getParsedBody()));

        if (isset($body->codigo)) 
        {
            $id = $body->codigo;

            if ($nuevoUser->tipo == "bartender" || $nuevoUser->tipo == "cerveceros" || $nuevoUser->tipo == "cocineros") 
            {      
                if (pedidos::ConsultarTipo($codigo, $nuevoUser->tipo)) 
                {
                    $miPedido = new pedidos();
                    $miPedido->estado = "listo para servir";
                    $miPedido->id = $id;
                    $miPedido->idEmpleado = $nuevoUser->id;
                    $miPedido->horaFin = date("Y-m-d H:i:s");

                    if ($miPedido->PedidoTerminado()) {

                        $respuesta = "El pedido se modifico correctamente";
                    } else {
                        $respuesta = "Error al cambiar el pedido";
                    }

                } else {
                    $respuesta = "El pedido no se  puede cambiar";
                }
   

            } elseif ($nuevoUser->tipo == "mozos") 
            {

                $miPedido = new pedidos();
                $miPedido->estado = "entregado";
                $miPedido->id = $id;
                $miPedido->idEmpleado = $nuevoUser->id;
                if (pedidos::ConsultarEstado($id, "listo para servir")) 
                {

                    if ($miPedido->PedidoEntregado()) 
                    {
                        $pedido = pedidos::TraerId($id);
                        mesas::ModificarMesa($pedido->mesa, "con clientes comiendo");
                        $respuesta = "El pedido se entrego correctamente";
                    } else {
                        $respuesta = "Error al cambiar el pedido";
                    }

                } else 
                {
                    $respuesta = "El pedido no esta listo";
                }

            }

            $objDelaRespuesta->resultado = $respuesta;

        } else {
            $objDelaRespuesta->resultado = "Faltan Parametros";
        }

        return $response->withJson($objDelaRespuesta, 200);

    }


    public function TraerTodos($request, $response, $args)
    {

        $arrayConToken = $request->getHeader('token');
        $token = $arrayConToken[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);

        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;
        if ($nuevoUser->tipo == "socios" || $nuevoUser->tipo == "mozos") 
        {
            $fecha = date("Y-m-d");
            $pedidos = pedidos::obtenerTodos($fecha);
        } 
        else 
        {
            $fecha = date("Y-m-d");
            $pedidos = pedidos::TraerPedidosSector($nuevoUser->tipo, $fecha);
        }

        return $response->withJson($pedidos,200);

    }


    public function TraerUno($request, $response, $args)
    {

        $id = $args['id'];
        $elPedido = pedidos::TraerId($id);

        $newResponse = $response->withJson($elPedido, 200);
        return $newResponse;
    }


    public function BorrarUno($request, $response, $args)
    {

        $token = $request->getHeader('token')[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);

        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;

        $body = json_decode(json_encode($request->getParsedBody()));
        $id = $body->id;

        $miPedido = new pedidos();
        $miPedido->estado = "cancelado";
        $miPedido->id = $id;
        $miPedido->idEmpleado = $nuevoUser->id;

        if ($miPedido->PedidoCancelado()) {
            $respuesta = "El pedido se cancelo correctamente";

        } else {
            $respuesta = "Error al cancelar el pedido";
        }

        $objDelaRespuesta = new stdclass();
        $objDelaRespuesta->resultado = $respuesta;
        $newResponse = $response->withJson($objDelaRespuesta, 200);

        return $newResponse;
    }

///Consulto el tiempo que falta para el pedido

public function tiempoPedido($request, $response, $args)
{
    $body = json_decode(json_encode($request->getParsedBody()));
    $resNro = 500;
    $res = new stdClass();
    if (isset($body->codigoPedido, $body->codigoMesa)) 
    {
        $minutos = pedidos::CalcularTiempo($body->codigoPedido, $body->codigoMesa);
        $res->mensaje = "Al pedido $body->codigoPedido le faltan " . $minutos . " minutos";
        $resNro = 200;
    } 
    else 
    {
        $res->error = "Faltan Parametros";
    }
    
    return $response->withJson($res,$resNro);
}

    public function facturadoEntreFechas($request, $response, $args)
    {
        $res = new stdClass();
        $resNro = 500;
        $token = $request->getHeader('token')[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);
        $body = json_decode(json_encode($request->getParsedBody()));
        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;
        
        if ($nuevoUser->tipo == "socios" ) 
        {
            if(isset($body->fechaYHoraInicio,$body->fechaYHoraFin))
            {
                $res->fechaYHora->desde = $body->fechaYHoraInicio;
                $res->fechaYHora->hasta = $body->fechaYHoraFin;
                $facturado = pedidos::obtenerFacturadoEntreFechas($body->fechaYHoraInicio,$body->fechaYHoraFin);
                $res->total = $facturado->total;
            } 
            else 
            {
                $res->error = "Faltan parametros";
            }
        }
        else
            $res->error = "Solo los socios pueden visualizar este reporte.";
        return $response->withJson($res,200);
    }

    public function atenderPedido($request, $response, $args)
    {
        //recibo la mesa, el codigo y el idArticulo
        $body = json_decode(json_encode($request->getParsedBody()));
        $resNro = 500;
        $token = $request->getHeader('token')[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);

        $res = new stdClass();
        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;
        //var_dump($nuevoUser->id);
        $nuevoPedido = new pedidos();
         
        if(isset($body->codigo, $body->articulo)){
            $miPedido = pedidos::TraerPedido($body->codigo, $body->articulo);
            if ($miPedido==null){
                $res->error = "No existe pedido y/o articulo";
            }           
            elseif ($miPedido->estado == 'pendiente') {
                if (isset($body->estimado)) {
                    # code...
                    # code...
                    $nuevoPedido->codigo = $body->codigo;
                    //$nuevoPedido->idMesa = mesas::TraerId($body->codigo);
                    $nuevoPedido->idArticulo = $body->articulo;
                    
                    $nuevoPedido->id = $miPedido->id;
                    $nuevoPedido->estado = 'en preparacion';
                    $nuevoPedido->estimado = $body->estimado;
                    $nuevoPedido->idEmpleado = $nuevoUser->id;
                    $nuevoPedido->TomarPedido();
                    
                    $res->resultado = "Pedido atendido correctamente";
                }
                else{
                    $res->error = "Falta indicar tiempo estimado";

                }
            }elseif($miPedido->estado == 'en preparacion') {
                # code...
                $nuevoPedido->codigo = $body->codigo;
                //$nuevoPedido->idMesa = mesas::TraerId($body->codigo);
                $nuevoPedido->idArticulo = $body->articulo;
                $nuevoPedido->id = $miPedido->id;
                $nuevoPedido->estado = 'listo para servir';
                $nuevoPedido->horaFin = date("Y-m-d H:i:s");
                $nuevoPedido->idEmpleado = $nuevoUser->id;
                $nuevoPedido->PedidoTerminado();
                 
                $res->resultado = "Pedido atendido correctamente";
            }else{
                $res->error = "Pedido con estado incorrecto";

            }

        }
        else{
            $res->error = "Faltan informar parametros";
        }

            return $response->withJson($res,200);

    }

    public function entregarPedido($request, $response, $args)
    {
        //recibo la mesa, el codigo y el idArticulo
        $body = json_decode(json_encode($request->getParsedBody()));
        $resNro = 500;
        $token = $request->getHeader('token')[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);

        $res = new stdClass();
        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;
        //var_dump($nuevoUser->id);
        $nuevoPedido = new pedidos();
         
        if(isset($body->codigo)){
            $miPedidoCompleto = pedidos::TraerPedidoCompleto($body->codigo);
            
            for ($i=0; $i < count($miPedidoCompleto) ; $i++) { 
                # code...
                if ($miPedidoCompleto[$i]['estado']!='listo para servir'){
                    
                    $res->error = "El pedido todavia se encuentra en preparacion";
                    break;
                }
            }
            
            if (!isset($res->error)) {
                $nuevoPedido->codigo = $body->codigo;
                //$nuevoPedido->idArticulo = $body->articulo;
                //$nuevoPedido->id = $miPedido->id;
                $nuevoPedido->estado = 'entregado';
                $nuevoPedido->idEmpleado = $nuevoUser->id;
                $nuevoPedido->PedidoEntregado();
                
                $mimesa = new mesas();
                $mimesa->codigo = $miPedidoCompleto[0]['mesa'];
                $mimesa->estado = 'con clientes comiendo';
                $mimesa->Modificarestado();

                $res->resultado = "Pedido entregado correctamente";
            }

        }
        else{
            $res->error = "Faltan informar parametros";
        }

            return $response->withJson($res,200);

    }

}


?>