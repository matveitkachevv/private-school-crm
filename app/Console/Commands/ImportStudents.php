<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:students {pathToFile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import students from xlsx format';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $path = $this->argument('pathToFile');
        $students = new \App\Models\Import\Students;
        return $students->import($path);
    }
}
