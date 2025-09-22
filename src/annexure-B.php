<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
//require_once __DIR__ . '/includes/auth-check.php';
require_once __DIR__ . '/includes/header.php';
include __DIR__ . '/config/database.php';
$pdo = Database::getConnection();

// Check if an ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die('Invalid or missing report ID.');
}
$reportId = (int)$_GET['id'];

// Fetch data for the specific report
$query = "
    SELECT 
        tmr.id,
        tmr.train_no,
        tmr.train_name,
        tmr.date_of_testing,
        tmr.washing_pit_no,
        tmr.shift,
        tmr.sse,
        tmr.operator_name,
        tmr.pipe_type,
        tmr.rake_type,
        tmr.load,
        tmr.coach_type,
        tmr.created_at,
        tmr.updated_at,
        icf01.drain_aux_reservoir,
        icf01.visual_inspection,
        icf01.greasing,
        icf01.fr_bp_value,
        icf01.fr_fp_value,
        icf02.bp_leakage_value,
        icf02.fp_leakage_value,
        icf03.full_brk_applied,
        icf03.full_brk_rel_in_iso,
        icf03.coach01,
        icf03.coach02,
        icf03.coach03,
        icf03.coach04,
        icf03.coach05,
        icf03.coach06,
        icf03.coach07,
        icf03.coach08,
        icf03.coach09,
        icf03.coach10,
        icf03.coach11,
        icf03.coach12,
        icf03.coach13,
        icf03.coach14,
        icf03.coach15,
        icf03.coach16,
        icf03.coach17,
        icf03.coach18,
        icf03.coach19,
        icf03.coach20,
        icf03.coach21,
        icf03.coach22,
        icf03.coach23,
        icf03.coach24,
        icf03.ps_end_col1_01,
        icf03.ps_end_col1_02,
        icf03.ps_end_col1_03,
        icf03.ps_end_col1_04,
        icf03.ps_end_col1_05,
        icf03.ps_end_col1_06,
        icf03.ps_end_col1_07,
        icf03.ps_end_col1_08,
        icf03.ps_end_col1_09,
        icf03.ps_end_col1_10,
        icf03.ps_end_col1_11,
        icf03.ps_end_col1_12,
        icf03.ps_end_col1_13,
        icf03.ps_end_col1_14,
        icf03.ps_end_col1_15,
        icf03.ps_end_col1_16,
        icf03.ps_end_col1_17,
        icf03.ps_end_col1_18,
        icf03.ps_end_col1_19,
        icf03.ps_end_col1_20,
        icf03.ps_end_col1_21,
        icf03.ps_end_col1_22,
        icf03.ps_end_col1_23,
        icf03.ps_end_col1_24,
        icf03.ps_end_col2_01,
        icf03.ps_end_col2_02,
        icf03.ps_end_col2_03,
        icf03.ps_end_col2_04,
        icf03.ps_end_col2_05,
        icf03.ps_end_col2_06,
        icf03.ps_end_col2_07,
        icf03.ps_end_col2_08,
        icf03.ps_end_col2_09,
        icf03.ps_end_col2_10,
        icf03.ps_end_col2_11,
        icf03.ps_end_col2_12,
        icf03.ps_end_col2_13,
        icf03.ps_end_col2_14,
        icf03.ps_end_col2_15,
        icf03.ps_end_col2_16,
        icf03.ps_end_col2_17,
        icf03.ps_end_col2_18,
        icf03.ps_end_col2_19,
        icf03.ps_end_col2_20,
        icf03.ps_end_col2_21,
        icf03.ps_end_col2_22,
        icf03.ps_end_col2_23,
        icf03.ps_end_col2_24,
        icf03.ps_non_col1_01,
        icf03.ps_non_col1_02,
        icf03.ps_non_col1_03,
        icf03.ps_non_col1_04,
        icf03.ps_non_col1_05,
        icf03.ps_non_col1_06,
        icf03.ps_non_col1_07,
        icf03.ps_non_col1_08,
        icf03.ps_non_col1_09,
        icf03.ps_non_col1_10,
        icf03.ps_non_col1_11,
        icf03.ps_non_col1_12,
        icf03.ps_non_col1_13,
        icf03.ps_non_col1_14,
        icf03.ps_non_col1_15,
        icf03.ps_non_col1_16,
        icf03.ps_non_col1_17,
        icf03.ps_non_col1_18,
        icf03.ps_non_col1_19,
        icf03.ps_non_col1_20,
        icf03.ps_non_col1_21,
        icf03.ps_non_col1_22,
        icf03.ps_non_col1_23,
        icf03.ps_non_col1_24,
        icf03.ps_non_col2_01,
        icf03.ps_non_col2_02,
        icf03.ps_non_col2_03,
        icf03.ps_non_col2_04,
        icf03.ps_non_col2_05,
        icf03.ps_non_col2_06,
        icf03.ps_non_col2_07,
        icf03.ps_non_col2_08,
        icf03.ps_non_col2_09,
        icf03.ps_non_col2_10,
        icf03.ps_non_col2_11,
        icf03.ps_non_col2_12,
        icf03.ps_non_col2_13,
        icf03.ps_non_col2_14,
        icf03.ps_non_col2_15,
        icf03.ps_non_col2_16,
        icf03.ps_non_col2_17,
        icf03.ps_non_col2_18,
        icf03.ps_non_col2_19,
        icf03.ps_non_col2_20,
        icf03.ps_non_col2_21,
        icf03.ps_non_col2_22,
        icf03.ps_non_col2_23,
        icf03.ps_non_col2_24,
        lhb07.coach_nos,
        lhb08.front_car_time1,
        lhb08.rear_car_time1,
        lhb08.front_car_time2,
        lhb08.rear_car_time2,
        lhb09.ghbcable_ok,
        lhb09.ghbgreen_ok,
        lhb11.manrel_step2
    FROM train_maintenance_report tmr
    LEFT JOIN tbl_icf_01 icf01 ON tmr.id = icf01.id
    LEFT JOIN tbl_icf_02 icf02 ON tmr.id = icf02.id
    LEFT JOIN tbl_icf_03 icf03 ON tmr.id = icf03.id
    LEFT JOIN tbl_lhb_07 lhb07 ON tmr.id = lhb07.id
    LEFT JOIN tbl_lhb_08 lhb08 ON tmr.id = lhb08.id
    LEFT JOIN tbl_lhb_09 lhb09 ON tmr.id = lhb09.id
    LEFT JOIN tbl_lhb_11 lhb11 ON tmr.id = lhb11.id
    WHERE tmr.id = :id
