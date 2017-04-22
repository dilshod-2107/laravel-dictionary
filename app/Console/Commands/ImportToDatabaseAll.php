<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LinkService;
use File;
use Parser;
use DB;

class ImportToDatabaseAll extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ImportToDataBase:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LinkService $linkService) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        DB::transaction(function() {
            $this->call('ImportToDataBase:grammemes');
            $this->call('ImportToDataBase:lemmata');
            $this->call('ImportToDataBase:linkTypes');
            $this->call('ImportToDataBase:links');
        });
    }

}
