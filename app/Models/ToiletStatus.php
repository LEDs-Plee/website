<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ToiletStatus extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    protected static function booted() {
        static::creating(function ($toilet) {
            $toilet->free = false;
            $toilet->secret = Str::random(10);
        });
    }
}