";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $reportId]);
$report = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$report) {
  die('Report not found.');
}


// Map database columns to PHP variables for mPDF
$train_no = htmlspecialchars($report['train_no'] ?? '');
$train_name = htmlspecialchars($report['train_name'] ?? '');
$load = htmlspecialchars($report['load'] ?? '');
$operator_name = htmlspecialchars($report['operator_name'] ?? '');
$date_of_testing = htmlspecialchars($report['created_at'] ? date('d M, Y', strtotime($report['created_at'])) : '');
$drain_aux_reservoir = htmlspecialchars($report['drain_aux_reservoir'] ?? '');
$visual_inspection = htmlspecialchars($report['visual_inspection'] ?? '');
$greasing = htmlspecialchars($report['greasing'] ?? '');
$fr_bp_value = htmlspecialchars($report['fr_bp_value'] ?? '');
$fr_fp_value = htmlspecialchars($report['fr_fp_value'] ?? '');
$bp_leakage_value = htmlspecialchars($report['bp_leakage_value'] ?? '');
$fp_leakage_value = htmlspecialchars($report['fp_leakage_value'] ?? '');
$full_brk_applied = htmlspecialchars($report['full_brk_applied'] ?? '');
$full_brk_rel_in_iso = htmlspecialchars($report['full_brk_rel_in_iso'] ?? '');
$coach01 = htmlspecialchars($report['coach01'] ?? '');
$coach02 = htmlspecialchars($report['coach02'] ?? '');
$coach03 = htmlspecialchars($report['coach03'] ?? '');
$coach04 = htmlspecialchars($report['coach04'] ?? '');
$coach05 = htmlspecialchars($report['coach05'] ?? '');
$coach06 = htmlspecialchars($report['coach06'] ?? '');
$coach07 = htmlspecialchars($report['coach07'] ?? '');
$coach08 = htmlspecialchars($report['coach08'] ?? '');
$coach09 = htmlspecialchars($report['coach09'] ?? '');
$coach10 = htmlspecialchars($report['coach10'] ?? '');
$coach11 = htmlspecialchars($report['coach11'] ?? '');
$coach12 = htmlspecialchars($report['coach12'] ?? '');
$coach13 = htmlspecialchars($report['coach13'] ?? '');
$coach14 = htmlspecialchars($report['coach14'] ?? '');
$coach15 = htmlspecialchars($report['coach15'] ?? '');
$coach16 = htmlspecialchars($report['coach16'] ?? '');
$coach17 = htmlspecialchars($report['coach17'] ?? '');
$coach18 = htmlspecialchars($report['coach18'] ?? '');
$coach19 = htmlspecialchars($report['coach19'] ?? '');
$coach20 = htmlspecialchars($report['coach20'] ?? '');
$coach21 = htmlspecialchars($report['coach21'] ?? '');
$coach22 = htmlspecialchars($report['coach22'] ?? '');
$coach23 = htmlspecialchars($report['coach23'] ?? '');
$coach24 = htmlspecialchars($report['coach24'] ?? '');
$ps_end_col1_01 = htmlspecialchars($report['ps_end_col1_01'] ?? '');
$ps_end_col1_02 = htmlspecialchars($report['ps_end_col1_02'] ?? '');
$ps_end_col1_03 = htmlspecialchars($report['ps_end_col1_03'] ?? '');
$ps_end_col1_04 = htmlspecialchars($report['ps_end_col1_04'] ?? '');
$ps_end_col1_05 = htmlspecialchars($report['ps_end_col1_05'] ?? '');
$ps_end_col1_06 = htmlspecialchars($report['ps_end_col1_06'] ?? '');
$ps_end_col1_07 = htmlspecialchars($report['ps_end_col1_07'] ?? '');
$ps_end_col1_08 = htmlspecialchars($report['ps_end_col1_08'] ?? '');
$ps_end_col1_09 = htmlspecialchars($report['ps_end_col1_09'] ?? '');
$ps_end_col1_10 = htmlspecialchars($report['ps_end_col1_10'] ?? '');
$ps_end_col1_11 = htmlspecialchars($report['ps_end_col1_11'] ?? '');
$ps_end_col1_12 = htmlspecialchars($report['ps_end_col1_12'] ?? '');
$ps_end_col1_13 = htmlspecialchars($report['ps_end_col1_13'] ?? '');
$ps_end_col1_14 = htmlspecialchars($report['ps_end_col1_14'] ?? '');
$ps_end_col1_15 = htmlspecialchars($report['ps_end_col1_15'] ?? '');
$ps_end_col1_16 = htmlspecialchars($report['ps_end_col1_16'] ?? '');
$ps_end_col1_17 = htmlspecialchars($report['ps_end_col1_17'] ?? '');
$ps_end_col1_18 = htmlspecialchars($report['ps_end_col1_18'] ?? '');
$ps_end_col1_19 = htmlspecialchars($report['ps_end_col1_19'] ?? '');
$ps_end_col1_20 = htmlspecialchars($report['ps_end_col1_20'] ?? '');
$ps_end_col1_21 = htmlspecialchars($report['ps_end_col1_21'] ?? '');
$ps_end_col1_22 = htmlspecialchars($report['ps_end_col1_22'] ?? '');
$ps_end_col1_23 = htmlspecialchars($report['ps_end_col1_23'] ?? '');
$ps_end_col1_24 = htmlspecialchars($report['ps_end_col1_24'] ?? '');
$ps_end_col2_01 = htmlspecialchars($report['ps_end_col2_01'] ?? '');
$ps_end_col2_02 = htmlspecialchars($report['ps_end_col2_02'] ?? '');
$ps_end_col2_03 = htmlspecialchars($report['ps_end_col2_03'] ?? '');
$ps_end_col2_04 = htmlspecialchars($report['ps_end_col2_04'] ?? '');
$ps_end_col2_05 = htmlspecialchars($report['ps_end_col2_05'] ?? '');
$ps_end_col2_06 = htmlspecialchars($report['ps_end_col2_06'] ?? '');
$ps_end_col2_07 = htmlspecialchars($report['ps_end_col2_07'] ?? '');
$ps_end_col2_08 = htmlspecialchars($report['ps_end_col2_08'] ?? '');
$ps_end_col2_09 = htmlspecialchars($report['ps_end_col2_09'] ?? '');
$ps_end_col2_10 = htmlspecialchars($report['ps_end_col2_10'] ?? '');
$ps_end_col2_11 = htmlspecialchars($report['ps_end_col2_11'] ?? '');
$ps_end_col2_12 = htmlspecialchars($report['ps_end_col2_12'] ?? '');
$ps_end_col2_13 = htmlspecialchars($report['ps_end_col2_13'] ?? '');
$ps_end_col2_14 = htmlspecialchars($report['ps_end_col2_14'] ?? '');
$ps_end_col2_15 = htmlspecialchars($report['ps_end_col2_15'] ?? '');
$ps_end_col2_16 = htmlspecialchars($report['ps_end_col2_16'] ?? '');
$ps_end_col2_17 = htmlspecialchars($report['ps_end_col2_17'] ?? '');
$ps_end_col2_18 = htmlspecialchars($report['ps_end_col2_18'] ?? '');
$ps_end_col2_19 = htmlspecialchars($report['ps_end_col2_19'] ?? '');
$ps_end_col2_20 = htmlspecialchars($report['ps_end_col2_20'] ?? '');
$ps_end_col2_21 = htmlspecialchars($report['ps_end_col2_21'] ?? '');
$ps_end_col2_22 = htmlspecialchars($report['ps_end_col2_22'] ?? '');
$ps_end_col2_23 = htmlspecialchars($report['ps_end_col2_23'] ?? '');
$ps_end_col2_24 = htmlspecialchars($report['ps_end_col2_24'] ?? '');
$ps_non_col1_01 = htmlspecialchars($report['ps_non_col1_01'] ?? '');
$ps_non_col1_02 = htmlspecialchars($report['ps_non_col1_02'] ?? '');
$ps_non_col1_03 = htmlspecialchars($report['ps_non_col1_03'] ?? '');
$ps_non_col1_04 = htmlspecialchars($report['ps_non_col1_04'] ?? '');
$ps_non_col1_05 = htmlspecialchars($report['ps_non_col1_05'] ?? '');
$ps_non_col1_06 = htmlspecialchars($report['ps_non_col1_06'] ?? '');
$ps_non_col1_07 = htmlspecialchars($report['ps_non_col1_07'] ?? '');
$ps_non_col1_08 = htmlspecialchars($report['ps_non_col1_08'] ?? '');
$ps_non_col1_09 = htmlspecialchars($report['ps_non_col1_09'] ?? '');
$ps_non_col1_10 = htmlspecialchars($report['ps_non_col1_10'] ?? '');
$ps_non_col1_11 = htmlspecialchars($report['ps_non_col1_11'] ?? '');
$ps_non_col1_12 = htmlspecialchars($report['ps_non_col1_12'] ?? '');
$ps_non_col1_13 = htmlspecialchars($report['ps_non_col1_13'] ?? '');
$ps_non_col1_14 = htmlspecialchars($report['ps_non_col1_14'] ?? '');
$ps_non_col1_15 = htmlspecialchars($report['ps_non_col1_15'] ?? '');
$ps_non_col1_16 = htmlspecialchars($report['ps_non_col1_16'] ?? '');
$ps_non_col1_17 = htmlspecialchars($report['ps_non_col1_17'] ?? '');
$ps_non_col1_18 = htmlspecialchars($report['ps_non_col1_18'] ?? '');
$ps_non_col1_19 = htmlspecialchars($report['ps_non_col1_19'] ?? '');
$ps_non_col1_20 = htmlspecialchars($report['ps_non_col1_20'] ?? '');
$ps_non_col1_21 = htmlspecialchars($report['ps_non_col1_21'] ?? '');
$ps_non_col1_22 = htmlspecialchars($report['ps_non_col1_22'] ?? '');
$ps_non_col1_23 = htmlspecialchars($report['ps_non_col1_23'] ?? '');
$ps_non_col1_24 = htmlspecialchars($report['ps_non_col1_24'] ?? '');
$ps_non_col2_01 = htmlspecialchars($report['ps_non_col2_01'] ?? '');
$ps_non_col2_02 = htmlspecialchars($report['ps_non_col2_02'] ?? '');
$ps_non_col2_03 = htmlspecialchars($report['ps_non_col2_03'] ?? '');
$ps_non_col2_04 = htmlspecialchars($report['ps_non_col2_04'] ?? '');
$ps_non_col2_05 = htmlspecialchars($report['ps_non_col2_05'] ?? '');
$ps_non_col2_06 = htmlspecialchars($report['ps_non_col2_06'] ?? '');
$ps_non_col2_07 = htmlspecialchars($report['ps_non_col2_07'] ?? '');
$ps_non_col2_08 = htmlspecialchars($report['ps_non_col2_08'] ?? '');
$ps_non_col2_09 = htmlspecialchars($report['ps_non_col2_09'] ?? '');
$ps_non_col2_10 = htmlspecialchars($report['ps_non_col2_10'] ?? '');
$ps_non_col2_11 = htmlspecialchars($report['ps_non_col2_11'] ?? '');
$ps_non_col2_12 = htmlspecialchars($report['ps_non_col2_12'] ?? '');
$ps_non_col2_13 = htmlspecialchars($report['ps_non_col2_13'] ?? '');
$ps_non_col2_14 = htmlspecialchars($report['ps_non_col2_14'] ?? '');
$ps_non_col2_15 = htmlspecialchars($report['ps_non_col2_15'] ?? '');
$ps_non_col2_16 = htmlspecialchars($report['ps_non_col2_16'] ?? '');
$ps_non_col2_17 = htmlspecialchars($report['ps_non_col2_17'] ?? '');
$ps_non_col2_18 = htmlspecialchars($report['ps_non_col2_18'] ?? '');
$ps_non_col2_19 = htmlspecialchars($report['ps_non_col2_19'] ?? '');
$ps_non_col2_20 = htmlspecialchars($report['ps_non_col2_20'] ?? '');
$ps_non_col2_21 = htmlspecialchars($report['ps_non_col2_21'] ?? '');
$ps_non_col2_22 = htmlspecialchars($report['ps_non_col2_22'] ?? '');
$ps_non_col2_23 = htmlspecialchars($report['ps_non_col2_23'] ?? '');
$ps_non_col2_24 = htmlspecialchars($report['ps_non_col2_24'] ?? '');
$coach_nos = htmlspecialchars($report['coach_nos'] ?? '');
$front_car_time1 = htmlspecialchars($report['front_car_time1'] ?? '');
$rear_car_time1 = htmlspecialchars($report['rear_car_time1'] ?? '');
$front_car_time2 = htmlspecialchars($report['front_car_time2'] ?? '');
$rear_car_time2 = htmlspecialchars($report['rear_car_time2'] ?? '');
$ghbcable_ok = htmlspecialchars($report['ghbcable_ok'] ?? '');
$ghbgreen_ok = htmlspecialchars($report['ghbgreen_ok'] ?? '');
$manrel_step2 = htmlspecialchars($report['manrel_step2'] ?? '');
$created_at = htmlspecialchars($report['created_at'] ? date('Y-m-d_H-i-s', strtotime($report['created_at'])) : date('Y-m-d_H-i-s')); // Format for filename
?>
</head>

