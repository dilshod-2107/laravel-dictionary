<?php

namespace App\Services;

use App\Models\Lemma;
use App\Models\GrammemeLemmata;
use App\Models\Grammeme;
use App\Models\Worldform;
use App\Models\GrammemeWorldform;

class LemmaService {

    private $grammeme_lemmata;
    private $grammeme_worldform;
    private $parsedLemmata;
    private $grammemes;
    private $worldforms;

    public function save($lemmata) {
        foreach ($lemmata as $lemma) {
            $this->parsedLemmata[] = ['id' => $lemma['@id'],
                                      'lemma' => $lemma['l']['@t'],
                                      'rev' => $lemma['@rev']
                                     ];
            isset($lemma['l']['g']) ? $this->parseGrammemeLemmata($lemma['@id'], $lemma['l']['g']) : '';
            $this->parseWorldforms($lemma['@id'], $lemma['f']);
        }
        
        Lemma::insert($this->parsedLemmata);
        GrammemeLemmata::insert($this->grammeme_lemmata);
        Worldform::insert($this->worldforms);
        GrammemeWorldform::insert($this->grammeme_worldform);
        
       
    }

    private function parseGrammemeLemmata($lemma_id, $grammeme_lemmata) {

        foreach ($grammeme_lemmata as $g) {
            $this->grammeme_lemmata[] = ['grammeme_id' => $this->grammemes->where('name', is_array($g)? $g['@v'] : $g)->first()['id'],
                                         'lemma_id' => $lemma_id
                                        ];
        }
    }
    
    
    
    private function parseWorldforms($lemma_id, $worldforms) {
        $id=count($this->worldforms)+1;
        if(isset($worldforms['@t'])){
            $this->worldforms[] = ['id'=>$id,
                                       'text' => $worldforms['@t'],
                                       'lemma_id' => $lemma_id
                                      ];
                isset($worldforms['g']) ? $this->parseGrammemeWorldform($id, $worldforms['g']) : '';
                $id++;
        }else{
            foreach ($worldforms as $f) {
                $this->worldforms[] = ['id'=>$id,
                                       'text' => $f['@t'],
                                       'lemma_id' => $lemma_id
                                      ];
                isset($f['g']) ? $this->parseGrammemeWorldform($id, $f['g']) : '';
                $id++;
            }
        }
    }
    
    
    
    private function parseGrammemeWorldform($worldform_id, $grammeme_worldform) {
        foreach ($grammeme_worldform as $g) {
            $this->grammeme_worldform[] = ['grammeme_id' => $this->grammemes->where('name', is_array($g)? $g['@v'] : $g)->first()['id'],
                                           'worldform_id' => $worldform_id
                                          ];
        }
    }
    
    
    public function setGrammemes($grammemes){
        $this->grammemes = $grammemes;
    }

}
