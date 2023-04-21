<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Generator as OpenApiGenerator;

class OpenApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open-api:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comand to Generate OpenApi (Swagger) Documentation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $openapi = OpenApiGenerator::scan(['app/Http/Controllers']);
        file_put_contents('public/api-documentation/swagger.json', $openapi->toJson());
        $this->info('Api documentation generated successfuly');
        return Command::SUCCESS;
    }
}
