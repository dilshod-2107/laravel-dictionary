<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LinkTypeService;
use App\Jobs\DictionaryFile;


class ImportToDatabaseLinkTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ImportToDataBase:linkTypes';

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
    
    private $LinkTypeService;
    private $file, $dictionary;
    private $linkTypes;
            
    public function __construct(LinkTypeService $linkTypeService)
    {
        parent::__construct();
        
        $this->LinkTypeService=$linkTypeService;
        
        $this->dictionary = DictionaryFile::getXml(Config('importToDatabase.pathxml').Config('importToDatabase.name'));
        $this->linkTypes = collect($this->dictionary['link_types']['type']);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Import link types started');
            $this->LinkTypeService->save($this->linkTypes);
        $this->info('Imported');
    }
}
