<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LemmaService;
use App\Models\Grammeme;
use App\Jobs\DictionaryFile;

class ImportToDatabaseLemmata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ImportToDataBase:lemmata';

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
    
    private $LemmaService;
    private $dictionary;
    private $lemmata;
            
    public function __construct(LemmaService $lemmaService)
    {
        parent::__construct();
        
        $this->LemmaService=$lemmaService;
        $this->dictionary = DictionaryFile::getXml(Config('importToDatabase.pathxml').Config('importToDatabase.name'));
        $this->lemmata = collect($this->dictionary['lemmata']['lemma']);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Import lemmata started');
            $this->LemmaService->setGrammemes(Grammeme::all());
            $this->LemmaService->save($this->lemmata);
        $this->info('Imported');
    }
}
