<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunPythonScript extends Command
{
    protected $signature = 'python:run';
    protected $description = 'Run Python script';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pythonScript = base_path('storage/app/public/python.py');
        $process = new Process(['python3', $pythonScript]);
        $process->run();

        if ($process->isSuccessful()) {
            $this->info('Python script executed successfully.');
        } else {
            $this->error('Error running Python script: ' . $process->getErrorOutput());
        }
    }
}
