<?php

namespace App;

use App\Models\Resources\Event;
use App\Models\Resources\Purchase;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Resources\Participation;

class User extends Authenticatable
{
    /*use HasFactory,*/
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'nomeutente',
        'password',
        'organizzazione'
    ];

    protected $guarded = [
        'id',
        'livello'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'nomeutente',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($livello)
    {
        $livello = (array)$livello;
        return in_array($this->livello, $livello);
    }

    public function hasPart($user, $evento)
    {
        $filters[] = ['nomeutente', 'LIKE', $user];
        $filters[] = ['idevento', 'LIKE', $evento];
        $participation = Participation::where($filters)->count();
        return ($participation!=0);
    }

    public function nearEvents($user)
    {
        $currentDate = Carbon::now()->toDateString();
        $purchases = Purchase::where('nomeutente', 'LIKE', $user)->orderBy('data')->select('idevento')->distinct()->take(4)->get();
        switch (count($purchases)) {
            case 1:
                $events = Event::where( 'data', '>=', $currentDate)->where('id', '=', $purchases[0]->idevento)->orderBy('data')->get();
                break;
            case 2:
                $events = Event::where(  'data', '>=', $currentDate)->where('id', '=', $purchases[0]->idevento)
                    ->orWhere('id', '=', $purchases[1]->idevento)->orderBy('data')->get();
                break;
            case 3:
                $events = Event::where(  'data', '>=', $currentDate)->where('id', '=', $purchases[0]->idevento)
                    ->orWhere('id', '=', $purchases[1]->idevento)
                    ->orWhere('id', '=', $purchases[2]->idevento)->orderBy('data')->get();
                break;
            case 4:
                $events = Event::where(  'data', '>=', $currentDate)->where('id', '=', $purchases[0]->idevento)
                    ->orWhere('id', '=', $purchases[1]->idevento)
                    ->orWhere('id', '=', $purchases[2]->idevento)
                    ->orWhere('id', '=', $purchases[3]->idevento)->orderBy('data')->take(4)->get();
                break;
            
            default:
                $events = null;
        }
        return $events;
    }

    public function isFull($event)
    {
        $events = Event::where('id', '=', $event)->get();
        foreach ($events as $event) {
            $rimanenti = $event->bigliettitotali - $event->bigliettivenduti;
        }

        return ($rimanenti > 0);
    }
}
