<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearAuthorizedTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:authorized';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vaciar la tabla authorizeds al final del día';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('authorizeds')->truncate();

        $this->info('La tabla authorizeds ha sido vaciada exitosamente.');
    }
}
