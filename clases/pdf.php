<?php
require_once 'empleados.php';
//require_once 'AutentificadorJWT.php';
require_once './vendor/pdf/fpdf.php';
require_once 'plantillaPdf.php';

class pdf
{
	public function obtenerPdfLogin(){
		try {
			//code...
			$pdf = new PlantillaPdf('L', 'mm', 'legal');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(120,10,'Export de Login', 0, 1, 'L');
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(10,6, 'ID',1,0,'C',1);
			$pdf->Cell(40,6, 'Nombre',1,0,'C',1);
			$pdf->Cell(10,6, 'Id Empleado',1,0,'C',1);
			$pdf->Cell(40,6, 'Tipo',1,0,'C',1);
			$pdf->Cell(40,6, 'Metodo',1,0,'C',1);
			$pdf->Cell(100,6, 'Ruta',1,0,'C',1);
			$pdf->Cell(40,6, 'Fecha y hora',1,1,'C',1);
			
			$pdf->SetFont('Arial','', 10);
			
			$todosLosLogs = empleados::traerLogs();
			
			for ($i = 0; $i < count($todosLosLogs); $i++) {
				$pdf->Cell(10,6, $todosLosLogs[$i]->id,1,0,'C');
				$pdf->Cell(40,6, $todosLosLogs[$i]->nombre,1,0,'C');
				$pdf->Cell(10,6, $todosLosLogs[$i]->idEmpleado,1,0,'C');
				$pdf->Cell(40,6, $todosLosLogs[$i]->tipo,1,0,'C');
				$pdf->Cell(40,6, $todosLosLogs[$i]->metodo,1,0,'C');
				$pdf->Cell(100,6, $todosLosLogs[$i]->ruta,1,0,'C');
				$pdf->Cell(40,6, $todosLosLogs[$i]->fechaYHora,1,1,'C');
			}
			
			$pdf->Output('D', 'ExportLogin-'.time().'.pdf');
			die;
		} catch (\Throwable $th) {
			//throw $th;
			return false;
		}		
	}
	
    public function obtenerPdfEmpleados(){
		try {
			//code...
			$pdf = new PlantillaPdf();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(120,10,'Export de Empleados', 0, 1, 'L');
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(70,6, 'ID',1,0,'C',1);
			$pdf->Cell(70,6, 'Nombre',1,1,'C',1);
			
			$pdf->SetFont('Arial','', 10);
			
			$todosLosEmpleados = empleados::obtenerTodos();
			
			for ($i = 0; $i < count($todosLosEmpleados); $i++) {
				$pdf->Cell(70,6, $todosLosEmpleados[$i]->id,1,0,'C');
				$pdf->Cell(70,6, $todosLosEmpleados[$i]->nombre,1,1,'C');
			}
			
			$pdf->Output('D', 'ExportEmpleados-'.time().'.pdf');
			die;
		} catch (\Throwable $th) {
			//throw $th;
			return false;
		}		
	}
	
	public function obtenerPdfMesas(){
		try {
			//code...
			$pdf = new PlantillaPdf();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(120,10,'Export de Mesas', 0, 1, 'L');
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(10,6, 'ID',1,0,'C',1);
			$pdf->Cell(70,6, 'Codigo',1,0,'C',1);
			$pdf->Cell(70,6, 'Estado',1,1,'C',1);
			
			$pdf->SetFont('Arial','', 10);
			
			$todasLasMesas = mesas::obtenerTodos();
			
			for ($i = 0; $i < count($todasLasMesas); $i++) {
				$pdf->Cell(10,6, $todasLasMesas[$i]->id,1,0,'C');
				$pdf->Cell(70,6, $todasLasMesas[$i]->codigo,1,0,'C');
				$pdf->Cell(70,6, $todasLasMesas[$i]->estado,1,1,'C');
			}
			
			$pdf->Output('D', 'ExportMesas-'.time().'.pdf');
			die;
		} catch (\Throwable $th) {
			//throw $th;
			return false;
		}		
	}
	
