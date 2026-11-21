<?php
declare(strict_types=1);

use App\Core\Config;
use App\Core\Database;
use App\Repository\Analytics\UniqueVisitorRepository;
use Symfony\Component\Dotenv\Dotenv;

$root = dirname(__DIR__);
require_once $root.'/vendor/autoload.php';

(new Dotenv())->loadEnv($root.'/.env', defaultEnv: 'prod');

$configArray = require $root.'/config/config.php';
$config = new Config($configArray);

$database = new Database($config->getDbConfig());
$repository = new UniqueVisitorRepository($database->connect());

$today = new DateTimeImmutable('today', new DateTimeZone('Europe/Warsaw'));
$yesterday = $today->modify('-1 day');

$count = $repository->countBetween($yesterday, $today);
$repository->saveDailyTotal($yesterday, $count);
$repository->saveDailyPageTotals($yesterday);

printf("Podsumowanie gotowe: %s\n", $yesterday->format('Y-m-d'));

