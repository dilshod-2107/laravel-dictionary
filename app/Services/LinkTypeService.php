<?php

namespace App\Services;

use App\Models\LinkType;

class LinkTypeService {

    public function save($linkTypes) {
        $parsedlinkTypes = [];
        foreach ($linkTypes as $i => $linkType) {
            $parsedlinkTypes[$i]['id'] = $linkType['@id'];
            $parsedlinkTypes[$i]['type'] = $linkType['#text'];
        }
        LinkType::insert($parsedlinkTypes);
    }

}
