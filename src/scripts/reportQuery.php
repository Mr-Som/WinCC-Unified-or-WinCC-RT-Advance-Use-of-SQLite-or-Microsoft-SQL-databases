<?php 
    $query = "
        SELECT 
            tmr.*,
            t01.*,
            t02.*,
            t03.*,
            t04.*,
            t05.*,
            t06.*,
            t07.*
        FROM train_maintenance_report tmr
        LEFT JOIN tbl_01 t01 ON tmr.id = t01.id
        LEFT JOIN tbl_02 t02 ON tmr.id = t02.id
        LEFT JOIN tbl_03 t03 ON tmr.id = t03.id
        LEFT JOIN tbl_04 t04 ON tmr.id = t04.id
        LEFT JOIN tbl_05 t05 ON tmr.id = t05.id
        LEFT JOIN tbl_06 t06 ON tmr.id = t06.id
        LEFT JOIN tbl_07 t07 ON tmr.id = t07.id
        WHERE tmr.id = :id
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $reportId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
      die('Report not found.');
    }

    // Map variables
    $train_no = htmlspecialchars($result['train_no'] ?? '');
    $load = htmlspecialchars($result['load'] ?? '');
    $date_of_testing = htmlspecialchars($result['date_of_testing'] ?? '');
    $pipe_type = htmlspecialchars($result['pipe_type'] ?? '');
    $staff_no = htmlspecialchars($result['staff_no'] ?? '');
    $road_no = htmlspecialchars($result['road_no'] ?? '');
    $wagon_type = htmlspecialchars($result['wagon_type'] ?? '');

    // tbl_01: Brake Power Pressure and Flow
    $bp_1 = htmlspecialchars($result['bp_1'] ?? '');
    $fp_1 = htmlspecialchars($result['fp_1'] ?? '');
    $bp_1_status = htmlspecialchars($result['bp_1_status'] ?? '');
    $fp_1_status = htmlspecialchars($result['fp_1_status'] ?? '');

    $bp_2 = htmlspecialchars($result['bp_2'] ?? '');
    $fp_2 = htmlspecialchars($result['fp_2'] ?? '');
    $bp_2_status = htmlspecialchars($result['bp_2_status'] ?? '');
    $fp_2_status = htmlspecialchars($result['fp_2_status'] ?? '');

    // tbl_02: Leakage
    $leakage_bp = htmlspecialchars($result['leakage_bp'] ?? '');
    $leakage_fp = htmlspecialchars($result['leakage_fp'] ?? '');
    $leakage_bp_status = htmlspecialchars($result['leakage_bp_status'] ?? '');
    $leakage_fp_status = htmlspecialchars($result['leakage_fp_status'] ?? '');

    // tbl_03: Full Brake Application
    $full_brk_app_status = htmlspecialchars($result['full_brk_app_status'] ?? '');
    $full_brk_app_remark = htmlspecialchars($result['full_brk_app_remark'] ?? '');

    // tbl_04: Release Brake Application
    $rel_brk_app_status = htmlspecialchars($result['rel_brk_app_status'] ?? '');
    $rel_brk_app_remark = htmlspecialchars($result['rel_brk_app_remark'] ?? '');

    // tbl_05: Emergency Brake Application
    $emg_brk_app_status = htmlspecialchars($result['emg_brk_app_status'] ?? '');
    $emg_brk_app_remark = htmlspecialchars($result['emg_brk_app_remark'] ?? '');

    // tbl_06: Release Emergency Brake Application
    $rel_emg_brk_app_status = htmlspecialchars($result['rel_emg_brk_app_status'] ?? '');
    $rel_emg_brk_app_remark = htmlspecialchars($result['rel_emg_brk_app_remark'] ?? '');

    // tbl_07: Observations
    $observe_value = htmlspecialchars($result['observe_value'] ?? '');
    $reord_value = htmlspecialchars($result['reord_value'] ?? '');
    $percent_value = htmlspecialchars($result['percent_value'] ?? '');
    $iop_wagons = htmlspecialchars($result['iop_wagons'] ?? '');
    $defects = htmlspecialchars($result['defects'] ?? '');
    $action = htmlspecialchars($result['action'] ?? '');

    $created_at = $result['created_at'] ? date('Y-m-d_H-i-s', strtotime($result['created_at'])) : date('Y-m-d_H-i-s');
    ?>