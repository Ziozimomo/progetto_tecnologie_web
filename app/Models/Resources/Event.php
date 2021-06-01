<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //use HasFactory;
    /**
     * Indica che il modello non devere cercare delle colonne con il time stamp
     *
     * @var boolean
     */
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'descrizione',
        'urlluogo',
        'regione',
        'indirizzo',
        'provincia',
        'città',
        'numciv',
        'data',
        'immagine',
        'costo',
        'sconto',
        'giornisconto',
        'bigliettivenduti',
        'bigliettitotali',
        'incassototale',
        'parteciperò',
        'nomeorganizzatore',
        'comeraggiungerci'
    ];
    protected $guarded = [
        'id'
    ];


    public function getDiscountedPrice(){
        return ($this->costo) - ($this->costo)*($this->sconto/100);
    }

    //forse serve per modificare gli incassi totali con gli acquisti?
    public function getOrganizzatore(){
        return $this->belongsTo(User::class, "nomeorganizzatore", "organizzazione");
    }

}
