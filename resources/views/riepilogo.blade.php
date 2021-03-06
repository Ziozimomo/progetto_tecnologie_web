@extends('layouts.public')
@section('title', 'Riepilogo acquisto')
@section('content')
<section name="main_content">
            <h2>
                Riepilogo acquisto
            </h2>
            <div class="container">
                <h5>
                    {{$event->nome}}
                </h5>
                <div class="riepilogo1">
                    <h5>
                        {{$event->data}}, {{$event->orario}}
                    </h5>
                    <h5>
                        {{$event->regione}}, {{$event->provincia}}, {{$event->città}}
                    </h5>
                    <h5>
                        {{$event->indirizzo}} {{$event->numciv}}
                    </h5>
                </div>
                <div class="riepilogo2">
                    <h5>Numero di biglietti: {{$numerobiglietti}}</h5>
                    <h5>Importo complessivo: {{$importo}}€</h5>
                </div>
            </div>
            <br />
            <br />
            <div>
                <form type="get" action="{{route('list')}}">
                    <input class="button clickabel" type="submit" value="TORNA ALLA LISTA DEGLI EVENTI" />
                </form>
            </div>
        </section>
@endsection