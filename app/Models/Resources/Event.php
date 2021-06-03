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
        'nomeorganizzatore'
    ];
    protected $guarded = [
        'id'
    ];


    public function setDiscountedPrice(){
        $eventi = Event::all();
        foreach($eventi as $evento){
        $dataEvento = strToTime($evento->data);
        $differenza=$dataEvento - time();
        $giorniMancanti=floor($differenza/(60*60*24));
        $giorniSconto= $evento->giornisconto;
        $sconto=$evento->sconto;
        if($giorniMancanti<=$giorniSconto) $evento->costo= ($evento->costo) - ($evento->costo)*$sconto; 
        
        }
    }

    //forse serve per modificare gli incassi totali con gli acquisti?
    public function getOrganizzatore(){
        return $this->belongsTo(User::class, "nomeorganizzatore", "organizzazione");
    }

}

//RICORDA, BISOGNA (PENSO) METTERE LE PROPRIETA' $guarded IN TUTTI
//UN METODO PER OTTENERE L'ORGAIZZATORE???
