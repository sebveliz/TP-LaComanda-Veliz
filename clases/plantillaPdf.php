<?php

require_once './vendor/pdf/fpdf.php';


class PlantillaPdf extends FPDF
{
    function Header(){
		
        $this->Image('img/logo.jpg', 5,5, 30);
        $this->SetFont('Arial','B',15);
        $this->Cell(30);
        $this->Cell(120,10,'TP - Programacion 3 Sebastian Veliz', 0, 1, 'C');
        $this->Ln(20);
        
    }
    
    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

}