<?php
session_start();

if (!isset($_SESSION['pdf_content'])) {
    header("HTTP/1.0 404 Not Found");
    exit;
}

// Set headers for PDF display
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="annexure.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

echo $_SESSION['pdf_content'];
unset($_SESSION['pdf_content']); // Clean up after sending
