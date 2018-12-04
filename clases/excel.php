<?php
require_once 'empleados.php';
//require_once 'AutentificadorJWT.php';
require_once './vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class excel
{
	public function obtenerExcelLogin(){
		try {

			$spreadsheet = new Spreadsheet();
			
			$sheet = $spreadsheet->getActiveSheet();
			$todosLosLogs = empleados::traerLogs();
			$tipoString=\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
			$sheet->setCellValue("A1", "ID");
			$sheet->setCellValue("B1", "Nombre");
			$sheet->setCellValue("C1", "IdEmpleado");
			$sheet->setCellValue("D1", "Tipo");
			$sheet->setCellValue("E1", "Metodo");
			$sheet->setCellValue("F1", "Ruta");
			$sheet->setCellValue("G1", "Fecha y Hora");

			for ($i = 2; $i <= count($todosLosLogs)+1; $i++) {
				$sheet->setCellValueExplicit("A$i", $todosLosLogs[$i-2]->id, $tipoString);
				$sheet->setCellValueExplicit("B$i", $todosLosLogs[$i-2]->nombre, $tipoString);
				$sheet->setCellValueExplicit("C$i", $todosLosLogs[$i-2]->idEmpleado, $tipoString);
				$sheet->setCellValueExplicit("D$i", $todosLosLogs[$i-2]->tipo, $tipoString);
				$sheet->setCellValueExplicit("E$i", $todosLosLogs[$i-2]->metodo, $tipoString);
				$sheet->setCellValueExplicit("F$i", $todosLosLogs[$i-2]->ruta, $tipoString);
				$sheet->setCellValueExplicit("G$i", $todosLosLogs[$i-2]->fechaYHora, $tipoString);
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="ExportLogin-'.time().'.xlsx"');
			$writer->save("php://output");

			die;
		} catch (\Throwable $th) {
			return false;
		}
	}
	
    public function obtenerExcelEmpleados(){
		try {

			$spreadsheet = new Spreadsheet();
			
			$sheet = $spreadsheet->getActiveSheet();
			$todosLosEmpleados = empleados::obtenerTodos();
			$tipoString=\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
			$sheet->setCellValue("A1", "ID");
			$sheet->setCellValue("B1", "Nombre");

			var_dump($todosLosEmpleados);

			for ($i = 2; $i <= count($todosLosEmpleados)+1; $i++) {
				$sheet->setCellValueExplicit("A$i", $todosLosEmpleados[$i-2]->id, $tipoString);
				$sheet->setCellValueExplicit("B$i", $todosLosEmpleados[$i-2]->nombre, $tipoString);
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="ExportEmpleados-'.time().'.xlsx"');
			$writer->save("php://output");

			die;
		} catch (\Throwable $th) {
			return false;
		}
	}
	
	public function obtenerExcelMesas(){
		try {

			$spreadsheet = new Spreadsheet();
			
			$sheet = $spreadsheet->getActiveSheet();
			$todasLasMesas = mesas::obtenerTodos();
			$tipoString=\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
			$sheet->setCellValue("A1", "ID");
			$sheet->setCellValue("B1", "Codigo");
			$sheet->setCellValue("C1", "Estado");

			//var_dump($todasLasMesas);

			for ($i = 2; $i <= count($todasLasMesas)+1; $i++) {
				$sheet->setCellValueExplicit("A$i", $todasLasMesas[$i-2]->id, $tipoString);
				$sheet->setCellValueExplicit("B$i", $todasLasMesas[$i-2]->codigo, $tipoString);
				$sheet->setCellValueExplicit("C$i", $todasLasMesas[$i-2]->estado, $tipoString);
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="ExportMesas-'.time().'.xlsx"');
			$writer->save("php://output");

			die;
		} catch (\Throwable $th) {
			return false;
		}
	}
	
	public function obtenerExcelPedidos(){
		try {

			$spreadsheet = new Spreadsheet();
			
			
			$sheet = $spreadsheet->getActiveSheet();
			$todosLosPedidos= pedidos::traerTodosLosPedidos();
			$tipoString=\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
			$sheet->setCellValue("A1", "Codigo");
			$sheet->setCellValue("B1", "Mesa");
			$sheet->setCellValue("C1", "Id Articulo");
			$sheet->setCellValue("D1", "Id Empleado");
			$sheet->setCellValue("E1", "Cliente");
			$sheet->setCellValue("F1", "Cantidad");
			$sheet->setCellValue("G1", "Importe");
			$sheet->setCellValue("H1", "Foto");
			$sheet->setCellValue("I1", "Estado");
			$sheet->setCellValue("J1", "Estimacion");
			$sheet->setCellValue("K1", "Hora de inicio");
			$sheet->setCellValue("L1", "Hora de fin");

			//var_dump($todosLosPedidos);
			
			for ($i = 2; $i <= count($todosLosPedidos)+1; $i++) {
				$sheet->setCellValueExplicit("A$i", $todosLosPedidos[$i-2]['codigo'], $tipoString);
				$sheet->setCellValueExplicit("B$i", $todosLosPedidos[$i-2]['mesa'], $tipoString);
				$sheet->setCellValueExplicit("C$i", $todosLosPedidos[$i-2]['idArticulo'], $tipoString);
				$sheet->setCellValueExplicit("D$i", $todosLosPedidos[$i-2]['idEmpleado'], $tipoString);
				$sheet->setCellValueExplicit("E$i", $todosLosPedidos[$i-2]['cliente'], $tipoString);
				$sheet->setCellValueExplicit("F$i", $todosLosPedidos[$i-2]['cantidad'], $tipoString);
				$sheet->setCellValueExplicit("G$i", $todosLosPedidos[$i-2]['importe'], $tipoString);
				$sheet->setCellValueExplicit("H$i", $todosLosPedidos[$i-2]['foto'], $tipoString);
				$sheet->setCellValueExplicit("I$i", $todosLosPedidos[$i-2]['estado'], $tipoString);
				$sheet->setCellValueExplicit("J$i", $todosLosPedidos[$i-2]['estimado'], $tipoString);
				$sheet->setCellValueExplicit("K$i", $todosLosPedidos[$i-2]['horaInicio'], $tipoString);
				$sheet->setCellValueExplicit("L$i", $todosLosPedidos[$i-2]['horaFin'], $tipoString);
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="ExportPedidos-'.time().'.xlsx"');
			$writer->save("php://output");

			die;
		} catch (\Throwable $th) {
			return false;
		}
	}

	public function obtenerExcelCarta(){
		try {

			$spreadsheet = new Spreadsheet();
			
			$sheet = $spreadsheet->getActiveSheet();
			$todosLosArticulos = carta::TraerTodosLosArticulos();
			$tipoString=\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
			$sheet->setCellValue("A1", "ID");
			$sheet->setCellValue("B1", "Descripcion");
			$sheet->setCellValue("C1", "Precio");
			$sheet->setCellValue("D1", "Sector");

			//var_dump($todosLosArticulos);

			for ($i = 2; $i <= count($todosLosArticulos)+1; $i++) {
				$sheet->setCellValueExplicit("A$i", $todosLosArticulos[$i-2]->id, $tipoString);
				$sheet->setCellValueExplicit("B$i", $todosLosArticulos[$i-2]->descripcion, $tipoString);
				$sheet->setCellValueExplicit("C$i", $todosLosArticulos[$i-2]->precio, $tipoString);
				$sheet->setCellValueExplicit("D$i", $todosLosArticulos[$i-2]->sector, $tipoString);
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="ExportCarta-'.time().'.xlsx"');
			$writer->save("php://output");

			die;
		} catch (\Throwable $th) {
			return false;
		}
	}

	public function obtenerExcelCaja(){
		try {

			$spreadsheet = new Spreadsheet();
			
			$sheet = $spreadsheet->getActiveSheet();
			$todaLaCaja = caja::obtenerTodos();
			$tipoString=\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
			$sheet->setCellValue("A1", "ID");
			$sheet->setCellValue("B1", "Empleado");
			$sheet->setCellValue("C1", "Fecha");
			$sheet->setCellValue("D1", "Mesa");
			$sheet->setCellValue("E1", "Cliente");
			$sheet->setCellValue("F1", "Codigo Pedido");
			$sheet->setCellValue("G1", "Importe");
			$sheet->setCellValue("H1", "Estado");

			//var_dump($todaLaCaja);

			for ($i = 2; $i <= count($todaLaCaja)+1; $i++) {
				$sheet->setCellValueExplicit("A$i", $todaLaCaja[$i-2]->id, $tipoString);
				$sheet->setCellValueExplicit("B$i", $todaLaCaja[$i-2]->empleado, $tipoString);
				$sheet->setCellValueExplicit("C$i", $todaLaCaja[$i-2]->fecha, $tipoString);
				$sheet->setCellValueExplicit("D$i", $todaLaCaja[$i-2]->mesa, $tipoString);
				$sheet->setCellValueExplicit("E$i", $todaLaCaja[$i-2]->cliente, $tipoString);
				$sheet->setCellValueExplicit("F$i", $todaLaCaja[$i-2]->codigoPedido, $tipoString);
				$sheet->setCellValueExplicit("G$i", $todaLaCaja[$i-2]->importe, $tipoString);
				$sheet->setCellValueExplicit("H$i", $todaLaCaja[$i-2]->estado, $tipoString);
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="ExportCaja-'.time().'.xlsx"');
			$writer->save("php://output");

			die;
		} catch (\Throwable $th) {
			return false;
		}
	}

	public function obtenerExcelEncuestas(){
		try {

			$spreadsheet = new Spreadsheet();
			
			$sheet = $spreadsheet->getActiveSheet();
			$todasLasEncuestas = encuesta::obtenerTodos();
			$tipoString=\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
			$sheet->setCellValue("A1", "ID");
			$sheet->setCellValue("B1", "Codigo Mesa");
			$sheet->setCellValue("C1", "Codigo Pedido");
			$sheet->setCellValue("D1", "Mesa");
			$sheet->setCellValue("E1", "Restaurante");
			$sheet->setCellValue("F1", "Mozo");
			$sheet->setCellValue("G1", "Cocinero");
			$sheet->setCellValue("H1", "Experiencia");

			//var_dump($todasLasEncuestas);

			for ($i = 2; $i <= count($todasLasEncuestas)+1; $i++) {
				$sheet->setCellValueExplicit("A$i", $todasLasEncuestas[$i-2]->id, $tipoString);
				$sheet->setCellValueExplicit("B$i", $todasLasEncuestas[$i-2]->codigoMesa, $tipoString);
				$sheet->setCellValueExplicit("C$i", $todasLasEncuestas[$i-2]->codigoPedido, $tipoString);
				$sheet->setCellValueExplicit("D$i", $todasLasEncuestas[$i-2]->mesa, $tipoString);
				$sheet->setCellValueExplicit("E$i", $todasLasEncuestas[$i-2]->restaurante, $tipoString);
				$sheet->setCellValueExplicit("F$i", $todasLasEncuestas[$i-2]->mozo, $tipoString);
				$sheet->setCellValueExplicit("G$i", $todasLasEncuestas[$i-2]->cocinero, $tipoString);
				$sheet->setCellValueExplicit("H$i", $todasLasEncuestas[$i-2]->experiencia, $tipoString);
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="ExportEncuestas-'.time().'.xlsx"');
			$writer->save("php://output");

			die;
		} catch (\Throwable $th) {
			return false;
		}
	}
}