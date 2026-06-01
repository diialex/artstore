<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;
use Symfony\Component\Process\Process;

/**
 * Sobrescribe el comando `serve` para preparar el entorno de desarrollo
 * antes de levantar el servidor: enlace de almacenamiento, migracion limpia
 * con seeders, worker de la cola y servidor de Vite en segundo plano.
 */
class ServeCommand extends BaseServeCommand
{
    /** @var Process[] */
    protected array $backgroundProcesses = [];

    public function handle()
    {
        $this->bootstrapDevEnvironment();

        return parent::handle();
    }

    protected function bootstrapDevEnvironment(): void
    {
        $this->components->info('Preparando entorno de desarrollo...');

        // 1. Enlace de almacenamiento (--force recrea uno roto o de otra maquina).
        $this->call('storage:link', ['--force' => true]);

        // 2. Migracion limpia + seeders (recrea la BD en cada arranque).
        $this->call('migrate:fresh', [
            '--seed'  => true,
            '--force' => true,
        ]);

        // 3. Worker de la cola en segundo plano.
        $this->startBackgroundProcess(
            [PHP_BINARY, 'artisan', 'queue:work', '--tries=3', '--backoff=10'],
            'Worker de cola (queue:work)',
        );

        // 4. Servidor de assets de Vite en segundo plano.
        $this->startBackgroundProcess(
            ['npm', 'run', 'dev'],
            'Servidor de Vite (npm run dev)',
        );
    }

    protected function startBackgroundProcess(array $command, string $label): void
    {
        $process = new Process($command, base_path(), timeout: null);

        $process->start(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        $this->backgroundProcesses[] = $process;

        // Detiene el proceso cuando se cierra `serve`.
        register_shutdown_function(function () use ($process) {
            if ($process->isRunning()) {
                $process->stop();
            }
        });

        $this->components->info($label . ' iniciado en segundo plano.');
    }
}
