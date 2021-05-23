@extends('layouts.user')
@section('title', 'Area riservata')
@section('content')
<section name="main content">
    <h3>
        Informazioni account
    </h3>
    <div class="raw">
        <p>Nome utente: {{$user->nomeutente}}</p>
        <p>Email: {{$user->email}}</p>
        <p>Password: {{$user->password}}</p> <|<!-- ARRIVA CON HASH? NON PENSO. MA SOPRATTUTTO DOVREMMO 
                                               NASCONDERLA E RENDERLA VISIBILE CON UN PULSANTE -->
        <p>Nome: {{$user->nome}} </p>
        <p>Cognome: {{$user->cognome}}</p>
        <form>
            <input class="button" type="submit" value="Modifica dati personali" formaction="#" />
        </form>
        <hr size="3" color="black" style="height:0.5px" />
    </div>
    <div class="raw">
        <h3>Eventi in programma</h3>
        <ul class="thumbnails">
            @if (isset($nearEvents)
            @foreach($nearEvents as $event)
            <li class="span3">
                <div class="product-box">
                    <span class="sale_tag"></span>
                    <p><a href="#"><img src="{{$event->immagine}}" alt="" /></a></p>
                    <a href="#" class="title">{{$event->nome}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$event->data}}</a><br />
                </div>
            </li>
            @endforeach
            @endif
        </ul>
        <form>
            <input class="button" type="button" value="Cronologia acquisti" formaction="#" /> <!--PORTA ALLA CRONOLOGIA ACQUISTI-->
        </form>
    </div>
</section>
@endsection
