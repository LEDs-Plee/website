<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Toilet extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name'];

    protected static function booted() {
        static::creating(function ($toilet) {
            $toilet->free = false;
            $toilet->generateSecret();
        });
    }

    public function visits() {
        return $this->hasMany('App\Models\Visit');
    }

    public function visitsPerDay() {
        $visitsEachDay = Visit::select(DB::raw('DATE(start) as date'), DB::raw('count(*) as visits'))->where('toilet_id', $this->id)->groupBy('date')->get();
        if ($visitsEachDay->count() <= 0) return 'NaN';
        return $visitsEachDay->sum('visits') / $visitsEachDay->count();
    }

    public function duration() {
        return Visit::select(DB::raw('AVG(TIMESTAMPDIFF(SECOND,start,end)) as duration'))->where('toilet_id', $this->id)->whereNotNull('end')->first()->duration;
    }

    public function generateSecret() {
        $this->secret = Str::random(10);
    }
}