	public function obtenerPdfPedidos(){
		try {
			//code...
			$pdf = new PlantillaPdf('L', 'mm', 'legal');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(120,10,'Export de Pedidos', 0, 1, 'L');
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B', 12);

			$pdf->Cell(15,6, 'Codigo',1,0,'C',1);
			$pdf->Cell(20,6, 'Mesa',1,0,'C',1);
			$pdf->Cell(20,6, 'Articulo',1,0,'C',1);
			$pdf->Cell(20,6, 'Empleado',1,0,'C',1);
			$pdf->Cell(40,6, 'Cliente',1,0,'C',1);
			$pdf->Cell(20,6, 'Cantidad',1,0,'C',1);
			$pdf->Cell(20,6, 'Importe',1,0,'C',1);
			$pdf->Cell(40,6, 'Foto',1,0,'C',1);
			$pdf->Cell(30,6, 'Estado',1,0,'C',1);
			$pdf->Cell(35,6, 'Estimacion',1,0,'C',1);
			$pdf->Cell(40,6, 'Hora de inicio',1,0,'C',1);
			$pdf->Cell(40,6, 'Hora de fin',1,1,'C',1);
			
			$pdf->SetFont('Arial','', 10);
			
			$todosLosPedidos= pedidos::traerTodosLosPedidos();
			
			for ($i = 0; $i < count($todosLosPedidos); $i++) {
				$pdf->Cell(15,6, $todosLosPedidos[$i]['codigo'],1,0,'C');
				$pdf->Cell(20,6, $todosLosPedidos[$i]['mesa'],1,0,'C');
				$pdf->Cell(20,6, $todosLosPedidos[$i]['idArticulo'],1,0,'C');
				$pdf->Cell(20,6, $todosLosPedidos[$i]['idEmpleado'],1,0,'C');
				$pdf->Cell(40,6, $todosLosPedidos[$i]['cliente'],1,0,'C');
				$pdf->Cell(20,6, $todosLosPedidos[$i]['cantidad'],1,0,'C');
				$pdf->Cell(20,6, $todosLosPedidos[$i]['importe'],1,0,'C');
				$pdf->Cell(40,6, $todosLosPedidos[$i]['foto'],1,0,'C');
				$pdf->Cell(30,6, $todosLosPedidos[$i]['estado'],1,0,'C');
				$pdf->Cell(35,6, $todosLosPedidos[$i]['estimado'],1,0,'C');
				$pdf->Cell(40,6, $todosLosPedidos[$i]['horaInicio'],1,0,'C');
				$pdf->Cell(40,6, $todosLosPedidos[$i]['horaFin'],1,1,'C');
			}
			
			$pdf->Output('D', 'ExportPedidos-'.time().'.pdf');
			die;
		} catch (\Throwable $th) {
			//throw $th;
			return false;
		}		
	}

	public function obtenerPdfCarta(){
		try {
			//code...
			$pdf = new PlantillaPdf('L', 'mm', 'legal');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(120,10,'Export de Carta', 0, 1, 'L');
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B', 12);

			$pdf->Cell(10,6, 'Id',1,0,'C',1);
			$pdf->Cell(70,6, 'Descripcion',1,0,'C',1);
			$pdf->Cell(70,6, 'Precio',1,0,'C',1);
			$pdf->Cell(70,6, 'Sector',1,1,'C',1);
			
			$pdf->SetFont('Arial','', 10);
			
			$todosLosArticulos = carta::TraerTodosLosArticulos();
			
			for ($i = 0; $i < count($todosLosArticulos); $i++) {
				$pdf->Cell(10,6, $todosLosArticulos[$i]->id,1,0,'C');
				$pdf->Cell(70,6, $todosLosArticulos[$i]->descripcion,1,0,'C');
				$pdf->Cell(70,6, $todosLosArticulos[$i]->precio,1,0,'C');
				$pdf->Cell(70,6, $todosLosArticulos[$i]->sector,1,1,'C');
			}
			
			$pdf->Output('D', 'ExportCarta-'.time().'.pdf');
			die;
		} catch (\Throwable $th) {
			//throw $th;
			return false;
		}		
	}

