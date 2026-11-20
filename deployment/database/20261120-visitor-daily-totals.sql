CREATE TABLE visitor_daily_totals (
    visit_date DATE NOT NULL PRIMARY KEY,
    unique_visitors INT UNSIGNED NOT NULL
) ENGINE=InnoDB;