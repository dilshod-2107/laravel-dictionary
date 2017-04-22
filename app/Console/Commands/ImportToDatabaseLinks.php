<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LinkService;
use App\Jobs\DictionaryFile;

class ImportToDatabaseLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ImportToDataBase:links';

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
    
    private $LinkService;
    private $dictionary;
    private $links;
            
    public function __construct(LinkService $linkService)
    {
        parent::__construct();
        $this->dictionary = DictionaryFile::getXml(Config('importToDatabase.pathxml').Config('importToDatabase.name'));
        $this->LinkService=$linkService;
        $this->links = collect($this->dictionary['links']['link']);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Import links started');
            $this->LinkService->save($this->links);
        $this->info('Imported');
    }
}
