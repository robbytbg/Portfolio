<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UrlController;

class TestUrlGeneration extends Command
{
    protected $signature = 'test:url-generation';
    protected $description = 'Test URL generation for register and login routes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = new UrlController();

        $registerUrl = $controller->generateRegisterUrl();
        $loginUrl = $controller->generateLoginUrl();

        $this->info("Generated Register URL: $registerUrl");
        $this->info("Generated Login URL: $loginUrl");
    }
}
