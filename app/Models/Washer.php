<?php

namespace App\Models;

use App\Notifications\WasherNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class Washer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'smartthings_id'];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function updateState() {
        $previousState = $this->state;
        $washerData = Http::withToken(config('smartthings.personal_key'))->get('https://api.smartthings.com/v1/devices/'.$this->smartthings_id.'/components/main/capabilities/washerOperatingState/status')->json();
        if(!isset($washerData['machineState'])) {
            abort(400, 'Error updating washer '.$this->name.'.');
        }
        $this->state = $washerData['machineState']['value'];
        $this->jobState = $washerData['washerJobState']['value'];
        $this->start = Carbon::parse($washerData['machineState']['timestamp'])->setTimezone('Europe/Amsterdam');
        $this->end = Carbon::parse($washerData['completionTime']['value'])->setTimezone('Europe/Amsterdam');
        $this->save();
        if($this->state == 'stop' && $this->state != $previousState) {
            $notification = new WasherNotification($this);
            $users = User::where('notify_washer', true)->get();
            Notification::send($users, $notification);
        }
        return 'success';
    }

    public function duration() {
        return $this->end->diffInSeconds($this->start);
    }
}
