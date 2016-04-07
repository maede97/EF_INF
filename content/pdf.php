<?php
include("functions.php");
require_once("fpdf.php");
class PDF extends FPDF{
	//Kopfzeile
	function Header(){
		$this->Image("http://localhost/EF_INF/res/icon.png",15,5,20);
		$this->SetFont('Arial','B',15);
		//nach rechts gehen
		$this->Cell(80);
		//Titel
		global $title;
		$this->Cell(30,10,'SchoolTool - Vocabulary List',0,0,"C");
		$this->Cell(30,20,"$title",0,0,"C");
		//Zeilenumbruch
		$this->Ln(25);
		$this->Line(10,30,200,30);
	}

	//Fusszeile
	function Footer()
		{
			//Position 1,5 cm von unten
			$this->SetY(-15);
			//Arial kursiv 8
			$this->SetFont('Arial','I',8);
			//Seitenzahl
			$this->Cell(0,10,'Seite '.$this->PageNo().'/{nb}',0,0,'C');
		}
}
session_start();
if(isset($_SESSION['user_id']) && isset($_GET['liste'])){
	$id = $_SESSION['user_id'];
	$liste = $_GET['liste'];

	$db = new DB();
	$result = $db->selectListTitleFromId($id,$liste);

	//Global, dass auch danach im Header der Titel steht
	global $title;
	$title = $result[0]['titel'];
	
	//Make PDF
	$result = $db->selectWordsFromId($liste);
	//Alle Wörter zu einer Liste hinzufügen
	$woerter = $translations = array();
	foreach($result as $paar){
		array_push($woerter,html_entity_decode($paar['wort']));
		array_push($translations,html_entity_decode($paar['translation']));
	}
    
	$db->closeConnection();
	
	//Instanciation of inherited class
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFillColor(150);
		//Wörter in PDF einfüllen
		for($i=0;$i<count($woerter);$i++){
			$filler = ($i+1) % 2;
			//Fett:
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(95,10,$woerter[$i],0,0,'',$filler);
			$pdf->SetFont('Times','',12);
			$pdf->Cell(95,10,$translations[$i],0,1,'',$filler);
		}
	$pdf->Output("$title.pdf","I");
} else {
	header("Location: http://localhost/EF_INF/index.php?site=login&error=4");
	exit;
}
?>