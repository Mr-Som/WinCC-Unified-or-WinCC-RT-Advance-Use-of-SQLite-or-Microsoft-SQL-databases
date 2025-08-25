<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/url.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTR</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= vendor_url('/bootstrap/v5.3.7/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= vendor_url('/bootstrap/v5.3.7/js/bootstrap.bundle.min.js'); ?>">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?= vendor_url('/datatables/css/datatables.min.css'); ?>">

    <!-- Material Design Icons -->
    <link rel="stylesheet" href="<?= vendor_url('/materialdesign/v7.4.47/css/materialdesignicons.min.css'); ?>" />

    <!-- Font -->
    <link
        href="<?= vendor_url('/fonts/googleapis/css/css2.css?family=Inter:wght@300;400;500;600&display=swap'); ?>"
        rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/main.css'); ?>">