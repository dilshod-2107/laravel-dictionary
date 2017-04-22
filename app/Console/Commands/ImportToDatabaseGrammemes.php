<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GrammemeService;
use App\Jobs\DictionaryFile;

class ImportToDatabaseGrammemes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ImportToDataBase:grammemes';

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
    
    private $GrammemeService;
    private $dictionary;
    private $grammemes;
            
    public function __construct(GrammemeService $grammemeService)
    {
        parent::__construct();
        
        $this->dictionary = DictionaryFile::getXml(Config('importToDatabase.pathxml').Config('importToDatabase.name'));
        $this->GrammemeService=$grammemeService;
        $this->grammemes = collect($this->dictionary['grammemes']['grammeme']);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Import grammemes started');
            $this->GrammemeService->save($this->grammemes);
        $this->info('Imported');
    }
}
