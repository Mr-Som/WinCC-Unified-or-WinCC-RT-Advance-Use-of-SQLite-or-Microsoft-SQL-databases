CREATE TABLE train_maintenance_report (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    train_no TEXT NOT NULL,
    train_name TEXT NOT NULL,
    date_of_testing DATE NOT NULL,
    washing_pit_no INTEGER NOT NULL,
    shift TEXT NOT NULL,
    sse TEXT NOT NULL,
    operator_name TEXT NOT NULL,
    pipe_type TEXT NOT NULL,
    rake_type TEXT NOT NULL,
    load TEXT NOT NULL,
    coach_type TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tbl_lhb_01 (
    id INTEGER PRIMARY KEY, 
    draining_of_125l TEXT,
    draining_of_75l TEXT,
    draining_of_150l TEXT,
    bp_strainer TEXT,
    fp_strainer TEXT,
    all_off TEXT,
    front_pwr_car_fp DECIMAL(10,2),
    rear_pwr_car_fp DECIMAL(10,2),
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_02 (
    id INTEGER PRIMARY KEY, 
    brake_released TEXT,
    ar_chrg_empty TEXT,
    cr_chrg_empty TEXT,
    front_pwr_car_bp DECIMAL(10,2),
    front_pwr_car_fp DECIMAL(10,2),
    lslrd_pwr_car_bp DECIMAL(10,2),
    lslrd_pwr_car_fp DECIMAL(10,2),
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_03 (
    id INTEGER PRIMARY KEY, 
    bp_value DECIMAL(10,2),
    fp_value DECIMAL(10,2),
    attended_any_leakage TEXT,
    ar_tank_empty TEXT,
    cr_tank_empty TEXT,
    defect_persist  TEXT,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_04 (
    id INTEGER PRIMARY KEY, 
    full_brk_applied TEXT,
    full_brk_rel_in_iso TEXT,
    full_brk_rel_indic TEXT,
    full_brk_apply_indic  TEXT,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_05 (
    id INTEGER PRIMARY KEY,
    bp_pressure DECIMAL(10,2),
    fp_pressure DECIMAL(10,2),
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_06 (
    id INTEGER PRIMARY KEY, 
    coach_no_marked_sick  TEXT,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_07 (
    id INTEGER PRIMARY KEY, 
    coach_nos TEXT,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_08 (
    id INTEGER PRIMARY KEY, 
    front_car_time1 DECIMAL(10,2),
    rear_car_time1 DECIMAL(10,2),
    front_car_time2 DECIMAL(10,2),
    rear_car_time2 DECIMAL(10,2),
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_09 (
    id INTEGER PRIMARY KEY, 
    ghbcable_ok TEXT,
    ghbgreen_ok TEXT,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_10 (
    id INTEGER PRIMARY KEY, 
    bp_leakage_value DECIMAL(10,2),
    fp_leakage_value DECIMAL(10,2),
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE tbl_lhb_11 (
    id INTEGER PRIMARY KEY, 
    manrel_step2 TEXT,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_lhb_12 (
    id INTEGER PRIMARY KEY,
    loose_component TEXT,
    display_99 TEXT,
    perform_seq_test TEXT,
    check_caliper_arms TEXT,
    dv_release_time INT,
    total_cylinder INT,
    operative_cylinder INT,
    percentage DECIMAL(10,2),
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_icf_01 (
    id INTEGER PRIMARY KEY,
    drain_aux_reservoir TEXT,
    visual_inspection TEXT,
    greasing TEXT,
    fr_bp_value DECIMAL(10,2),
    fr_fp_value DECIMAL(10,2),
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_icf_02 (
    id INTEGER PRIMARY KEY,
    bp_leakage_value DECIMAL(10,2),
    fp_leakage_value DECIMAL(10,2),
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_icf_03 (
    id INTEGER PRIMARY KEY,
    full_brk_applied  TEXT,
    full_brk_rel_in_iso TEXT,
    coach01 TEXT,
    coach02 TEXT,
    coach03 TEXT,   
    coach04 TEXT,
    coach05 TEXT,
    coach06 TEXT,
    coach07 TEXT,
    coach08 TEXT,
    coach09 TEXT,
    coach10 TEXT,
    coach11 TEXT,
    coach12 TEXT,
    coach13 TEXT,
    coach14 TEXT,
    coach15 TEXT,
    coach16 TEXT,
    coach17 TEXT,
    coach18 TEXT,
    coach19 TEXT,
    coach20 TEXT,
    coach21 TEXT,
    coach22 TEXT,
    coach23 TEXT,
    coach24 TEXT,
    ps_end_col1_01 DECIMAL(10,2),
    ps_end_col1_02 DECIMAL(10,2),
    ps_end_col1_03 DECIMAL(10,2),
    ps_end_col1_04 DECIMAL(10,2),
    ps_end_col1_05 DECIMAL(10,2),
    ps_end_col1_06 DECIMAL(10,2),
    ps_end_col1_07 DECIMAL(10,2),
    ps_end_col1_08 DECIMAL(10,2),
    ps_end_col1_09 DECIMAL(10,2),
    ps_end_col1_10 DECIMAL(10,2),
    ps_end_col1_11 DECIMAL(10,2),
    ps_end_col1_12 DECIMAL(10,2),
    ps_end_col1_13 DECIMAL(10,2),
    ps_end_col1_14 DECIMAL(10,2),
    ps_end_col1_15 DECIMAL(10,2),
    ps_end_col1_16 DECIMAL(10,2),
    ps_end_col1_17 DECIMAL(10,2),
    ps_end_col1_18 DECIMAL(10,2),
    ps_end_col1_19 DECIMAL(10,2),
    ps_end_col1_20 DECIMAL(10,2),
    ps_end_col1_21 DECIMAL(10,2),
    ps_end_col1_22 DECIMAL(10,2),
    ps_end_col1_23 DECIMAL(10,2),
    ps_end_col1_24 DECIMAL(10,2),    
    ps_end_col2_01 DECIMAL(10,2),
    ps_end_col2_02 DECIMAL(10,2),
    ps_end_col2_03 DECIMAL(10,2),
    ps_end_col2_04 DECIMAL(10,2),
    ps_end_col2_05 DECIMAL(10,2),
    ps_end_col2_06 DECIMAL(10,2),
    ps_end_col2_07 DECIMAL(10,2),
    ps_end_col2_08 DECIMAL(10,2),
    ps_end_col2_09 DECIMAL(10,2),
    ps_end_col2_10 DECIMAL(10,2),
    ps_end_col2_11 DECIMAL(10,2),
    ps_end_col2_12 DECIMAL(10,2),
    ps_end_col2_13 DECIMAL(10,2),
    ps_end_col2_14 DECIMAL(10,2),
    ps_end_col2_15 DECIMAL(10,2),
    ps_end_col2_16 DECIMAL(10,2),
    ps_end_col2_17 DECIMAL(10,2),
    ps_end_col2_18 DECIMAL(10,2),
    ps_end_col2_19 DECIMAL(10,2),
    ps_end_col2_20 DECIMAL(10,2),
    ps_end_col2_21 DECIMAL(10,2),
    ps_end_col2_22 DECIMAL(10,2),
    ps_end_col2_23 DECIMAL(10,2),
    ps_end_col2_24 DECIMAL(10,2),  
    ps_non_col1_01 DECIMAL(10,2),
    ps_non_col1_02 DECIMAL(10,2),
    ps_non_col1_03 DECIMAL(10,2),
    ps_non_col1_04 DECIMAL(10,2),
    ps_non_col1_05 DECIMAL(10,2),
    ps_non_col1_06 DECIMAL(10,2),
    ps_non_col1_07 DECIMAL(10,2),
    ps_non_col1_08 DECIMAL(10,2),
    ps_non_col1_09 DECIMAL(10,2),
    ps_non_col1_10 DECIMAL(10,2),
    ps_non_col1_11 DECIMAL(10,2),
    ps_non_col1_12 DECIMAL(10,2),
    ps_non_col1_13 DECIMAL(10,2),
    ps_non_col1_14 DECIMAL(10,2),
    ps_non_col1_15 DECIMAL(10,2),
    ps_non_col1_16 DECIMAL(10,2),
    ps_non_col1_17 DECIMAL(10,2),
    ps_non_col1_18 DECIMAL(10,2),
    ps_non_col1_19 DECIMAL(10,2),
    ps_non_col1_20 DECIMAL(10,2),
    ps_non_col1_21 DECIMAL(10,2),
    ps_non_col1_22 DECIMAL(10,2),
    ps_non_col1_23 DECIMAL(10,2),
    ps_non_col1_24 DECIMAL(10,2),    
    ps_non_col2_01 DECIMAL(10,2),
    ps_non_col2_02 DECIMAL(10,2),
    ps_non_col2_03 DECIMAL(10,2),
    ps_non_col2_04 DECIMAL(10,2),
    ps_non_col2_05 DECIMAL(10,2),
    ps_non_col2_06 DECIMAL(10,2),
    ps_non_col2_07 DECIMAL(10,2),
    ps_non_col2_08 DECIMAL(10,2),
    ps_non_col2_09 DECIMAL(10,2),
    ps_non_col2_10 DECIMAL(10,2),
    ps_non_col2_11 DECIMAL(10,2),
    ps_non_col2_12 DECIMAL(10,2),
    ps_non_col2_13 DECIMAL(10,2),
    ps_non_col2_14 DECIMAL(10,2),
    ps_non_col2_15 DECIMAL(10,2),
    ps_non_col2_16 DECIMAL(10,2),
    ps_non_col2_17 DECIMAL(10,2),
    ps_non_col2_18 DECIMAL(10,2),
    ps_non_col2_19 DECIMAL(10,2),
    ps_non_col2_20 DECIMAL(10,2),
    ps_non_col2_21 DECIMAL(10,2),
    ps_non_col2_22 DECIMAL(10,2),
    ps_non_col2_23 DECIMAL(10,2),
    ps_non_col2_24 DECIMAL(10,2),  
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);