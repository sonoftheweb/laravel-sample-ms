<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loadly:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fresh setup of application for dev purposes.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
	    $this->info('Running Migrations and Seeders');
		Artisan::call('migrate:fresh --force --seed');
	
	    $this->info('Setting up passport');
		Artisan::call('passport:install');
		
		$this->comment('Clearing cache');
		Artisan::call('cache:clear');
        return 0;
    }
}
