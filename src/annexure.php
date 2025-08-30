<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//require_once __DIR__ . '/includes/auth-check.php';
require_once __DIR__ . '/includes/header.php';
include __DIR__ . '/config/database.php';
$pdo = Database::getConnection();

// Fetch data from the database
$stmt = $pdo->query("SELECT * FROM train_maintenance_report");
$trains = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="assets/css/annexure-B/style.css">
</head>

<body>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width: 100%;">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <tbody>
            <tr class="row0">
                <td class="column0 style1 s style1" colspan="11">Annexure-B</td>
            </tr>
            <tr class="row1">
                <td class="column0 style2 s style2" colspan="11">Format for Air Brake Rake Testing on RTR (ICF Coaches)</td>
            </tr>
            <tr class="row2">
                <td class="column0 style3 s style3" colspan="11">(As per CAMTECH Manual)</td>
            </tr>
            <tr class="row3">
                <td class="column0 style4 null style4 hi-4" colspan="11"></td>
            </tr>
            <tr class="row4">
                <td class="column0 style5 s style6" colspan="2">Train No.</td>
                <td class="column2 style7 s">Load</td>
                <td class="column3 style8 s">Date</td>
                <td class="column4 style9 null style9" rowspan="27"></td>
                <td class="column5 style10 s style10" rowspan="3">SN</td>
                <td class="column6 style11 s style11" rowspan="3">Coach No</td>
                <td class="column7 style11 s style11" colspan="4">Piston Stroke</td>
            </tr>
            <tr class="row5">
                <td class="column0 style5 s style12" colspan="4">Name of Staff:</td>
                <td class="column7 style13 s style13" colspan="2" rowspan="2">PEASD<br />
                    END</td>
                <td class="column9 style13 s style13" colspan="2" rowspan="2">Non<br />
                    PEASD<br />
                    END</td>
            </tr>
            <tr class="row6">
                <td class="column0 style14 s">SN</td>
                <td class="column1 style15 s">Description</td>
                <td class="column2 style15 s">Observation</td>
                <td class="column3 style16 s">Remarks</td>
            </tr>
            <tr class="row7">
                <td class="column0 style17 n">1</td>
                <td class="column1 style7 s">Draining of Aux. reservoir</td>
                <td class="column2 style45 s">200 L</td>
                <td class="column3 style18 null"></td>
                <td class="column5 style19 n">1</td>
                <td class="column6 style19 null"></td>
                <td class="column7 style19 null"></td>
                <td class="column8 style19 null"></td>
                <td class="column9 style19 null"></td>
                <td class="column10 style20 null"></td>
            </tr>
            <tr class="row8">
                <td class="column0 style21 n style25" rowspan="2">2</td>
                <td class="column1 style34 s style35" rowspan="2">Visual inspection of BP/FP<br />
                    coupling, suspension<br />
                    brackets and APD</td>
                <td class="column2 style22 null style26" rowspan="2"></td>
                <td class="column3 style23 null style27" rowspan="2"></td>
                <td class="column5 style24 n">2</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row9">
                <td class="column5 style19 n">3</td>
                <td class="column6 style19 null"></td>
                <td class="column7 style19 null"></td>
                <td class="column8 style19 null"></td>
                <td class="column9 style19 null"></td>
                <td class="column10 style20 null"></td>
            </tr>
            <tr class="row10">
                <td class="column0 style28 n style32" rowspan="2">3</td>
                <td class="column1 style34 s style35" rowspan="2">Greasing of moving parts-<br />
                    brake rigging system (if<br />
                    required)</td>
                <td class="column2 style22 null style26" rowspan="2"></td>
                <td class="column3 style23 null style27" rowspan="2"></td>
                <td class="column5 style29 n">4</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style30 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row11">
                <td class="column5 style29 n">5</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style29 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row12">
                <td class="column0 style17 n">4</td>
                <td class="column1 style44 s">Accuracy of BP/FP gauge of<br />
                    front SLRD</td>
                <td class="column2 style45 s">BP- 5 kg/cm2<br />
                    FP- 6 kg/cm2</td>
                <td class="column3 style33 null"></td>
                <td class="column5 style29 n">6</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style29 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row13">
                <td class="column0 style28 n style32" rowspan="2">5</td>
                <td class="column1 style34 s style35" rowspan="2">Leakage Test:<br />
                    (a) Brake Pipe<br />
                    (b) Feed Pipe</td>
                <td class="column2 style34 s style35" rowspan="2">0.2 kg/cm2/min</td>
                <td class="column3 style23 null style27" rowspan="2"></td>
                <td class="column5 style29 n">7</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style30 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row14">
                <td class="column5 style29 n">8</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style29 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row15">
                <td class="column0 style36 n style37" rowspan="4">6</td>
                <td class="column1 style34 s style35" rowspan="4">Service Application and<br />
                    release test :<br />
                    (a) Brake application when<br />
                    B.P. pressure reduced to<br />
                    1.5kg/cm2<br />
                    (b)Observe Piston stroke of<br />
                    brake cylinder<br />
                    (C) Record the piston stroke</td>
                <td class="column2 style34 s style35" rowspan="4">Brake should apply<br />
                    <br />
                    Piston in applied<br />
                    position
                </td>
                <td class="column3 style23 null style27" rowspan="4"></td>
                <td class="column5 style29 n">9</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style30 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row16">
                <td class="column5 style29 n">10</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style30 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row17">
                <td class="column5 style29 n">11</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style30 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row18">
                <td class="column5 style29 n">12</td>
                <td class="column6 style29 null"></td>
                <td class="column7 style29 null"></td>
                <td class="column8 style29 null"></td>
                <td class="column9 style29 null"></td>
                <td class="column10 style31 null"></td>
            </tr>
            <tr class="row19">
                <td class="column0 style28 n style32" rowspan="2">7</td>
                <td class="column1 style34 s style35" rowspan="2">Check working PEASD with<br />
                    Load 7.5-10 kg (In any one<br />
                    coach)</td>
                <td class="column2 style22 null style26" rowspan="2"></td>
                <td class="column3 style23 null style27" rowspan="2"></td>
                <td class="column5 style24 n">13</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row20">
                <td class="column5 style24 n">14</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row21">
                <td class="column0 style28 n style32" rowspan="6">8</td>
                <td class="column1 style34 s style35" rowspan="6">Continuity test (Guard Van<br />
                    valve Test)</td>
                <td class="column2 style34 s style35" rowspan="3">On operating guard<br />
                    emergency valve<br />
                    from front SLR BP-<br />
                    0 kg/cm2 rear SLR<br />
                    BP pressure will be<br />
                    0 kg/cm2</td>
                <td class="column3 style23 null style27" rowspan="3"></td>
                <td class="column5 style24 n">15</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row22">
                <td class="column5 style24 n">16</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row23">
                <td class="column5 style24 n">17</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row24">
                <td class="column2 style34 s style35" rowspan="3">On operating guard<br />
                    emergency valve<br />
                    from rear SLR BP- 0<br />
                    kg/cm2 front SLR<br />
                    BP pressure will be<br />
                    0 kg/cm2</td>
                <td class="column3 style23 null style27" rowspan="3"></td>
                <td class="column5 style24 n">18</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row25">
                <td class="column5 style24 n">19</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row26">
                <td class="column5 style24 n">20</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row27">
                <td class="column0 style28 n style32" rowspan="2">9</td>
                <td class="column1 style34 s style35" rowspan="2">Check the working of Hand<br />
                    brake of both front &amp; rear<br />
                    SLR</td>
                <td class="column2 style22 null style26" rowspan="2"></td>
                <td class="column3 style23 null style27" rowspan="2"></td>
                <td class="column5 style24 n">21</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row28">
                <td class="column5 style24 n">22</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row29">
                <td class="column0 style28 n style39" rowspan="2">10</td>
                <td class="column1 style34 s style35" rowspan="2">Ensure manual release of<br />
                    rake after completion of<br />
                    RTR from release lever of<br />
                    every coach</td>
                <td class="column2 style22 null style40" rowspan="2"></td>
                <td class="column3 style23 null style41" rowspan="2"></td>
                <td class="column5 style24 n">23</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row30">
                <td class="column5 style24 n">24</td>
                <td class="column6 style24 null"></td>
                <td class="column7 style24 null"></td>
                <td class="column8 style24 null"></td>
                <td class="column9 style24 null"></td>
                <td class="column10 style24 null"></td>
            </tr>
            <tr class="row31">
                <td class="column0 style42 null style42 hi-4" colspan="11"></td>
            </tr>
            <tr class="row32">
                <td class="column0 style43 s style43" colspan="11">Note- <span class="fw-normal" style="color:#000000; font-size:10pt">Ensure clearance of 5mm between Brake block and wheel during check.</span></td>
            </tr>
        </tbody>
    </table>
</body>

</html>';
        $mpdf->WriteHTML($html);

        // Output the PDF to a temporary file
        // Capture PDF content
        $pdfContent = $mpdf->Output('', 'S');
        $_SESSION['pdf_content'] = $pdfContent;

        // Create a div to contain the PDF viewer with a responsive height
        echo '<div class="container mt-4 mb-4">
            <div class="row">
                <div class="col-12">
                    <div style="height: 80vh;">
                        <iframe src="pdf-viewer.php" 
                            style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>';

        // Close the container-fluid div
        echo '</div>';

        // Include the footer
        require_once __DIR__ . '/includes/footer.php';
        ?>
</body>

</html>