<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once 'clases/accesoDatos.php';
require_once 'clases/empleadosApi.php';
require_once 'clases/mesasApi.php';
require_once 'clases/pedidosApi.php';
require_once 'clases/cartaApi.php';
require_once 'clases/cajaApi.php';
require_once 'clases/encuestaApi.php';
require_once 'clases/MWparaAutentificar.php';
require_once 'clases/excelApi.php';
require_once 'clases/pdfApi.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

//xxxxxxx 
$app->group('/login', function () 
{
    $this->group('',function() 
    {
        $this->get('', \empleadosApi::class . ':traerTodosLosLogs'); //xxx
        $this->get('/{nombre}', \empleadosApi::class . ':ingresoPorEmpleado'); //xxx
        $this->post('/sector', \empleadosApi::class . ':traerLogsPorSector'); //xxx
        $this->post('/empleado', \empleadosApi::class . ':traerLogsPorEmpleado');//xxxx
    })->add(\MWparaAutentificar::class . ':VerificarSocios'); //xxxx

    $this->post('', \empleadosApi::class . ':loguearse'); //usuario y password xxx
});


$app->group('/empleados', function () {
    $this->get('', \empleadosApi::class . ':traerTodos'); //xxxxxxxxx
    $this->post('', \empleadosApi::class . ':CargarUno');//recibe codigo xxxxxx
    $this->post('/del', \empleadosApi::class . ':BorrarUno'); //xxxxxxxxxx
    $this->post('/mod', \empleadosApi::class . ':ModificarUno'); //xxxxxxx
})->add(\MWparaAutentificar::class . ':VerificarSocios');

$app->group('/mesas', function () 
{
    $this->get('', \mesasApi::class . ':traerTodos'); //xxxxxxxxxxx
    $this->get('/{codigo}', \mesasApi::class . ':traerUno'); // REVISAR PARA QUE SIRVE POR ID!!!!
    $this->post('', \mesasApi::class . ':CargarUno'); //xxxxxxxxxxx
    $this->post('/del', \mesasApi::class . ':BorrarUno');//recibe el codigo //xxxxxxxxx
    $this->post('/mod', \mesasApi::class . ':ModificarUno');//recibe el codigo //xxxxxxx

})->add(\MWparaAutentificar::class . ':VerificarMozos');


$app->group('/pedidos', function () 
{
    $this->get('', \pedidosApi::class . ':traerTodos'); //xxxxx
    $this->post('', \pedidosApi::class . ':CargarUno'); //xxxxx
    $this->post('/del', \pedidosApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarMozos'); //xxxx
    $this->post('/mod', \pedidosApi::class . ':ModificarUno');
    $this->post('/atender', \pedidosApi::class . ':atenderPedido'); //xxxxx
    $this->post('/entregar', \pedidosApi::class . ':entregarPedido')->add(\MWparaAutentificar::class . ':VerificarMozos'); //xxxxx
    $this->post('/facturado', \pedidosApi::class . ':facturadoEntreFechas');
})->add(\MWparaAutentificar::class . ':VerificarUsuario');


$app->group('/carta', function () 
{
    $this->get('', \cartaApi::class . ':traerTodos'); //XXXXXXX
    $this->post('', \cartaApi::class . ':CargarUno'); //XXXXXXX
    $this->post('/del', \cartaApi::class . ':BorrarUno'); //XXXXX
    $this->post('/mod', \cartaApi::class . ':ModificarUno'); //XXXXX

})->add(\MWparaAutentificar::class . ':VerificarSocios');

$app->group('/caja', function () 
{
    $this->get('', \cajaApi::class . ':traerTodos'); //xxxxx
    $this->post('', \cajaApi::class . ':CargarUno'); //xxxxx

})->add(\MWparaAutentificar::class . ':VerificarSocios');


$app->group('/cliente', function () 
{
    $this->get('', \cartaApi::class . ':traerTodos'); //xxxxxx
    $this->post('/tiempo', \pedidosApi::class . ':tiempoPedido'); //xxxx
    $this->post('/encuesta', \encuestaApi::class . ':CargarUno');
});

$app->group('/encuesta', function () 
{
  $this->get('', \encuestaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarSocios');
});

$app->group('/export', function () {
    $this->group('/excel',function() {
        $this->get('/login', \excelApi::class . ':GenerarExcelLogin'); 
        $this->get('/empleados', \excelApi::class . ':GenerarExcelEmpleados'); //xxxxxxxxx
        $this->get('/mesas', \excelApi::class . ':GenerarExcelMesas'); 
        $this->get('/pedidos', \excelApi::class . ':GenerarExcelPedidos'); 
        $this->get('/carta', \excelApi::class . ':GenerarExcelCarta'); 
        $this->get('/caja', \excelApi::class . ':GenerarExcelCaja'); 
        $this->get('/encuestas', \excelApi::class . ':GenerarExcelEncuestas'); 
    });
    $this->group('/pdf',function() {
        $this->get('/login', \pdfApi::class . ':GenerarPdfLogin'); 
        $this->get('/empleados', \pdfApi::class . ':GenerarPdfEmpleados'); //xxxxxxxxx
        $this->get('/mesas', \pdfApi::class . ':GenerarPdfMesas'); 
        $this->get('/pedidos', \pdfApi::class . ':GenerarPdfPedidos'); 
        $this->get('/carta', \pdfApi::class . ':GenerarPdfCarta'); 
        $this->get('/caja', \pdfApi::class . ':GenerarPdfCaja'); 
        $this->get('/encuestas', \pdfApi::class . ':GenerarPdfEncuestas'); 
    });
    
})->add(\MWparaAutentificar::class . ':VerificarSocios');

$app->run();

?>