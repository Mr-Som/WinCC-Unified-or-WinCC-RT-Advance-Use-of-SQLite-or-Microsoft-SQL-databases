CREATE TABLE train_maintenance_report (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    train_no TEXT NOT NULL,
    date_of_testing DATE NOT NULL,
    load TEXT NOT NULL,
    staff_no TEXT NOT NULL,
    road_no TEXT NOT NULL,
    wagon_type TEXT NOT NULL,
    pipe_type TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tbl_01 (
    id INTEGER PRIMARY KEY, 
    bp_1 DECIMAL(10,2),
    fp_1 DECIMAL(10,2),
    bp_1_status TEXT,
    fp_1_status TEXT,
    bp_2 DECIMAL(10,2),
    fp_2 DECIMAL(10,2),
    bp_2_status TEXT,
    fp_2_status TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_02 (
    id INTEGER PRIMARY KEY, 
    leakage_bp DECIMAL(10,2),
    leakage_fp DECIMAL(10,2),
    leakage_bp_status TEXT,
    leakage_fp_status TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_03 (
    id INTEGER PRIMARY KEY, 
    full_brk_app_bc DECIMAL(10,2),
    full_brk_app_time INTEGER,
    full_brk_app_status TEXT,
    full_brk_app_remark TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE tbl_04 (
    id INTEGER PRIMARY KEY, 
    rel_brk_app_time INTEGER,
    rel_brk_app_status TEXT,
    rel_brk_app_remark TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE tbl_05 (
    id INTEGER PRIMARY KEY, 
    emg_brk_app_bc DECIMAL(10,2),
    emg_brk_app_time INTEGER,
    emg_brk_app_status TEXT,
    emg_brk_app_remark TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE tbl_06 (
    id INTEGER PRIMARY KEY, 
    rel_emg_brk_app_time INTEGER,
    rel_emg_brk_app_status TEXT,
    rel_emg_brk_app_remark TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE tbl_07 (
    id INTEGER PRIMARY KEY, 
    observe_value TEXT,
    reord_value TEXT,
    percent_value TEXT,
    defects TEXT,
    action TEXT,
    iop_wagons TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES train_maintenance_report(id) ON DELETE CASCADE ON UPDATE CASCADE
);
