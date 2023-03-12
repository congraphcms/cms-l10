<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class CongraphInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'congraph:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init DB changes, and other shit...';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->confirm(
            "Please make sure that you have done following:\n
            1. configured and created databases (mysql and potentialy elasticsearch).\n
            2. Changed app config (app url, secret key...).\n
            Do you wish to continue?"
        )) {
            // terminate
            return;
        }


        $this->info("Migrating database...");
        Artisan::call('migrate');
        $this->info("Database migrated.");
        $this->info("Running database seeders...");
        Artisan::call('db:seed');
        $this->info("Database seeded.");

        $this->info("Fetching generated clients...");
        $clients = $this->clientRepository->get();
        foreach ($clients as $client) {
            $this->info("Client: " . $client->name);
            $this->info("ID: " . $client->id);
            $this->info("SECRET: " . $client->secret);
            $this->info("...");
        }
        $this->info("Please copy these client ids and secrets for your further use. You can always look for these values in your database.");
    }
}
