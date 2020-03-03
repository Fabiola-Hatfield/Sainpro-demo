<?php
session_start();
$word= utf8_decode("Collinsville, IL. USA. 62234");
include_once("../fpdf/fpdf.php");

// A4 width: 219mm
// Default margin: 10mm each side
// Writable horizontal: 219-(10*2) = 189mm

if ($_POST["order-date"]){
    class PDF extends FPDF
    {
        // Page header
        function Header()
        {
            // Logo
            $this->Image("../logo.png",10,6,45,20);
            // Arial bold 15
            $this->SetFont("Arial","B",20);
            // Line break
            $this->Ln(25);
        }
        // Page footer
        function Footer()
        {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont("Arial","I",8);
            // Page number
            $this->Cell(0,10,"Pag. ".$this->PageNo()."/{nb}",0,0,"C");
        }
    }

    // Instanciation of inherited class
    $pdf = new PDF("P", "mm", "A4");
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont("Arial",'',12);

    //Cell(width, height, text, border, end line, [align]);
    $pdf->Cell(130, 5,"TIN: GOSJ770603 XXX",0,0);
    $pdf->SetFont("Arial","B",14);
    $pdf->Cell(59, 5,"INVOICE",0,1);//end of line
    $pdf->SetFont("Arial",'',12);
    $pdf->Cell(130, 5,"102 WOODHENGE DRIVE",0,1);
    //$pdf->Cell(59, 5,'',0,1);//end of line

    $pdf->Cell(130, 5,$word,0,0);
    $pdf->SetFont("Arial","B",12);
    $pdf->Cell(25, 5,"Date",0,0);
    $pdf->SetFont("Arial",'',12);
    $pdf->Cell(25, 5,": ".$_POST["order-date"],0,1);//end of line

    $pdf->Cell(130, 5,"Phone Number: (636) 466-00-40",0,0);
    $pdf->SetFont("Arial","B",12);
    $pdf->Cell(25, 5,"Invoice NO.",0,0);
    $pdf->SetFont("Arial",'',12);
    $pdf->Cell(25, 5,": ".$_POST["invoice-no"],0,1);//end of line

    $pdf->Cell(130, 5,"E-mail: sainpro@gmail.com",0,0);
    $pdf->SetFont("Arial","B",12);
    $pdf->Cell(25, 5,"Customer ",0,0);
    $pdf->SetFont("Arial",'',12);
    $pdf->Cell(25, 5,": ".$_POST["cust-name"],0,1);//end of line

    //make a dummy empty cell as a vertical spacer
    $pdf->Cell(189 ,10,'',0,1);//end of line
    $pdf->Cell(189 ,10,'',0,1);//end of line

    //invoice contents
    $pdf->SetFont("Arial","B",12);

    $pdf->Cell(10,10,"#",1,0,"C");
    $pdf->Cell(70,10,"Product",1,0,"C");
    $pdf->Cell(30,10,"Quantity",1,0,"C");
    $pdf->Cell(40,10,"Price",1,0,"C");
    $pdf->Cell(40,10,"Total (USD)",1,1,"C");

    $pdf->SetFont("Arial",'',12);

    for ($i=0; $i < count($_POST["prod-id"]) ; $i++) {
        $pdf->Cell(10,10, ($i+1) ,1,0,"C");
        $pdf->Cell(70,10, $_POST["prod-name"][$i],1,0,"C");
        $pdf->Cell(30,10, $_POST["prod-qty"][$i],1,0,"R");
        $pdf->Cell(40,10, $_POST["prod-price"][$i],1,0,"R");
        $pdf->Cell(40,10, ($_POST["prod-qty"][$i] * $_POST["prod-price"][$i]) ,1,1,"R");
    }

    /**
     * SUMMARY
     */
    $pdf->Cell(110,10,"",0,0);
    $pdf->Cell(40,10,"Sub Total",1,0);
    $pdf->Cell(4,10,"$",1,0);
    $pdf->Cell(36,10,$_POST["sub-total"],1,1);

    $pdf->Cell(110,10,"",0,0);
    $pdf->Cell(40,10,"Taxes (6%)",1,0);
    $pdf->Cell(4,10,"$",1,0);
    $pdf->Cell(36,10,$_POST["taxes"],1,1);

    $pdf->Cell(110,10,"",0,0);
    $pdf->Cell(40,10,"Discount",1,0);
    $pdf->Cell(4,10,"$",1,0);
    $pdf->Cell(36,10,$_POST["discount"],1,1);

    $pdf->Cell(110,10,"",0,0);
    $pdf->Cell(40,10,"Net Total",1,0);
    $pdf->Cell(4,10,"$",1,0);
    $pdf->Cell(36,10,$_POST["net-total"],1,1);

    $pdf->Cell(110,10,"",0,0);
    $pdf->Cell(40,10,"Paid Amount",1,0);
    $pdf->Cell(4,10,"$",1,0);
    $pdf->Cell(36,10,$_POST["paid"],1,1);

    $pdf->Cell(110,10,"",0,0);
    $pdf->Cell(40,10,"Due Amount",1,0);
    $pdf->Cell(4,10,"$",1,0);
    $pdf->Cell(36,10,$_POST["due"],1,1);

    $pdf->Cell(110,10,"",0,0);
    $pdf->Cell(40,10,"Payment Type",1,0);
    $pdf->Cell(4,10,"$",1,0);
    $pdf->Cell(36,10,$_POST["payment-type"],1,1);


    $pdf->Cell(110,10,"",0,0);
    $pdf->Cell(189 ,10,"",0,1);//end of line
    $pdf->Cell(189 ,10,"",0,1);//end of line
    $pdf->Cell(170,10,"Signature",0,0,"R");

    $pdf->Output("../PDF_INVOICE/PDF_INVOICE_".$_POST["invoice-no"].".pdf","F");

    $pdf->Output();
}