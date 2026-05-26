<?php

require_once __DIR__ . '/includes/header.php';
include __DIR__ . '/config/database.php';
$pdo = Database::getConnection();
// Check if an ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die('Invalid or missing report ID.');
}
$reportId = (int)$_GET['id'];
?>
</head>

<body class="bg-secondary2">
  <?php require_once __DIR__ . '/includes/about.modal.php'; ?>
  <?php require_once __DIR__ . '/includes/help.modal.php'; ?>
  <?php require_once __DIR__ . '/includes/navbar.php'; ?>
  <?php require_once __DIR__ . '/scripts/reportQuery.php'; ?>
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

    $html = '<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="./assets/css/report.min.css" />
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
      <tbody>
        <tr class="row0">
          <td class="column0 style12 null style12" colspan="5"></td>
        </tr>
        <tr class="row1">
          <td class="column0 style13 s style13" colspan="5">
            RAKE TEST REPORT
          </td>
        </tr>
        <tr class="row2">
          <td class="column0 style9 s style14" rowspan="2">
            TRAIN NO.:
            <span style="color: #000000; font-size: 10pt"
              >' . $train_no . '</span
            >
          </td>
          <td class="column1 style4 s">
            <span style="font-weight: bold; color: #000000; font-size: 10pt"
              >LOAD:</span
            ><span style="color: #000000; font-size: 10pt"> ' . $load . '</span>
          </td>
          <td class="column2 style3 s">
            Test Date :
            <span style="color: #000000; font-size: 10pt; font-weight: normal"
              >' . $date_of_testing . '</span
            >
          </td>
          <td class="column3 style3 s">
            PIPE TYPE:
            <span style="color: #000000; font-size: 10pt; font-weight: normal"
              >' . $pipe_type . '</span
            >
          </td>
          <td class="column4 style4 null"></td>
        </tr>
        <tr class="row3">
          <td class="column1 style3 s">
            STAFF T. NO.:<span
              style="color: #000000; font-size: 10pt; font-weight: normal"
            >
              ' . $staff_no . '</span
            >
          </td>
          <td class="column2 style3 s">
            ROAD NO.:
            <span style="color: #000000; font-size: 10pt; font-weight: normal"
              >' . $road_no . '</span
            >
          </td>
          <td class="column3 style3 s">
            TYPE OF WAGON:
            <span style="color: #000000; font-size: 10pt; font-weight: normal"
              >' . $wagon_type . '</span
            >
          </td>
          <td class="column4 style4 null"></td>
        </tr>
        <tr class="row4">
          <td class="column0 style15 null style15" colspan="5"></td>
        </tr>
        <tr class="row5">
          <td class="column0 style5 s">ITEM</td>
          <td class="column1 style5 s">TEST</td>
          <td class="column2 style5 s">SPECIFIED VALUE</td>
          <td class="column3 style5 s">ACTUAL VALUE</td>
          <td class="column4 style5 s">REMARKS</td>
        </tr>
        <tr class="row6">
          <td class="column0 style5 n">1</td>
          <td class="column1 style6 s">
            <span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              >NRV TEST:</span
            ><span style="color: #000000; font-size: 10pt"
              ><br />
              <br /> </span
            ><span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              >1.1) </span
            ><span style="color: #000000; font-size: 10pt"
              >Both BP &amp; FP<br />
              a) BP PRESSURE<br />
              b) FP PRESSURE<br />
              <br /> </span
            ><span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              >1.2) </span
            ><span style="color: #000000; font-size: 10pt"
              >PRESSURE AT LAST WAGON<br />
              a) Brake Pipe (Minimum)<br />
              <br />
              <br />
              b) Feed Pipe (Minimum)<br />
            </span>
          </td>
          <td class="column2 style6 s">
            <br />
            <br />
            <br />
            BP = 5.0 ± 0.1 kg/cm²<br />
            FP = 6.0 ± 0.1 kg/cm²<br />
            <br />
            <br />
            Upto 56 Wagons 4.8 kg/cm²<br />
            Beyond 56 Wagons 4.7 kg/cm²<br />
            <br />
            Upto 56 Wagons 5.8 kg/cm²<br />
            Beyond 56 Wagons 4.7 kg/cm²
          </td>
          <td class="column3 style6 s">
            <br />
            <br />
            <br />
            ' . $bp_1 . ' kg/cm²<br />
            ' . $fp_1 . ' kg/cm²<br />
            <br />
            <br />
            ' . $bp_2 . ' kg/cm²<br />
            <br />
            ' . $fp_2 . ' kg/cm²
          </td>
          <td class="column4 style6 s">
            <br />
            <br />
            <br />
            ' . $bp_1_status . ' <br />
            ' . $fp_1_status . ' <br />
            <br />
            <br />
            ' . $bp_2_status . '<br />
            <br />
            ' . $fp_2_status . '
          </td>
        </tr>
        <tr class="row7">
          <td class="column0 style5 n">2</td>
          <td class="column1 style7 s">
            Leakage Rate:<br />
            <br />
            2.1)
            <span
              style="
                color: #000000;

                font-size: 10pt;
                font-weight: normal;
              "
              >Brake Pipe</span
            ><span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              ><br />
              <br />
              2.2) </span
            ><span
              style="
                color: #000000;

                font-size: 10pt;
                font-weight: normal;
              "
              >Feed Pipe</span
            >
          </td>
          <td class="column2 style6 s">
            <br />
            <br />
            Less than 0.25 kg/cm² / min<br />
            <br />
            Less than 0.25 kg/cm² / min
          </td>
          <td class="column3 style6 s">
            <br />
            <br />
            ' . $leakage_bp . ' kg/cm² / min<br />
            <br />
            ' . $leakage_fp . ' kg/cm² / min
          </td>
          <td class="column4 style6 s">
            <br />
            <br />
            ' . $leakage_bp_status . ' <br />
            <br />
            ' . $leakage_fp_status . '
          </td>
        </tr>
        <tr class="row8">
          <td class="column0 style5 n">3</td>
          <td class="column1 style7 s">
            Service Application Test:<br />
            <br />
            3.1)
            <span
              style="
                color: #000000;

                font-size: 10pt;
                font-weight: normal;
              "
              >Brake Application when BP Pressure reduced between 1.3 to 1.6
              kg/cm²</span
            >
          </td>
          <td class="column2 style6 s">
            <br />
            <br />
            Brake Should Apply<br />
            <br />
          </td>
          <td class="column3 style6 s">
            <br />
            <br />
            ' . $full_brk_app_status . '<br />
            <br />
          </td>
          <td class="column4 style6 s">
            <br />
            <br />
            ' . $full_brk_app_remark . '<br />
            <br />
          </td>
        </tr>
        <tr class="row9">
          <td class="column0 style5 n">4</td>
          <td class="column1 style7 s">
            Release Service Application Test:<br />
            <br />
            4.1)
            <span
              style="
                color: #000000;

                font-size: 10pt;
                font-weight: normal;
              "
              >Releasing of Brake when BP Pressure charge upto 5.0 kg/cm²</span
            >
          </td>
          <td class="column2 style6 s">
            <br />
            <br />
            Piston should be fully inside the<br />
            Brake Cylinder
          </td>
          <td class="column3 style6 s">
            <br />
            <br />
            ' . $rel_brk_app_status . '<br />
          </td>
          <td class="column4 style6 s">
            <br />
            <br />
            ' . $rel_brk_app_remark . '<br />
          </td>
        </tr>
        <tr class="row10">
          <td class="column0 style5 n">5</td>
          <td class="column1 style7 s">
            Emergency brake Application &amp; Release<br />
            <br />
            5.1)
            <span
              style="
                color: #000000;

                font-size: 10pt;
                font-weight: normal;
              "
              >Emergency brake Application<br />
              Brake Position<br />
              <br /> </span
            ><span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              >5.2)</span
            ><span
              style="
                color: #000000;

                font-size: 10pt;
                font-weight: normal;
              "
            >
              Release of Emergency brake Application Brake Position</span
            >
          </td>
          <td class="column2 style6 s">
            <br />
            <br />
            <br />
            Brake should apply<br />
            <br />
            <br />
            Brake should release<br />
          </td>
          <td class="column3 style6 s">
            <br />
            <br />
            <br />
            ' . $emg_brk_app_status . '<br />
            <br />
            <br />
            ' . $rel_emg_brk_app_status . '<br />
          </td>
          <td class="column4 style6 s">
            <br />
            <br />
            <br />
            ' . $emg_brk_app_remark . '<br />
            <br />
            <br />
            ' . $rel_emg_brk_app_remark . '
          </td>
        </tr>
        <tr class="row11">
          <td class="column0 style5 n">6</td>
          <td class="column1 style6 s">
            <span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              >Piston Stroke</span
            ><span style="color: #000000; font-size: 10pt"
              ><br />
              <br /> </span
            ><span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              >6.1)</span
            ><span style="color: #000000; font-size: 10pt">
              Observe Piston Stroke of<br />
              Brake Cylinder<br />
              <br />
              <br /> </span
            ><span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              >6.2) </span
            ><span style="color: #000000; font-size: 10pt"
              >Record the Piston Stroke<br />
              <br />
              <br /> </span
            ><span
              style="
                font-weight: bold;
                color: #000000;

                font-size: 10pt;
              "
              >6.3)</span
            ><span style="color: #000000; font-size: 10pt">
              Brake Cylinder Operating<br />
              Percentage</span
            >
          </td>
          <td class="column2 style6 s">
            <br />
            <br />
            Piston in Applied Position and Brake Blocks are meeting the
            wheels<br />
            <br />
            Piston Stroke should be<br />
            within specified limit<br />
            <br />
            Prescribed as per BPC Rule
          </td>
          <td class="column3 style6 s">
            <br />
            <br />
            ' . $observe_value . '<br />
            <br />
            <br />
            ' . $reord_value . '<br />
            <br />
            <br />
            ' . $percent_value . '
          </td>
          <td class="column4 style8 null"></td>
        </tr>
        <tr class="row12">
          <td class="column0 style9 s style9" colspan="5">REMARKS</td>
        </tr>
        <tr class="row13">
          <td class="column0 style16 s style16" colspan="2">IOP WAGON NO</td>
          <td class="column2 style17 s style17" colspan="3">
            ' . $iop_wagons . '
          </td>
        </tr>
        <tr class="row14">
          <td class="column0 style16 s style16" colspan="2">DEFECTS</td>
          <td class="column2 style17 s style17" colspan="3">' . $defects . '</td>
        </tr>
        <tr class="row15">
          <td class="column0 style16 s style16" colspan="2">IOP WAGON NO</td>
          <td class="column2 style17 s style17" colspan="3">' . $action . '</td>
        </tr>
        <tr class="row16">
          <td class="column0 style10 s style11" colspan="5">
            <br />
            SIGNATURE
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
';

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