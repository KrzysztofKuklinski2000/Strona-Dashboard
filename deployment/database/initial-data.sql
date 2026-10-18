-- Importuj raz, po schema.sql. Rekordy wymagane przez formularze edycji.
-- Przed publikacją uzupełnij puste dane, zerowe kwoty i daty 1970-01-01.

SET NAMES utf8mb4;

START TRANSACTION;

INSERT INTO `contact` (`id`, `email`, `phone`, `address`)
VALUES (1, '', '', '');

INSERT INTO `fees` (
    `id`, `reduced_contribution_1_month`, `reduced_contribution_2_month`,
    `family_contribution_month`, `reduced_contribution_1_year`,
    `reduced_contribution_2_year`, `family_contribution_year`,
    `extra_information`, `fees_information`
) VALUES (1, 0, 0, 0, 0, 0, 0, '', '');

INSERT INTO `camp` (
    `id`, `city`, `city_start`, `date_start`, `date_end`, `time_start`, `time_end`,
    `place`, `accommodation`, `meals`, `trips`, `staff`, `transport`, `training`,
    `insurance`, `cost`, `advancePayment`, `advanceDate`, `guesthouse`
) VALUES (
    1, '', '', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00',
    '', '', '', '', '', '', '', '', 0, 0, '1970-01-01', ''
);

COMMIT;