<body class="bg-secondary2">
  <?php require_once __DIR__ . '/includes/about.modal.php'; ?>
  <?php require_once __DIR__ . '/includes/help.modal.php'; ?>
  <?php require_once __DIR__ . '/includes/navbar.php'; ?>
  <!-- Start container-fluid -->
  <div class="container-fluid">

    <?php
    require_once __DIR__ . '/../vendor/autoload.php';

    //--- Create mPDF instance   
    $mpdf = new \Mpdf\Mpdf([
      'default_font' => 'FreeSans',
      'format' => 'A4',
      'orientation' => 'P', // Or 'L' for landscape
      'margin_left' => 10,
      'margin_right' => 10,
      'margin_top' => 10,
      'margin_bottom' => 10,
    ]);

    //--- HTML Content 
    $html = '
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="assets/css/annexure-B.css" />
  </head>

    <body>
      <table
        border="0"
        cellpadding="0"
        cellspacing="0"
        id="sheet0"
        class="sheet0 gridlines"
      >
        <col class="col0" />
        <col class="col1" />
        <col class="col2" />
        <col class="col3" />
        <col class="col4" />
        <col class="col5" />
        <col class="col6" />
        <col class="col7" />
        <col class="col8" />
        <col class="col9" />
        <col class="col10" />
        <col class="col11" />
        <tbody>
          <tr class="row0">
            <td class="column0 style18 s style18" colspan="12">Annexure-B</td>
          </tr>
          <tr class="row0">
            <td class="column0 style49 s style49" colspan="12">' . isset($_COOKIE['title']) ? htmlspecialchars($_COOKIE['title']) : '' . '</td>
          </tr>
          <tr class="row1">
            <td class="column0 style16 s style16" colspan="12">
              Format for Air Brake Rake Testing on RTR (ICF Coaches)
            </td>
          </tr>
          <tr class="row2">
            <td class="column0 style17 s style17" colspan="12">
              (As per CAMTECH Manual)
            </td>
          </tr>
          <tr class="row3">
            <td class="column0 style41 null style41" colspan="12"></td>
          </tr>
          <tr class="row4">
            <td class="column0 style42 s style43" colspan="2">
              Train No. : ' . $train_no . '
            </td>
            <td class="column2 style7 s">Load: ' . $load . '</td>
            <td class="column3 style39 s style40" colspan="2">
              Date: ' . $date_of_testing . '
            </td>
            <td class="column5 style44 null style44" rowspan="27"></td>
            <td class="column6 style45 s style45" rowspan="3">SN</td>
            <td class="column7 style45 s style45" rowspan="3">Coach No</td>
            <td class="column8 style45 s style45" colspan="4">Piston Stroke</td>
          </tr>
          <tr class="row5">
            <td class="column0 style42 s style46" colspan="5">
              Name of Staff: ' . $operator_name . '
            </td>
            <td class="column8 style45 s style45" colspan="2" rowspan="2">
              PEASD END
            </td>
            <td class="column10 style45 s style45" colspan="2" rowspan="2">
              Non PEASD END
            </td>
          </tr>
          <tr class="row6">
            <td class="column0 style2 s">SN</td>
            <td class="column1 style3 s">Description</td>
            <td class="column2 style3 s">Observation</td>
            <td class="column3 style4 s">Actual Value</td>
            <td class="column4 style4 s">Remarks</td>
          </tr>
          <tr class="row7">
            <td class="column0 style5 n">1</td>
            <td class="column1 style6 s">Draining of Aux. reservoir</td>
            <td class="column2 style7 s">200 L</td>
            <td class="column3 style11 s">' . $drain_aux_reservoir . '</td>
            <td class="column4 style11 null"></td>
            <td class="column6 style8 n">1</td>
            <td class="column7 style9 s">' . $coach01 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_01 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_01 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_01 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_01 . '</td>
          </tr>
          <tr class="row8">
            <td class="column0 style47 n style48" rowspan="2">2</td>
            <td class="column1 style23 s style24" rowspan="2">
              Visual inspection of BP/FP<br />
              coupling, suspension<br />
              brackets and APD
            </td>
            <td class="column2 style25 null style26" rowspan="2"></td>
            <td class="column3 style37 s style36" rowspan="2">
              ' . $visual_inspection . '
            </td>
            <td class="column4 style27 null style28" rowspan="2"></td>
            <td class="column6 style15 n">2</td>
            <td class="column7 style9 s">' . $coach02 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_02 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_02 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_02 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_02 . '</td>
          </tr>
          <tr class="row9">
            <td class="column6 style8 n">3</td>
            <td class="column7 style9 s">' . $coach03 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_03 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_03 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_03 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_03 . '</td>
          </tr>
          <tr class="row10">
            <td class="column0 style21 n style22" rowspan="2">3</td>
            <td class="column1 style23 s style24" rowspan="2">
              Greasing of moving parts-<br />
              brake rigging system (if<br />
              required)
            </td>
            <td class="column2 style25 null style26" rowspan="2"></td>
            <td class="column3 style37 s style36" rowspan="2">' . $greasing . '</td>
            <td class="column4 style27 null style28" rowspan="2"></td>
            <td class="column6 style10 n">4</td>
            <td class="column7 style9 s">' . $coach04 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_04 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_04 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_04 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_04 . '</td>
          </tr>
          <tr class="row11">
            <td class="column6 style10 n">5</td>
            <td class="column7 style9 s">' . $coach05 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_05 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_05 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_05 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_05 . '</td>
          </tr>
          <tr class="row12">
            <td class="column0 style5 n">4</td>
            <td class="column1 style12 s">
              Accuracy of BP/FP gauge of<br />
              front SLRD
            </td>
            <td class="column2 style7 s">
              BP- 5 kg/cm2<br />
              FP- 6 kg/cm2
            </td>
            <td class="column3 style14 s">
              ' . $fr_bp_value . '<br />
              ' . $fr_fp_value . '
            </td>
            <td class="column4 style13 null"></td>
            <td class="column6 style10 n">6</td>
            <td class="column7 style9 s">' . $coach06 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_06 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_06 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_06 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_06 . '</td>
          </tr>
          <tr class="row13">
            <td class="column0 style21 n style22" rowspan="2">5</td>
            <td class="column1 style23 s style24" rowspan="2">
              Leakage Test:<br />
              (a) Brake Pipe<br />
              (b) Feed Pipe
            </td>
            <td class="column2 style23 s style24" rowspan="2">0.2 kg/cm2/min</td>
            <td class="column3 style35 s style36" rowspan="2">
              ' . $bp_leakage_value . '<br />
              ' . $fp_leakage_value . '
            </td>
            <td class="column4 style27 null style28" rowspan="2"></td>
            <td class="column6 style10 n">7</td>
            <td class="column7 style9 s">' . $coach07 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_07 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_07 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_07 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_07 . '</td>
          </tr>
          <tr class="row14">
            <td class="column6 style10 n">8</td>
            <td class="column7 style9 s">' . $coach08 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_08 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_08 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_08 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_08 . '</td>
          </tr>
          <tr class="row15">
            <td class="column0 style33 n style34" rowspan="4">6</td>
            <td class="column1 style23 s style24" rowspan="4">
              Service Application and<br />
              release test :<br />
              (a) Brake application when<br />
              B.P. pressure reduced to<br />
              1.5kg/cm2<br />
              (b)Observe Piston stroke of<br />
              brake cylinder<br />
              (C) Record the piston stroke
            </td>
            <td class="column2 style23 s style24" rowspan="4">
              Brake should apply<br />
              <br />
              Piston in applied<br />
              position
            </td>
            <td class="column3 style35 s style36" rowspan="4">
              (a) ' . $full_brk_applied . '<br />
              <br />
              (b) ' . $full_brk_rel_in_iso . '
            </td>
            <td class="column4 style27 null style28" rowspan="4"></td>
            <td class="column6 style10 n">9</td>
            <td class="column7 style9 s">' . $coach09 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_09 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_09 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_09 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_09 . '</td>
          </tr>
          <tr class="row16">
            <td class="column6 style10 n">10</td>
            <td class="column7 style9 s">' . $coach10 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_10 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_10 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_10 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_10 . '</td>
          </tr>
          <tr class="row17">
            <td class="column6 style10 n">11</td>
            <td class="column7 style9 s">' . $coach11 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_11 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_11 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_11 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_11 . '</td>
          </tr>
          <tr class="row18">
            <td class="column6 style10 n">12</td>
            <td class="column7 style9 s">' . $coach12 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_12 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_12 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_12 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_12 . '</td>
          </tr>
          <tr class="row19">
            <td class="column0 style21 n style22" rowspan="2">7</td>
            <td class="column1 style23 s style24" rowspan="2">
              Check working PEASD with<br />
              Load 7.5-10 kg (In any one<br />
              coach)
            </td>
            <td class="column2 style25 null style26" rowspan="2"></td>
            <td class="column3 style37 s style36" rowspan="2">' . $coach_nos . '</td>
            <td class="column4 style27 null style28" rowspan="2"></td>
            <td class="column6 style15 n">13</td>
            <td class="column7 style9 s">' . $coach13 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_13 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_13 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_13 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_13 . '</td>
          </tr>
          <tr class="row20">
            <td class="column6 style15 n">14</td>
            <td class="column7 style9 s">' . $coach14 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_14 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_14 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_14 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_14 . '</td>
          </tr>
          <tr class="row21">
            <td class="column0 style21 n style22" rowspan="6">8</td>
            <td class="column1 style23 s style24" rowspan="6">
              Continuity test (Guard Van<br />
              valve Test)
            </td>
            <td class="column2 style23 s style24" rowspan="3">
              On operating guard<br />
              emergency valve<br />
              from front SLR BP-<br />
              0 kg/cm2 rear SLR<br />
              BP pressure will be<br />
              0 kg/cm2
            </td>
            <td class="column3 style35 s style36" rowspan="3">
              ' . $front_car_time1 . '<br />
              <br />
              ' . $front_car_time2 . '
            </td>
            <td class="column4 style27 null style28" rowspan="3"></td>
            <td class="column6 style15 n">15</td>
            <td class="column7 style9 s">' . $coach15 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_15 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_15 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_15 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_15 . '</td>
          </tr>
          <tr class="row22">
            <td class="column6 style15 n">16</td>
            <td class="column7 style9 s">' . $coach16 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_16 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_16 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_16 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_16 . '</td>
          </tr>
          <tr class="row23">
            <td class="column6 style15 n">17</td>
            <td class="column7 style9 s">' . $coach17 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_17 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_17 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_17 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_17 . '</td>
          </tr>
          <tr class="row24">
            <td class="column2 style23 s style24" rowspan="3">
              On operating guard<br />
              emergency valve<br />
              from rear SLR BP- 0<br />
              kg/cm2 front SLR<br />
              BP pressure will be<br />
              0 kg/cm2
            </td>
            <td class="column3 style35 s style36" rowspan="3">
              ' . $rear_car_time1 . '<br />
              <br />
              ' . $rear_car_time2 . '
            </td>
            <td class="column4 style27 null style28" rowspan="3"></td>
            <td class="column6 style15 n">18</td>
            <td class="column7 style9 s">' . $coach18 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_18 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_18 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_18 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_18 . '</td>
          </tr>
          <tr class="row25">
            <td class="column6 style15 n">19</td>
            <td class="column7 style9 s">' . $coach19 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_19 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_19 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_19 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_19 . '</td>
          </tr>
          <tr class="row26">
            <td class="column6 style15 n">20</td>
            <td class="column7 style9 s">' . $coach20 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_20 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_20 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_20 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_20 . '</td>
          </tr>
          <tr class="row27">
            <td class="column0 style21 n style22" rowspan="2">9</td>
            <td class="column1 style23 s style24" rowspan="2">
              Check the working of Hand<br />
              brake of both front &amp; rear<br />
              SLR
            </td>
            <td class="column2 style25 null style26" rowspan="2"></td>
            <td class="column3 style35 s style36" rowspan="2">
              ' . $ghbcable_ok . '<br />
              <br />
              ' . $ghbgreen_ok . '
            </td>
            <td class="column4 style27 null style28" rowspan="2"></td>
            <td class="column6 style15 n">21</td>
            <td class="column7 style9 s">' . $coach21 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_21 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_21 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_21 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_21 . '</td>
          </tr>
          <tr class="row28">
            <td class="column6 style15 n">22</td>
            <td class="column7 style9 s">' . $coach22 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_22 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_22 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_22 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_22 . '</td>
          </tr>
          <tr class="row29">
            <td class="column0 style21 n style29" rowspan="2">10</td>
            <td class="column1 style23 s style24" rowspan="2">
              Ensure manual release of<br />
              rake after completion of<br />
              RTR from release lever of<br />
              every coach
            </td>
            <td class="column2 style25 null style30" rowspan="2"></td>
            <td class="column3 style37 s style38" rowspan="2">' . $manrel_step2 . '</td>
            <td class="column4 style27 null style31" rowspan="2"></td>
            <td class="column6 style15 n">23</td>
            <td class="column7 style9 s">' . $coach23 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_23 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_23 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_23 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_23 . '</td>
          </tr>
          <tr class="row30">
            <td class="column6 style15 n">24</td>
            <td class="column7 style9 s">' . $coach24 . '</td>
            <td class="column8 style9 s">' . $ps_end_col1_24 . '</td>
            <td class="column9 style9 s">' . $ps_end_col2_24 . '</td>
            <td class="column10 style9 s">' . $ps_non_col1_24 . '</td>
            <td class="column11 style9 s">' . $ps_non_col2_24 . '</td>
          </tr>
          <tr class="row31">
            <td class="column0 style19 null style19" colspan="12"></td>
          </tr>
          <tr class="row32">
            <td class="column0 style20 s style20" colspan="12">
              Note-
              <span
                style="color: #000000; font-size: 10pt"
                >Ensure clearance of 5mm between Brake block and wheel during
                check.</span
              >
            </td>
          </tr>
        </tbody>
      </table>
    </body>

</html>';

    $mpdf->WriteHTML($html);

    // Output the PDF to a temporary file and store in session
    $pdfContent = $mpdf->Output('', 'S');
    $_SESSION['pdf_content'] = $pdfContent;
    $_SESSION['pdf_filename'] = 'annexure_' . $created_at . '.pdf'; // Store filename in session

    // Display the PDF in an iframe
    echo '<div class="container-fluid">';
    echo '<div class="row p-0">';
    echo '<div class="p-0" style="height: calc(100vh - 40px);">';
    echo '<iframe src="pdf-viewer.php" style="width: 100%; height: 100%; border: none;"></iframe>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    // Include the footer
    require_once __DIR__ . '/includes/footer.php';
    ?>
</body>

</html>