-- Demo Data for Train Maintenance Report System

-- 1. Insert into train_maintenance_report
-- Record 1
INSERT INTO train_maintenance_report (id, train_no, date_of_testing, load, staff_no, road_no, wagon_type, pipe_type)
VALUES (1, '12345', '2023-10-27', '58 BOXN', 'EMP001', 'CR 10101', 'LHB', 'Twin Pipe');

-- Record 2
INSERT INTO train_maintenance_report (id, train_no, date_of_testing, load, staff_no, road_no, wagon_type, pipe_type)
VALUES (2, '67890', '2023-10-28', '45 BCN', 'EMP002', 'WR 20202', 'ICF', 'Single Pipe');


-- 2. Insert into tbl_01 (Brake Power Pressure)
-- Record 1 (Linked to ID 1)
INSERT INTO tbl_01 (id, bp_1, fp_1, bp_1_status, fp_1_status, bp_2, fp_2, bp_2_status, fp_2_status)
VALUES (1, 5.0, 6.0, 'OK', 'OK', 4.8, 5.8, 'OK', 'OK');

-- Record 2 (Linked to ID 2)
INSERT INTO tbl_01 (id, bp_1, fp_1, bp_1_status, fp_1_status, bp_2, fp_2, bp_2_status, fp_2_status)
VALUES (2, 4.9, 5.9, 'OK', 'OK', 4.7, 5.7, 'OK', 'OK');


-- 3. Insert into tbl_02 (Leakage)
-- Record 1
INSERT INTO tbl_02 (id, leakage_bp, leakage_fp, leakage_bp_status, leakage_fp_status)
VALUES (1, 0.1, 0.1, 'Pass', 'Pass');

-- Record 2
INSERT INTO tbl_02 (id, leakage_bp, leakage_fp, leakage_bp_status, leakage_fp_status)
VALUES (2, 0.2, 0.15, 'Pass', 'Pass');


-- 4. Insert into tbl_03 (Full Brake Application)
-- Record 1
INSERT INTO tbl_03 (id, full_brk_app_bc, full_brk_app_time, full_brk_app_status, full_brk_app_remark)
VALUES (1, 3.8, 5, 'Applied', 'Normal Application');

-- Record 2
INSERT INTO tbl_03 (id, full_brk_app_bc, full_brk_app_time, full_brk_app_status, full_brk_app_remark)
VALUES (2, 3.6, 6, 'Applied', 'Slight delay');


-- 5. Insert into tbl_04 (Release Brake Application)
-- Record 1
INSERT INTO tbl_04 (id, rel_brk_app_time, rel_brk_app_status, rel_brk_app_remark)
VALUES (1, 45, 'Released', 'Piston fully inside');

-- Record 2
INSERT INTO tbl_04 (id, rel_brk_app_time, rel_brk_app_status, rel_brk_app_remark)
VALUES (2, 60, 'Released', 'Slow Release');


-- 6. Insert into tbl_05 (Emergency Brake Application)
-- Record 1
INSERT INTO tbl_05 (id, emg_brk_app_bc, emg_brk_app_time, emg_brk_app_status, emg_brk_app_remark)
VALUES (1, 3.8, 3, 'Applied', 'Instant Application');

-- Record 2
INSERT INTO tbl_05 (id, emg_brk_app_bc, emg_brk_app_time, emg_brk_app_status, emg_brk_app_remark)
VALUES (2, 3.7, 4, 'Applied', 'Good');


-- 7. Insert into tbl_06 (Release Emergency Brake Application)
-- Record 1
INSERT INTO tbl_06 (id, rel_emg_brk_app_time, rel_emg_brk_app_status, rel_emg_brk_app_remark)
VALUES (1, 15, 'Released', 'Quick Release');

-- Record 2
INSERT INTO tbl_06 (id, rel_emg_brk_app_time, rel_emg_brk_app_status, rel_emg_brk_app_remark)
VALUES (2, 20, 'Released', 'Normal');


-- 8. Insert into tbl_07 (Observations)
-- Record 1
INSERT INTO tbl_07 (id, observe_value, reord_value, percent_value, defects, action, iop_wagons)
VALUES (1, '130 mm', '130 mm', '100', 'None', 'Fit for service', 'All Wagons');

-- Record 2
INSERT INTO tbl_07 (id, observe_value, reord_value, percent_value, defects, action, iop_wagons)
VALUES (2, '125 mm', '130 mm', '95', 'Minor leakage in Hose', 'Replaced Hose', 'Wagon 10');
