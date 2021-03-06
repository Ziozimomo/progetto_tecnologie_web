@extends ('layouts.public')
@section('title', 'Evento')

@section ('scripts')
<script src='{{asset('js/block_purchase.js')}}'></script>
@can('isOrg')
<script>
    $(function(){
        $('.single_event').css('float','left');
    });
</script>
@endcan
@endsection

@section ('content')
<section class="main-content">
    <div class="row">
        <div class="event-image span">
            <img src="{{ asset('locandine/'.$event->immagine) }}" class="thumbnail">
        </div>
        <div class="single_event" >
            <h3><span>{{$event->nome}}</span></h3>
            <h5>Organizzato da: {{$event->nomeorganizzatore}}</h5>
            <h5>Data: {{$event->data}}</h5>
            <h5>Orario: {{$event->orario}}</h5>
            <h5>Location: {{$event->regione.", ".$event->città.", ".$event->indirizzo." ".$event->numciv}}</h5>
            <h5 style='display: inline'>Biglietti rimanenti:&nbsp</h5>
            <h5 id="biglietti" style='display: inline'>{{$event->bigliettitotali-$event->bigliettivenduti}}</h5>

            @if ($saldo)
            <h5>Costo:
                <span id="prezzo_daScontare">{{number_format($event->costo,2)}}€</span>
                <span id="prezzo_scontato">{{number_format(($event->costo - $event->costo/100*$event->sconto),2)}}€</span>
                <span class="sconto_text"> &nbsp;&nbsp;SCONTO LAST MINUTE! </span>
            </h5>
            @else
            <span> <h5>Costo: {{number_format($event->costo,2)}}€</h5></span>
            @endif
            <br />
            <div>
                <form class="form-inline" method="get">
                    @guest
                    <input class="bigbutton clickable" type="submit" value="ACQUISTA" formaction="{{ route('login') }}">
                    @endguest

                    @can('isUser')
                    @if (($event->bigliettitotali-$event->bigliettivenduti)>0)
                    <input class="bigbutton clickable" id="buy" type="submit" value="ACQUISTA"
                           formaction='{{ route('purchase', ['eventId' => $event->id])}}'>
                    @else
                    <input class="bigbutton clickable" style="display:inline" id="buy" type="submit" value="ACQUISTA"
                           formaction=''>
                    <h5 style="display:inline;color: red">&nbspBiglietti esauriti!</h5>
                    @endif
                    @endcan
                </form>
            </div>
            <div class="parteciperò_container">
                @guest
                <div>
                    <p>
                        Dì alle persone che perteciperai!
                    </p>
                    <p>
                        Persone che parteciperanno: {{$event->parteciperò}}
                    </p>
                </div>
                <form class="form-inline" style="margin-left:2em">
                    <input class="btn btn-inverse" type="submit" value="Parteciper&ograve"
                           formaction="{{ route('login') }}"></input>
                </form>
                @endguest
                @can('isUser')
                <div>
                    <p>
                        Dì alle persone che perteciperai!
                    </p>
                    <p>
                        Persone che parteciperanno: {{$event->parteciperò}}
                    </p>
                </div>
                <form class="form-inline" style="margin-left:2em">
                    @if ($partecipa)
                    <input class="btn btn-inverse" type="submit" value="Cancella"
                           formaction="{{ route('delPart', ['eventId' => $event->id]) }}"></input>
                    @else
                    <input class="btn btn-inverse" type="submit" value="Parteciper&ograve"
                           formaction="{{ route('participate', ['eventId' => $event->id]) }}"></input>
                    @endif
                </form>
                @endcan
                </form>
            </div>

        </div>
        @can('isOrg')
        @if(($event->nomeorganizzatore)==(auth()->user()->organizzazione))
        <div class="action_div">
            <div class="pencil_item" title="Modifica evento">
                <img id="pencil" name="pencil" class="action_item_clickable"
                     onclick="location.href = '{{route('modifyEvent',[$event->id])}}'"
                     src="{{asset('css/themes/images/pencil.png')}}" alt="modifica evento">
            </div>
            <p id="pencil_text">Modifica</p>
            <div class="cross_item" title="Elimina evento">
                <img id="cross" name="cross" class="action_item_clickable"
                     src="{{asset('css/themes/images/cross.png')}}" alt="cancella evento"
                     onclick="if (confirm('Eliminare l\'evento definitivamente?')){location.href = '{{route('delete',[$event->id])}}'}">
                <p id="cross_text">Elimina</p>
            </div>
        </div>
        @endif
        @endcan
        <div class="span" style="width:-webkit-fill-available; width: -moz-available;">
            <hr>
            <div class="event-container">
                <div class='event-bottom'>
                    <div>
                        <h5>Descrizione</h5>
                        <p>{{$event->descrizione}}</p>
                    </div>
                    <div>
                        <h5>Come raggiungerci</h5>
                        <p>{{$event->comeraggiungerci}}</p>
                    </div>
                    <div>
                        <h5>Programma</h5>
                        <p>{{$event->programma}}</p>
                    </div>
                </div>
                <div>
                    <iframe width="500" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="{{$event->urlluogo}}"></iframe><small><a href="{{$event->urlluogo}}"""></a></small>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
