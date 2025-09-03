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
    bp_pressure  DECIMAL(10,2),
    Fp_pressure DECIMAL(10,2),
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
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);
