<?php
//require_once 'empleados.php';
//require_once 'AutentificadorJWT.php';
require_once 'excel.php';


class excelApi extends excel
{
    public function GenerarExcelLogin($request, $response, $args){
		$seGeneroExcel = excel::obtenerExcelLogin();
		if (!$seGeneroExcel)
			$newResponse = $response->withJson("No se pudo generar excel", 400);
		return $newResponse;
	}
	public function GenerarExcelEmpleados($request, $response, $args){
		$seGeneroExcel = excel::obtenerExcelEmpleados();
		if (!$seGeneroExcel)
			$newResponse = $response->withJson("No se pudo generar excel", 400);
		return $newResponse;
	}
	public function GenerarExcelMesas($request, $response, $args){
		$seGeneroExcel = excel::obtenerExcelMesas();
		if (!$seGeneroExcel)
			$newResponse = $response->withJson("No se pudo generar excel", 400);
		return $newResponse;
	}
	public function GenerarExcelPedidos($request, $response, $args){
		$seGeneroExcel = excel::obtenerExcelPedidos();
		if (!$seGeneroExcel)
			$newResponse = $response->withJson("No se pudo generar excel", 400);
		return $newResponse;
	}
	public function GenerarExcelCarta($request, $response, $args){
		$seGeneroExcel = excel::obtenerExcelCarta();
		if (!$seGeneroExcel)
			$newResponse = $response->withJson("No se pudo generar excel", 400);
		return $newResponse;
	}
	public function GenerarExcelCaja($request, $response, $args){
		$seGeneroExcel = excel::obtenerExcelCaja();
		if (!$seGeneroExcel)
			$newResponse = $response->withJson("No se pudo generar excel", 400);
		return $newResponse;
    }
	public function GenerarExcelEncuestas($request, $response, $args){
		$seGeneroExcel = excel::obtenerExcelEncuestas();
		if (!$seGeneroExcel)
			$newResponse = $response->withJson("No se pudo generar excel", 400);
		return $newResponse;
    }
}