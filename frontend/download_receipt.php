<?php
session_start();

// Database aur FPDF ko include karna (Path dhyan se check karein)
require_once '../admin/includes/db.php';
require_once '../admin/includes/fpdf.php';

// Check karein ki URL mein 'id' pass hui hai ya nahi
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Request. Booking ID is missing.");
}

$booking_id = intval($_GET['id']);

// Secure query: JOIN ka use karke teeno tables se data nikalna
$query = "SELECT b.id AS booking_id, b.start_date, b.end_date, b.total_price, 
                 c.car_name, c.brand, c.price_per_day, 
                 u.name, u.phone, u.email 
          FROM bookings b
          JOIN cars c ON b.car_id = c.id
          JOIN customers u ON b.customer_id = u.id
          WHERE b.id = ?";

// Prepared statement use kar rahe hain taaki SQL Injection se bacha ja sake
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Booking not found or access denied.");
}

$data = $result->fetch_assoc();

// FPDF Class ko extend karke Header aur Footer customize karna
class PDF extends FPDF {
    // Page Header
    function Header() {
        // Logo ya Title
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0, 10, 'Car Rental System', 0, 1, 'C');
        
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(108, 117, 125);
        $this->Cell(0, 10, 'Official Booking Receipt', 0, 1, 'C');
        
        // Line break
        $this->Ln(10);
    }

    // Page Footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, 'Thank you for choosing our Car Rental System. Drive Safe!', 0, 0, 'C');
    }
}

// PDF Object Create karna
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetDrawColor(200, 200, 200); // Light gray borders ke liye

// ----------------------------------------------------
// Section 1: Customer Details
// ----------------------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 10, 'Customer Information', 'B', 1, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 8, 'Name:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, $data['name'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 8, 'Email:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, $data['email'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 8, 'Phone:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, $data['phone'], 0, 1);
$pdf->Ln(5);

// ----------------------------------------------------
// Section 2: Booking Details
// ----------------------------------------------------
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Booking Details', 'B', 1, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 8, 'Booking ID:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, '#' . $data['booking_id'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 8, 'Car Model:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, $data['brand'] . ' ' . $data['car_name'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 8, 'Rental Period:', 0, 0);
$pdf->SetFont('Arial', '', 10);
// Date format ko thoda readable banana
$formatted_start = date('d M Y', strtotime($data['start_date']));
$formatted_end = date('d M Y', strtotime($data['end_date']));
$pdf->Cell(0, 8, $formatted_start . '  TO  ' . $formatted_end, 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 8, 'Price Per Day:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, 'Rs. ' . number_format($data['price_per_day'], 2), 0, 1); // Currency Rs. ya $ apne hisaab se change kar lein

$pdf->Ln(10);

// ----------------------------------------------------
// Section 3: Total Amount 
// ----------------------------------------------------
$pdf->SetFillColor(240, 240, 240); // Light gray background total ke liye
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(120, 12, ' Total Amount Paid:', 1, 0, 'R', true);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(70, 12, 'Rs. ' . number_format($data['total_price'], 2), 1, 1, 'C', true);

// PDF ko download ke liye force karna
// 'D' ka matlab Download hai. File ka naam 'Booking_Receipt_123.pdf' hoga
$pdf->Output('D', 'Booking_Receipt_' . $booking_id . '.pdf');
?>