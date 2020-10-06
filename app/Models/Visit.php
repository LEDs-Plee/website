<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['start'];

    public function toilet() {
        return $this->belongsTo('App\Models\Toilet');
    }
}