	public function obtenerPdfCaja(){
		try {
			//code...
			$pdf = new PlantillaPdf('L', 'mm', 'legal');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(120,10,'Export de Caja', 0, 1, 'L');
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B', 12);

			$pdf->Cell(10,6, 'Id',1,0,'C',1);
			$pdf->Cell(40,6, 'Empleado',1,0,'C',1);
			$pdf->Cell(40,6, 'Fecha',1,0,'C',1);
			$pdf->Cell(15,6, 'Mesa',1,0,'C',1);
			$pdf->Cell(60,6, 'Cliente',1,0,'C',1);
			$pdf->Cell(70,6, 'Codigo Pedido',1,0,'C',1);
			$pdf->Cell(50,6, 'Importe',1,0,'C',1);
			$pdf->Cell(50,6, 'Estado',1,1,'C',1);
			
			$pdf->SetFont('Arial','', 10);
			
			$todaLaCaja = caja::obtenerTodos();
			
			for ($i = 0; $i < count($todaLaCaja); $i++) {
				$pdf->Cell(10,6, $todaLaCaja[$i]->id,1,0,'C');
				$pdf->Cell(40,6, $todaLaCaja[$i]->empleado,1,0,'C');
				$pdf->Cell(40,6, $todaLaCaja[$i]->fecha,1,0,'C');
				$pdf->Cell(15,6, $todaLaCaja[$i]->mesa,1,0,'C');
				$pdf->Cell(60,6, $todaLaCaja[$i]->cliente,1,0,'C');
				$pdf->Cell(70,6, $todaLaCaja[$i]->codigoPedido,1,0,'C');
				$pdf->Cell(50,6, $todaLaCaja[$i]->importe,1,0,'C');
				$pdf->Cell(50,6, $todaLaCaja[$i]->estado,1,1,'C');
			}
			
			$pdf->Output('D', 'ExportCaja-'.time().'.pdf');
			die;
		} catch (\Throwable $th) {
			//throw $th;
			return false;
		}		
	}

	public function obtenerPdfEncuestas(){
		try {
			//code...
			$pdf = new PlantillaPdf('L', 'mm', 'legal');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B', 12);
			$pdf->Cell(120,10,'Export de Caja', 0, 1, 'L');
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B', 12);

			$pdf->Cell(10,6,'Id',1,0,'C',1);
			$pdf->Cell(40,6,'Codigo Mesa',1,0,'C',1);
			$pdf->Cell(40,6,'Codigo Pedido',1,0,'C',1);
			$pdf->Cell(15,6,'Mesa',1,0,'C',1);
			$pdf->Cell(70,6,'Restaurante',1,0,'C',1);
			$pdf->Cell(50,6,'Mozo',1,0,'C',1);
			$pdf->Cell(50,6,'Cocinero',1,0,'C',1);
			$pdf->Cell(50,6,'Experiencia',1,1,'C',1);
			
			$pdf->SetFont('Arial','', 10);
			
			$todasLasEncuestas = encuesta::obtenerTodos();
			
			for ($i = 0; $i < count($todasLasEncuestas); $i++) {
				$pdf->Cell(10,6, $todasLasEncuestas[$i]->id,1,0,'C');
				$pdf->Cell(40,6, $todasLasEncuestas[$i]->codigoMesa,1,0,'C');
				$pdf->Cell(40,6, $todasLasEncuestas[$i]->codigoPedido,1,0,'C');
				$pdf->Cell(15,6, $todasLasEncuestas[$i]->mesa,1,0,'C');
				$pdf->Cell(70,6, $todasLasEncuestas[$i]->restaurante,1,0,'C');
				$pdf->Cell(50,6, $todasLasEncuestas[$i]->mozo,1,0,'C');
				$pdf->Cell(50,6, $todasLasEncuestas[$i]->cocinero,1,0,'C');
				$pdf->Cell(50,6, $todasLasEncuestas[$i]->experiencia,1,1,'C');
			}
			
			$pdf->Output('D', 'ExportEncuestas-'.time().'.pdf');
			die;
		} catch (\Throwable $th) {
			//throw $th;
			return false;
		}		
	}

}