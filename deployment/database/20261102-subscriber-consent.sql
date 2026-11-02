-- Wykonaj jednokrotnie na istniejącej bazie PRZED wdrożeniem kodu zapisującego zgodę.
-- Starsze rekordy pozostają z NULL: nie przypisujemy im zgody udzielonej w przeszłości.
ALTER TABLE `subscribers`
    ADD COLUMN `consent_version` varchar(32) DEFAULT NULL,
    ADD COLUMN `consent_given_at` datetime DEFAULT NULL,
    ADD COLUMN `consent_text` text DEFAULT NULL;
