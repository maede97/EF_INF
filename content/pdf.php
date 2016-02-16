<?php
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

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Check if User exists:
        $stmt = $conn->prepare("SELECT listen_id FROM listen WHERE user_id = '$id' AND listen_id = '$liste'");
        $stmt->execute();
        $result = $stmt->fetchall();
        if (count($result) == 1) {
			//Get Title
			$stmt = $conn->prepare("SELECT titel FROM listen WHERE user_id = '$id' AND listen_id = '$liste'");
			$stmt->execute();
			$result = $stmt->fetchall();
			global $title;
			$title = $result[0]['titel'];
			
            //Make PDF
			$stmt = $conn->prepare("SELECT wort, translation FROM woerter WHERE listen_id = '$liste'");
			$stmt->execute();
			$result = $stmt->fetchall();
			//Alle Wörter zu einer Liste hinzufügen
			$woerter = $translations = array();
			foreach($result as $paar){
				array_push($woerter,$paar['wort']);
				array_push($translations,$paar['translation']);
			}
        } else {
            //NO PDF
			header("Location: http://localhost/EF_INF/index.php?site=manage");
			exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
	
	

	//Instanciation of inherited class
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFillColor(150);
		for($i=0;$i<count($woerter);$i++){
			$filler = ($i+1) % 2;
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(95,10,$woerter[$i],0,0,'',$filler);
			$pdf->SetFont('Times','',12);
			$pdf->Cell(95,10,$translations[$i],0,1,'',$filler);
		}
	$pdf->Output("$title.pdf","I");
} else {
	header("Location: http://localhost/EF_INF/index.php?site=login");
	exit;
}
?>