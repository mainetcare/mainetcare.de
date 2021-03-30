<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;

class Step {

    use HasAttributes;

    public $min = 1;
    public $max = 2;




}
