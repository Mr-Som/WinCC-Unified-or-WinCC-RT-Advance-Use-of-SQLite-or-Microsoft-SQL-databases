CREATE TABLE train_maintenance_report (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    train_no TEXT NOT NULL,
    train_name TEXT NOT NULL,
    date_of_testing DATE NOT NULL,
    washing_pit_no INTEGER NOT NULL,
    shift TEXT NOT NULL,
    --shift TEXT CHECK(shift IN ('Morning', 'Evening', 'Night')) NOT NULL,
    sse TEXT NOT NULL,
    operator_name TEXT NOT NULL,
    pipe_type TEXT NOT NULL,
    --pipe_type TEXT CHECK(pipe_type IN ('Single Pipe', 'Twin Pipe')) NOT NULL,
    rake_type TEXT NOT NULL,
    load TEXT NOT NULL,
    coach_type TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);