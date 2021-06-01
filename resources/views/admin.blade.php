@extends('layouts.public')
@section('title', 'Area riservata')
@section('scripts')
<script src='{{asset('js/admin.js')}}'></script>
@endsection

@section('content')
<section name="main content">
    <h3>
        Gestione utenti
    </h3>
    <br />
    <section>
        <div class="outer_search">
            <div>
                {!! Form::open(array('route' => 'searchuser')) !!}
                @csrf
                <label for="usertype" class="control" style="margin-bottom:-1.55em"> Selezione la tipologia di
                    utente</label>
                <select id="usertype" name="usertype">
                    <option id='c' value="client">Cliente</option>
                    @if(isset($user)&&($user->livello==3))
                    <option id='o' value="org" selected>Organizzazione</option>
                    @else
                    <option id='o' value="org">Organizzazione</option>
                    @endif
                </select>
                <span class="search">
                    <label id='labeltext' for="name" class="control"></label>
                    @if(isset($user)&&($user->livello==2))
                    <input type="text" name="name" id="name" value="{{$user->nomeutente}}" />
                    @elseif(isset($user)&&($user->livello==3))
                    <input type="text" name="name" id="name" value="{{$user->nomeutente}}" />
                    @else
                    <input type="text" name="name" id="name" />
                    @endif
                </span>
                @if ($errors->first('name'))
                <ul class="errors">
                    @foreach ($errors->get('name') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                </span>
                @endif
                {!! Form::submit('Cerca utente', ['class' => 'btn btn-inverse', 'style' => 'vertical-align: super']) !!}
                {{-- <button type=submit method="post" class="btn btn-inverse" style="vertical-align: super"
                            formaction="{{route('searchuser')}}">Cerca utente</button> --}}
                {!! Form::close() !!}
            </div>
        </div>
    </section>
    @if(isset($user))
    @if($user->livello==2)
    <div class="single_product" style="height:120px">
        <div style="width:fit-content;float:left">
            <p><b>Nome utente: {{$user->nomeutente}}</b></p>
            <p><b>Email: {{$user->email}}</b></p>
            <p><b>Nome: {{$user->nome}}</b> </p>
            <p><b>Cognome: {{$user->cognome}}</b></p>
        </div>
        @else
        <div class="single_product" style="height:90px">
            <div style="width:fit-content;float:left">
                <p><b>Nome utente: {{$user->nomeutente}}</b></p>
                <p><b>Nome organizzazione: {{$user->organizzazione}}</b></p>
                <p><b>Email: {{$user->email}}</b></p>
            </div>
            @endif
            <div style="height:inherit">
                @if($user->livello==3)
                <div class="pencil_item" title="Modifica dati utente"
                    style="margin: -0.5em 15em 0 15em; height: 50%;justify-content:center">
                    <img id="pencil" class="action_item_clickable" src="{{asset('css/themes/images/pencil.png')}}"
                        alt="modifica dati" onclick="location.href = '{{route('modifyOrg',[$user->id])}}'">
                    <p id="pencil_text"><b>Modifica</b></p>
                </div>
                @endif
                <div id="cross_item" title="Elimina utente"
                    style=" margin: auto 15em;height:50%;justify-content:center">
                    <img id="cross" name="cross" class="action_item_clickable"
                        src="{{asset('css/themes/images/cross.png')}}" alt="cancella utente"
                        onclick="if (confirm('Eliminare l\'utente definitivamente?')) {location.href = '{{route('deleteuser',[$user->id])}}'; }">
                    <p id="cross_text"><b>ELIMINA</b></p>
                </div>
            </div>
        </div>
        @endif
        <br />
        <a href='{{route('insertOrg')}}'><button class='button clickable' type="button">Aggiungi una
                nuova
                organizzazione</button></a>
        <hr size="3" color="black" style="height:2px" />
        <section>
            <h3>Modifica FAQ</h3>
            <?php
            $i = 0;
            $vecchiadomanda = array();
            foreach ($faqs as $faq) {
                $vecchiadomanda[$i] = $faq->domanda;
                $i++;
            }
            $i = 0;
            ?>
            @foreach($faqs as $faq)
            {{ Form::open(array('route' => array('modifyfaq',$vecchiadomanda[$i]),'method'=>'post', 'class' => 'contact-form')) }}
            <div class="faq-element">
                <div class="wrap-contact1">
                    {{ Form::text('domanda', $faq->domanda, ['class' => 'input','id' => 'domanda', 'style'=>'font-weight: bold;width:50em','disabled'=>'disabled','required' => '']) }}
                </div>
                <div class="wrap-contact1">
                    {{ Form::textarea('risposta', $faq->risposta, ['class' => 'input','id' => 'risposta', 'disabled'=>'disabled', 'rows'=>'5', 'style'=>'width:58em','required' => '']) }}
                </div>
                <div style="display:inline-flex">
                    <div class="pencil_item" title="Modifica FAQ" style="margin-left:2em;margin-top:-1em">
                        <img id="pencil" name="pencil" class="pencil action_item_clickable"
                            src="{{asset('css/themes/images/pencil.png')}}" alt="modifica FAQ">
                        <p id="pencil_text"><b>Modifica la FAQ</b></p>
                    </div>
                    <div class="cross_item" title="Elimina FAQ"
                        style=" margin: -1.2em 0 0 1em;height:50%;justify-content:center">
                        <img id="cross" name="cross" class="cross action_item_clickable"
                            src="{{asset('css/themes/images/cross.png')}}" alt="elimina FAQ" onclick="if (confirm('Eliminare la FAQ definitivamente?')) {
                                 location.href = '{{route('deletefaq', [$faq->domanda])}}'; }">
                        <p id="cross_text"><b>ELIMINA</b></p>
                    </div>
                </div>
            </div>
            <input id="salva" hidden type="submit" class="button clickable" value="Salva">
            <input type='reset' id='annulla' hidden class="button clickable" value="Annulla">
            {{ Form::close() }}
            <hr size="3" color="black" style="height:0.2px" />
            <?php $i = $i + 1; ?>
            @endforeach
            <div>
                {{ Form::open(array('route' => 'addfaq','method'=>'post', 'class' => 'contact-form', 'id' => 'addform')) }}
                <div class="plus_item" title="Aggiungi domanda">
                    <img id="plus" name="cross" class="action_item_clickable"
                        src="{{asset('css/themes/images/plus.png')}}" alt="aggiungi domanda" }">
                    <p id="plus_text"><b>Aggiungi domanda</b></p>
                </div>
                <div hidden id='nuovadomanda' class="wrap-input">
                    {{ Form::label('domanda', 'Domanda', ['class' => 'label-input']) }}
                    {{ Form::text('domanda', '', ['class' => 'input','id' => 'domanda','style'=>'font-weight: bold;width:50em','required' => '']) }}
                    @if ($errors->first('domanda'))
                    <ul class="errors">
                        @foreach ($errors->get('domanda') as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div hidden id='nuovarisposta' class="wrap-input">
                    {{ Form::label('risposta', 'Risposta', ['class' => 'label-input']) }}
                    {{ Form::textarea('risposta', '', ['class' => 'input','id' => 'risposta', 'style'=>'width:50em', 'rows'=>'5','required' => '']) }}
                    @if ($errors->first('risposta'))
                    <ul class="errors">
                        @foreach ($errors->get('risposta') as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <input id="salvanuova" hidden type="submit" class="button clickable" value="Aggiungi">
                <input type='reset' id='annullanuova' hidden class="button clickable" value="Annulla">
            </div>
            {{ Form::close() }}
        </section>
</section>
@endsection
