<?php
declare(strict_types=1);

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

$process = new Process(['php', 'bin/console', 'doctrine:migrations:migrate', '--no-interaction']);
$process->run();
if (! $process->isSuccessful()) {
    throw new ProcessFailedException($process);
}

$process = new Process(['php', 'bin/console', 'doctrine:fixtures:load', '--no-interaction']);
$process->run();
if (! $process->isSuccessful()) {
    throw new ProcessFailedException($process);
}
