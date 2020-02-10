<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function marked()
    {
        return $this->hasOne(MarkedQuestion::class, 'number', 'number');
    }
}
