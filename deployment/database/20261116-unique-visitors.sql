CREATE TABLE `visitor_page_days` (
    `path` varchar(255) NOT NULL,
    `visit_date` DATE NOT NULL,
    `visitor_hash` CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    PRIMARY KEY(`visit_date`, `visitor_hash`, `path`),
    KEY `idx_visitor_days_visitor_hash` (`visitor_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;