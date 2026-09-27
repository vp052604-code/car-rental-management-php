<?php
// Database aur FPDF library include karein
include('includes/db.php');
require('includes/fpdf.php'); // Yeh file download karke includes folder mein rakhni hai

// Naya PDF document banayein
$pdf = new FPDF();
$pdf->AddPage();

// PDF ka Title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Car Rental - Bookings Report', 0, 1, 'C');
$pdf->Ln(10); // Ek line ka khali space

// Table ki Headings (Columns)
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 10, 'ID', 1);
$pdf->Cell(45, 10, 'Car Name', 1);
$pdf->Cell(50, 10, 'Customer', 1);
$pdf->Cell(40, 10, 'Start Date', 1);
$pdf->Cell(35, 10, 'Total', 1);
$pdf->Ln();

// Table ka Data Database se laakar PDF mein daalein
$pdf->SetFont('Arial', '', 12);

$query = "SELECT bookings.*, cars.car_name, customers.name AS customer_name 
          FROM bookings 
          JOIN cars ON bookings.car_id = cars.id 
          JOIN customers ON bookings.customer_id = customers.id 
          ORDER BY bookings.id DESC";
          
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $pdf->Cell(15, 10, $row['id'], 1);
        $pdf->Cell(45, 10, substr($row['car_name'], 0, 20), 1); // Naam lamba ho toh thoda cut kar dega
        $pdf->Cell(50, 10, substr($row['customer_name'], 0, 20), 1);
        $pdf->Cell(40, 10, date('d M Y', strtotime($row['start_date'])), 1);
        $pdf->Cell(35, 10, 'Rs ' . $row['total_price'], 1);
        $pdf->Ln(); // Har row ke baad nayi line
    }
} else {
    // Agar koi booking nahi hai
    $pdf->Cell(185, 10, 'No bookings found.', 1, 1, 'C');
}

// PDF ko directly browser se download karwane ki command
$pdf->Output('D', 'Bookings_Report.pdf');
?>