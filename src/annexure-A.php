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
        lhb01.draining_of_125l,
        lhb01.draining_of_75l,
        lhb01.draining_of_150l,
        lhb01.bp_strainer,
        lhb01.fp_strainer,
        lhb01.all_off,
        lhb01.front_pwr_car_fp,
        lhb01.rear_pwr_car_fp,
        lhb02.brake_released,
        lhb02.ar_chrg_empty,
        lhb02.cr_chrg_empty,
        lhb02.front_pwr_car_bp as fr_bp,
        lhb02.front_pwr_car_fp as fr_fp,
        lhb02.lslrd_pwr_car_bp,
        lhb02.lslrd_pwr_car_fp,
        lhb03.bp_value,
        lhb03.fp_value,
        lhb03.attended_any_leakage,
        lhb03.ar_tank_empty,
        lhb03.cr_tank_empty,
        lhb03.defect_persist,
        lhb04.full_brk_applied,
        lhb04.full_brk_rel_in_iso,
        lhb04.full_brk_rel_indic,
        lhb04.full_brk_apply_indic,
        lhb05.bp_pressure,
        lhb05.fp_pressure,
        lhb06.coach_no_marked_sick,
        lhb07.coach_nos,
        lhb08.front_car_time1,
        lhb08.rear_car_time1,
        lhb08.front_car_time2,
        lhb08.rear_car_time2,
        lhb09.ghbcable_ok,
        lhb09.ghbgreen_ok,
        lhb10.bp_leakage_value,
        lhb10.fp_leakage_value,
        lhb11.manrel_step2,
        lhb12.loose_component,
        lhb12.display_99,
        lhb12.perform_seq_test,
        lhb12.check_caliper_arms,
        lhb12.dv_release_time,
        lhb12.total_cylinder,
        lhb12.operative_cylinder,
        lhb12.percentage
    FROM train_maintenance_report tmr
    LEFT JOIN tbl_lhb_01 lhb01 ON tmr.id = lhb01.id
    LEFT JOIN tbl_lhb_02 lhb02 ON tmr.id = lhb02.id
    LEFT JOIN tbl_lhb_03 lhb03 ON tmr.id = lhb03.id
    LEFT JOIN tbl_lhb_04 lhb04 ON tmr.id = lhb04.id
    LEFT JOIN tbl_lhb_05 lhb05 ON tmr.id = lhb05.id
    LEFT JOIN tbl_lhb_06 lhb06 ON tmr.id = lhb06.id
    LEFT JOIN tbl_lhb_07 lhb07 ON tmr.id = lhb07.id
    LEFT JOIN tbl_lhb_08 lhb08 ON tmr.id = lhb08.id
    LEFT JOIN tbl_lhb_09 lhb09 ON tmr.id = lhb09.id
    LEFT JOIN tbl_lhb_10 lhb10 ON tmr.id = lhb10.id
    LEFT JOIN tbl_lhb_11 lhb11 ON tmr.id = lhb11.id
    LEFT JOIN tbl_lhb_12 lhb12 ON tmr.id = lhb12.id
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
$date_of_testing = htmlspecialchars($report['created_at'] ? date('d M, Y', strtotime($report['created_at'])) : '');
$load = htmlspecialchars($report['load'] ?? '');
$operator_name = htmlspecialchars($report['operator_name'] ?? '');
$draining_of_125l = htmlspecialchars($report['draining_of_125l'] ?? '');
$draining_of_75l = htmlspecialchars($report['draining_of_75l'] ?? '');
$draining_of_150l = htmlspecialchars($report['draining_of_150l'] ?? '');
$bp_strainer = htmlspecialchars($report['bp_strainer'] ?? '');
$fp_strainer = htmlspecialchars($report['fp_strainer'] ?? '');
$all_off = htmlspecialchars($report['all_off'] ?? '');
$front_pwr_car_fp = htmlspecialchars($report['front_pwr_car_fp'] ?? '');
$rear_pwr_car_fp = htmlspecialchars($report['rear_pwr_car_fp'] ?? '');
$brake_released = htmlspecialchars($report['brake_released'] ?? '');
$ar_chrg_empty = htmlspecialchars($report['ar_chrg_empty'] ?? '');
$cr_chrg_empty = htmlspecialchars($report['cr_chrg_empty'] ?? '');
$fr_bp = htmlspecialchars($report['fr_bp'] ?? '');
$fr_fp = htmlspecialchars($report['fr_fp'] ?? '');
$lslrd_pwr_car_bp = htmlspecialchars($report['lslrd_pwr_car_bp'] ?? '');
$lslrd_pwr_car_fp = htmlspecialchars($report['lslrd_pwr_car_fp'] ?? '');
$bp_value = htmlspecialchars($report['bp_value'] ?? '');
$fp_value = htmlspecialchars($report['fp_value'] ?? '');
$attended_any_leakage = htmlspecialchars($report['attended_any_leakage'] ?? '');
$ar_tank_empty = htmlspecialchars($report['ar_tank_empty'] ?? '');
$cr_tank_empty = htmlspecialchars($report['cr_tank_empty'] ?? '');
$defect_persist = htmlspecialchars($report['defect_persist'] ?? '');
$full_brk_applied = htmlspecialchars($report['full_brk_applied'] ?? '');
$full_brk_rel_in_iso = htmlspecialchars($report['full_brk_rel_in_iso'] ?? '');
$full_brk_rel_indic = htmlspecialchars($report['full_brk_rel_indic'] ?? '');
$full_brk_apply_indic = htmlspecialchars($report['full_brk_apply_indic'] ?? '');
$bp_pressure = htmlspecialchars($report['bp_pressure'] ?? '');
$fp_pressure = htmlspecialchars($report['fp_pressure'] ?? '');
$coach_no_marked_sick = htmlspecialchars($report['coach_no_marked_sick'] ?? '');
$coach_nos = htmlspecialchars($report['coach_nos'] ?? '');
$front_car_time1 = htmlspecialchars($report['front_car_time1'] ?? '');
$rear_car_time1 = htmlspecialchars($report['rear_car_time1'] ?? '');
$front_car_time2 = htmlspecialchars($report['front_car_time2'] ?? '');
$rear_car_time2 = htmlspecialchars($report['rear_car_time2'] ?? '');
$ghbcable_ok = htmlspecialchars($report['ghbcable_ok'] ?? '');
$ghbgreen_ok = htmlspecialchars($report['ghbgreen_ok'] ?? '');
$bp_leakage_value = htmlspecialchars($report['bp_leakage_value'] ?? '');
$fp_leakage_value = htmlspecialchars($report['fp_leakage_value'] ?? '');
$manrel_step2 = htmlspecialchars($report['manrel_step2'] ?? '');
$loose_component = htmlspecialchars($report['loose_component'] ?? '');
$display_99 = htmlspecialchars($report['display_99'] ?? '');
$perform_seq_test = htmlspecialchars($report['perform_seq_test'] ?? '');
$check_caliper_arms = htmlspecialchars($report['check_caliper_arms'] ?? '');
$dv_release_time = htmlspecialchars($report['dv_release_time'] ?? '');
$total_cylinder = htmlspecialchars($report['total_cylinder'] ?? '');
$operative_cylinder = htmlspecialchars($report['operative_cylinder'] ?? '');
$percentage = htmlspecialchars($report['percentage'] ?? '');
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
    <link rel="stylesheet" href="assets/css/annexure-A.css" />
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
        <col class="col0" />
        <col class="col1" />
        <col class="col2" />
        <col class="col3" />
        <col class="col4" />
        <tbody>
            <tr class="row0">
              <td class="column0 style35 s style35" colspan="5">Annexure-A</td>
            </tr>
            <tr class="row0">
              <td class="column0 style41 s style41" colspan="5">' . isset($_COOKIE['title']) ? htmlspecialchars($_COOKIE['title']) : '' . '</td>
            </tr>
            <tr class="row1">
                <td class="column0 style36 s style36" colspan="5">
                    FORMAT FOR AIR BRAKE RAKE TESTING ON RTR (LHB)<br />
                    (As per LHB CAMTECH Manual)
                </td>
            </tr>
            <tr class="row2">
                <td class="column0 style37 s style38" colspan="2">Train No: ' . $train_no . '</td>
                <td class="column2 style1 s">Load: ' . $load . '</td>
                <td class="column3 style37 s style37" colspan="2">Date: ' . $date_of_testing . '</td>
            </tr>
            <tr class="row3">
                <td class="column0 style39 s style40" colspan="5">Name of staffs: ' . $operator_name . '</td>
            </tr>
            <tr class="row4">
                <td class="column0 style2 s">S.N.</td>
                <td class="column1 style2 s">Description</td>
                <td class="column2 style2 s">Observation</td>
                <td class="column3 style2 s">Actual Value</td>
                <td class="column4 style2 s">Remarks</td>
            </tr>
            <tr class="row5">
                <td class="column0 style2 s">A</td>
                <td class="column1 style17 s style18" colspan="4">Rake Test</td>
            </tr>
            <tr class="row6">
                <td class="column0 style15 n style16" rowspan="6">1</td>
                <td class="column1 style19 s style20" rowspan="6">
                    Draining of Auxiliary Reservoirs/Strainers
                </td>
                <td class="column2 style3 s">125 L -</td>
                <td class="column3 style12 s">' . $draining_of_125l . '</td>
                <td class="column4 style14 null style14" rowspan="6"></td>
            </tr>
            <tr class="row7">
                <td class="column2 style3 s">75 L -</td>
                <td class="column3 style12 s">' . $draining_of_75l . '</td>
            </tr>
            <tr class="row8">
                <td class="column2 style3 s">150 L -</td>
                <td class="column3 style12 s">' . $draining_of_150l . '</td>
            </tr>
            <tr class="row9">
                <td class="column2 style3 s">BP Strainer -</td>
                <td class="column3 style12 s">' . $bp_strainer . '</td>
            </tr>
            <tr class="row10">
                <td class="column2 style3 s">FP Strainer -</td>
                <td class="column3 style12 s">' . $fp_strainer . '</td>
            </tr>
            <tr class="row11">
                <td class="column2 style3 s">
                    Ensure all WSPs of the rake in "OFF" condition after 10<br />
                    minutes of draining BP &amp; FP.
                </td>
                <td class="column3 style12 s">' . $all_off . '</td>
            </tr>
            <tr class="row12">
                <td class="column0 style15 n style16" rowspan="3">2</td>
                <td class="column1 style17 s style18" rowspan="3">
                    NRV check
                    <span style="color: #000000; font-size: 8pt">
                        (On charging BP line, FP gauge should show Nil<br />
                        pressure)
                    </span>
                </td>
                <td class="column2 style4 s">Pressure in FP :</td>
                <td class="column3 style12 null"></td>
                <td class="column4 style14 null style14" rowspan="3"></td>
            </tr>
            <tr class="row13">
                <td class="column2 style3 s">Front Power Car -</td>
                <td class="column3 style12 s">' . $front_pwr_car_fp . '</td>
            </tr>
            <tr class="row14">
                <td class="column2 style3 s">Rear Power Car -</td>
                <td class="column3 style12 s">' . $rear_pwr_car_fp . '</td>
            </tr>
            <tr class="row15">
                <td class="column0 style15 n style15" rowspan="3">3</td>
                <td class="column1 style21 s style22" rowspan="3">
                    Self Release Check<br />
                    Step -1 :
                    <span style="color: #000000; font-size: 8pt">
                        BP &amp; FP to be charged 5.0 &amp; 6.0 Kg/Cm2
                    </span>
                    <span style="font-weight: bold; color: #000000; font-size: 8pt">
                        <br />Step -2 :
                    </span>
                    <span style="color: #000000; font-size: 8pt">
                        RTR BP/FP palms to be disconnected.
                    </span>
                    <span style="font-weight: bold; color: #000000; font-size: 8pt">
                        <br />Step -3 :
                    </span>
                    <span style="color: #000000; font-size: 8pt">
                        Open the angle cocks to exhaust BP and FP
                    </span>
                    <span style="font-weight: bold; color: #000000; font-size: 8pt">
                        <br />
                    </span>
                    <span style="color: #000000; font-size: 8pt">
                        pressure and wait for 20-25 minutes
                    </span>
                </td>
                <td class="column2 style24 s style24">
                    Coaches in which Brakes found released -
                </td>
                <td class="column3 style24 s style24">' . $brake_released . '</td>
                <td class="column4 style26 null style27" rowspan="3"></td>
            </tr>
            <tr class="row17">
                <td class="column2 style10 s">(i) AR charge/empty -</td>
                <td class="column3 style12 s">' . $ar_chrg_empty . '</td>
            </tr>
            <tr class="row18">
                <td class="column2 style7 s">(ii) CR charge/empty -</td>
                <td class="column3 style12 s">' . $cr_chrg_empty . '</td>
            </tr>
            <tr class="row19">
                <td class="column0 style33 n style34" rowspan="2">4</td>
                <td class="column1 style31 s style32" rowspan="2">
                    Accuracy of BP/FP Gauge of front Power Car/LSLRD
                </td>
                <td class="column2 style29 s style30" rowspan="2">
                    Connect BP &amp; FP Master Gauges with dummy on free end<br />
                    of last vehicle and charge again BP and FP pressure.
                </td>
                <td class="column3 style8 s">
                    <span style="font-weight: bold; color: #000000; font-size: 8pt">
                        Front Power Car
                    </span>
                    <span style="color: #000000; font-size: 8pt">
                        <br />' . $fr_bp . '<br />
                        &nbsp;' . $fr_fp . '
                    </span>
                </td>
                <td class="column4 style11 null"></td>
            </tr>
            <tr class="row20">
                <td class="column3 style8 s">
                    <span style="font-weight: bold; color: #000000; font-size: 8pt">
                        LSLRD
                    </span>
                    <span style="color: #000000; font-size: 8pt">
                        <br />&nbsp;' . $lslrd_pwr_car_bp . '<br />
                        &nbsp;' . $lslrd_pwr_car_fp . '
                    </span>
                </td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row21">
                <td class="column0 style15 n style16" rowspan="2">5</td>
                <td class="column1 style17 s style18" rowspan="2">
                    Leakage Check
                    <span style="color: #000000; font-size: 8pt">
                        (before maintenance) BP &amp; FP to be<br />
                        charged to 5.0 &amp; 6.0 Kg/Cm2. Close BP &amp; FP angle cock for<br />
                        03 minutes
                    </span>
                </td>
                <td class="column2 style3 s">Attend leakage if any -</td>
                <td class="column3 style13 s">' . $attended_any_leakage . '</td>
                <td class="column4 style14 null style14" rowspan="2"></td>
            </tr>
            <tr class="row22">
                <td class="column2 style3 s">Leakage <= 0.6 Kg/Cm2 in 3 minutes -</td>
                <td class="column3 style8 s">
                    ' . $bp_value . '<br />
                    &nbsp;' . $fp_value . '
                </td>
            </tr>
            <tr class="row23">
                <td class="column0 style15 n style16" rowspan="3">6</td>
                <td class="column1 style17 s style18" rowspan="3">
                    Attention to Self released coaches
                </td>
                <td class="column2 style3 s">
                    (i) If AR tank found empty check for the leakage on back of<br />
                    the brake Panel.
                </td>
                <td class="column3 style13 s">&nbsp;' . $ar_tank_empty . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row24">
                <td class="column2 style3 s">
                    (ii) If CR tank found empty check for the leakage on CR<br />
                    tank, pipes &amp; test points of the brake panel.
                </td>
                <td class="column3 style13 s">&nbsp;' . $cr_tank_empty . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row25">
                <td class="column2 style3 s">
                    (iii) If defect persist, mark sick for SCTR test -
                </td>
                <td class="column3 style13 s">&nbsp;' . $defect_persist . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row26">
                <td class="column0 style6 n">7</td>
                <td class="column1 style4 s">
                    Leakage test by dropping 1.6 Kg/Cm2 in BP
                </td>
                <td class="column2 style3 s">
                    Leakage location to be pin-pointed using soap solution
                </td>
                <td class="column3 style13 s">&nbsp;' . $full_brk_applied . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row27">
                <td class="column0 style6 n">8</td>
                <td class="column1 style4 s">
                    Bogie Isolation test
                    <span style="color: #000000; font-size: 8pt">(All coaches)</span>
                </td>
                <td class="column2 style3 s">
                    Functional test of brake release through bogie isolation<br />
                    cocks on brake panel.
                </td>
                <td class="column3 style13 s">&nbsp;' . $full_brk_rel_in_iso . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row28">
                <td class="column0 style15 n style16" rowspan="2">9</td>
                <td class="column1 style17 s style18" rowspan="2">
                    Brake Indicator test
                    <span style="color: #000000; font-size: 8pt">(All coaches)</span>
                </td>
                <td class="column2 style3 s">
                    On brake application Indicator display RED-
                </td>
                <td class="column3 style13 s">&nbsp;' . $full_brk_rel_indic . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row29">
                <td class="column2 style3 s">
                    On brake release Indicator display GREEN-
                </td>
                <td class="column3 style13 s">&nbsp;' . $full_brk_apply_indic . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row30">
                <td class="column0 style6 n">10</td>
                <td class="column1 style4 s">
                    Check for any cross connection in BP &amp; FP pressure
                </td>
                <td class="column2 style3 s">
                    In Rear end Power Car-<br />
                    (i) BP=3.4 Kg/cm2-<br />
                    (ii) FP = 5.8-6.0 Kg/cm2-
                </td>
                <td class="column3 style8 s">
                    ' . $bp_pressure . '<br />
                    &nbsp;' . $fp_pressure . '
                </td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row31">
                <td class="column0 style6 n">11</td>
                <td class="column1 style4 s">Check for CR overcharging</td>
                <td class="column2 style3 s">If CR overcharged, mark sick</td>
                <td class="column3 style13 s">&nbsp;' . $coach_no_marked_sick . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row32">
                <td class="column0 style6 n">12</td>
                <td class="column1 style4 s">Check PEASD (Any 03 coaches)</td>
                <td class="column2 style3 s">Coach nos. -</td>
                <td class="column3 style13 s">&nbsp;' . $coach_nos . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row33">
                <td class="column0 style15 n style16" rowspan="2">13</td>
                <td class="column1 style17 s style18" rowspan="2">Continuity Test</td>
                <td class="column2 style3 s">
                    On operating Guard emergency valve from front Power<br />
                    Car, BP = 0 Kg/cm2 in 25-30 seconds in front Power Car<br />
                    and 40-50 seconds in rear Power Car.
                </td>
                <td class="column3 style8 s">
                    (i) ' . $front_car_time1 . '<br />
                    (ii) ' . $front_car_time2 . '
                </td>
                <td class="column4 style14 null style14" rowspan="2"></td>
            </tr>
            <tr class="row34">
                <td class="column2 style3 s">
                    On operating Guard emergency valve from rear Power Car,<br />
                    BP = 0 Kg/cm2 in 25-30 seconds in rear Power Car and 40-<br />
                    50 seconds in front Power Car.
                </td>
                <td class="column3 style8 s">
                    (i) ' . $rear_car_time1 . '<br />
                    (ii) ' . $rear_car_time2 . '
                </td>
            </tr>
            <tr class="row35">
                <td class="column0 style6 n">14</td>
                <td class="column1 style4 s">
                    Check Hand Brake of both Power Car/LSLRD
                </td>
                <td class="column2 style3 s">
                    (i) Condition &amp; mounting of hand brake cables.<br />
                    (ii) Application and release.
                </td>
                <td class="column3 style8 s">
                    (i) ' . $ghbcable_ok . '<br />
                    (ii) ' . $ghbgreen_ok . '
                </td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row36">
                <td class="column0 style6 n">15</td>
                <td class="column1 style4 s">
                    Monitor for Leakage (after work)
                    <span style="color: #000000; font-size: 8pt">
                        (After BP-<br />
                        5.0 Kg/Cm2 &amp; FP - 6.0 Kg/Cm2 for 3 minutes)
                    </span>
                </td>
                <td class="column2 style3 s">
                    Leakage<= 0.6 Kg/Cm2 in 3 Minutes-
                </td>
                <td class="column3 style8 s">
                    ' . $bp_leakage_value  . '<br />
                    &nbsp;' . $fp_leakage_value . '
                </td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row37">
                <td class="column0 style6 n">16</td>
                <td class="column1 style4 s">Manual Release of rake</td>
                <td class="column2 style3 s">Ensure manual release of all DVs</td>
                <td class="column3 style13 s">' . $manrel_step2 . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row38">
                <td class="column0 style2 s">B</td>
                <td class="column1 style4 s">WSP Testing</td>
                <td class="column2 style5 null"></td>
                <td class="column3 style13 null"></td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row39">
                <td class="column0 style6 n">1</td>
                <td class="column1 style3 s">Check for any loose WSP components</td>
                <td class="column2 style5 null"></td>
                <td class="column3 style13 s">' . $loose_component . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row40">
                <td class="column0 style6 n">2</td>
                <td class="column1 style3 s">Check WSP display 99</td>
                <td class="column2 style5 null"></td>
                <td class="column3 style13 s">' . $display_99 . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row41">
                <td class="column0 style6 n">3</td>
                <td class="column1 style3 s">
                    Perform Dump Valve test for operating in sequence
                </td>
                <td class="column2 style5 null"></td>
                <td class="column3 style13 s">' . $perform_seq_test . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row42">
                <td class="column0 style2 s">C</td>
                <td class="column1 style10 s">
                    Check for the free movement of Caliper arms by physical Shaking the brake caliper units.
                </td>
                <td class="column2 style7 null"></td>
                <td class="column3 style13 s">' . $check_caliper_arms . '</td>
                <td class="column4 style7 null"></td>
            </tr>
            <tr class="row43">
                <td class="column0 style6 n">17</td>
                <td class="column1 style4 s">DV release time (write "within limit" (max 20 sec) or specify if any out of limit)</td>
                <td class="column2 style3 s"></td>
                <td class="column3 style13 s">' . $dv_release_time . '</td>
                <td class="column4 style9 null"></td>
            </tr>
            <tr class="row44">
                <td class="column0 style6 n">18</td>
                <td class="column1 style4 s">Brake Power</td>
                <td class="column2 style3 s">Total Cylinder: ' . $total_cylinder . '</td>
                <td class="column3 style13 s">Operative Cylinder:' . $operative_cylinder . '</td>
                <td class="column4 style9 null">Percentage: ' . $percentage . '</td>
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