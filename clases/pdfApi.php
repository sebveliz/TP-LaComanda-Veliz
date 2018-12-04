<?php
require_once 'empleados.php';
//require_once 'AutentificadorJWT.php';
//require_once './vendor/pdf/fpdf.php';
require_once 'pdf.php';

class pdfApi extends pdf
{
    public function GenerarPdfLogin($request, $response, $args){
		$seGeneroPdf = pdf::obtenerPdfLogin();
		if (!$seGeneroPdf)
			$newResponse = $response->withJson("No se pudo generar PDF", 400);
		return $newResponse;
	}
	public function GenerarPdfEmpleados($request, $response, $args){
		$seGeneroPdf = pdf::obtenerPdfEmpleados();
		if (!$seGeneroPdf)
			$newResponse = $response->withJson("No se pudo generar PDF", 400);
		return $newResponse;
	}
	public function GenerarPdfMesas($request, $response, $args){
		$seGeneroPdf = pdf::obtenerPdfMesas();
		if (!$seGeneroPdf)
			$newResponse = $response->withJson("No se pudo generar PDF", 400);
		return $newResponse;
	}
	public function GenerarPdfPedidos($request, $response, $args){
		$seGeneroPdf = pdf::obtenerPdfPedidos();
		if (!$seGeneroPdf)
			$newResponse = $response->withJson("No se pudo generar PDF", 400);
		return $newResponse;
	}
	public function GenerarPdfCarta($request, $response, $args){
		$seGeneroPdf = pdf::obtenerPdfCarta();
		if (!$seGeneroPdf)
			$newResponse = $response->withJson("No se pudo generar PDF", 400);
		return $newResponse;
	}
	public function GenerarPdfCaja($request, $response, $args){
		$seGeneroPdf = pdf::obtenerPdfCaja();
		if (!$seGeneroPdf)
			$newResponse = $response->withJson("No se pudo generar PDF", 400);
		return $newResponse;
	}
	public function GenerarPdfEncuestas($request, $response, $args){
		$seGeneroPdf = pdf::obtenerPdfEncuestas();
		if (!$seGeneroPdf)
			$newResponse = $response->withJson("No se pudo generar PDF", 400);
		return $newResponse;
    }
}