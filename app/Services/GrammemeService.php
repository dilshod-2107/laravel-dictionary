<?php

namespace App\Services;

use App\Models\Grammeme;

class GrammemeService {
    
    public $parsedGrammemes;
    
    public function save($grammemes) {
        
        foreach ($grammemes as $key => $grammeme) {
            $this->parsedGrammemes[]=['id'=>$key + 1,
                                      'parent_id'=>$grammemes->where('name', $grammeme['@parent'])->keys()->first() + 1,
                                      'name'=> $grammeme['name'],
                                      'alias'=>$grammeme['alias'],
                                      'description'=>$grammeme['description']   
                                     ];
        
        }
        Grammeme::insert($this->parsedGrammemes);
    }

}
