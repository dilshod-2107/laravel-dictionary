<?php

namespace App\Services;

use App\Models\Link;

class LinkService {

    public function save($links) {
        $parseLinks = [];
        foreach ($links as $j => $link) {
            $parseLinks[$j]['id'] = $link['@id'];
            $parseLinks[$j]['from'] = $link['@from'];
            $parseLinks[$j]['to'] = $link['@to'];
            $parseLinks[$j]['link_type_id'] = $link['@type'];
        }
        Link::insert($parseLinks);
    }

}
