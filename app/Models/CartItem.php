<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends MncModel
{

    protected $casts = [
        'data' => 'array' // field for various runtime calculations, eg. how many guestes are left to book in appartements
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany(CartItem::class, 'parent_id');
    }


    public function getPersons($type) {
        return $this->data['persons'][$type] ?? 0;
    }



}
