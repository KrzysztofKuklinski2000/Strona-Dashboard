CREATE TABLE visitor_daily_page_totals (
    visit_date DATE NOT NULL,
    path VARCHAR(255) NOT NULL,
    unique_visitors INT UNSIGNED NOT NULL,
    PRIMARY KEY (visit_date, path)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;