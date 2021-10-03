@php
  use \App\Models\Pokemon;
  if (isset($pokemon)) {
    switch ($pokemon->Type_1) 
    {
        case '1'://ACIER
            $color='#adadc6';
            break;
        case '2'://COMBAT
            $color='#a55239';
            break;
        case '3'://DRAGON
            $color='#8858f6';
            break;
        case '4'://EAU
            $color='#399cff';
            break;
        case '5'://ELECTRICK
            $color='#ffc631';
            break;
        case '6'://FEE
            $color='#e09ae3';
            break;
        case '7'://FEU
            $color='#f75231';
            break;
        case '8'://GLACE
            $color='#5acee7';
            break;
        case '9'://INSECT
            $color='#adbd21 ';
            break;
        case '10'://NORMAL
            $color='#ada594';
            break;
        case '11'://PLANTE
            $color='#7bce52';
            break;
        case '12'://POISON
            $color='#b55aa5';
            break;
        case '13'://PSY
            $color='#ff73a5';
            break;
        case '14'://ROCHE
            $color='#bda55a';
            break;
        case '15'://SOL
            $color='#d6b55a ';
            break;
        case '16'://SPECTRE
            $color='#6363b5';
            break;
        case '17'://TENEBRE
            $color='#735a4a';
            break;
        case '18'://VOL
            $color='#9cadf7';
            break;
        
        default:
            $color='grey';
            break;
    }}
@endphp

@extends('layouts.header')
@section('content')
    @if (isset($pokemon))
        <h1 style="text-align: center">
            <strong>{{$pokemon->Nom}}</strong> 
        </h1>
        <div class="col-md-12" >
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-around">
                        <div>
                            @php try{$previous=Pokemon::where('Id',$pokemon->Id-1)->firstOrFail();}catch(\Throwable $th){} @endphp
                            @if (isset($previous))
                                <img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$previous->Generation}}G/{{$previous->Sprite_2D}}">  
                                <strong id="previous">
                                    <a href="{{$previous->Nom}}"
                                        @switch($previous->Type_1)
                                        @case ('1') style="color:#adadc6"@break;
                                        @case ('2')style="color:#a55239"@break;
                                        @case ('3')style="color:#8858f6" @break;
                                        @case ('4')style="color:#399cff"@break;
                                        @case ('5')style="color:#ffc631"@break;
                                        @case ('6')style="color:#e09ae3"@break;
                                        @case ('7')style="color:#f75231"@break;
                                        @case ('8')style="color:#5acee7"@break;
                                        @case ('9')style="color:#adbd21" @break;
                                        @case ('10')style="color:#ada594"@break;
                                        @case ('11')style="color:#7bce52"@break;
                                        @case ('12')style="color:#b55aa5"@break;
                                        @case ('13')style="color:#ff73a5" @break;
                                        @case ('14')style="color:#bda55a"@break;
                                        @case ('15')style="color:#d6b55a" @break;
                                        @case ('16')style="color:#6363b5"@break;
                                        @case ('17')style="color:#735a4a"@break;
                                        @case ('18')style="color:#9cadf7"@break;
                                    @endswitch>{{$previous->Nom}}
                                    </a>
                                </strong> 
                            @endif
                        </div>
                        <div>
                            <img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$pokemon->Generation}}G/{{$pokemon->Sprite_2D}}">  
                            <strong style="color: {{$color}}">{{$pokemon->Nom}}</strong>
                        </div>
                        <div>
                            @php try{$next=Pokemon::where('Id',$pokemon->Id+1)->firstOrFail();}catch(\Throwable $th){} @endphp
                            @if (isset($next))
                                <img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$next->Generation}}G/{{$next->Sprite_2D}}">  
                                <strong >
                                    <a href="{{$next->Nom}}"
                                        @switch($next->Type_1)
                                        @case ('1') style="color:#adadc6"@break;
                                        @case ('2')style="color:#a55239"@break;
                                        @case ('3')style="color:#8858f6" @break;
                                        @case ('4')style="color:#399cff"@break;
                                        @case ('5')style="color:#ffc631"@break;
                                        @case ('6')style="color:#e09ae3"@break;
                                        @case ('7')style="color:#f75231"@break;
                                        @case ('8')style="color:#5acee7"@break;
                                        @case ('9')style="color:#adbd21" @break;
                                        @case ('10')style="color:#ada594"@break;
                                        @case ('11')style="color:#7bce52"@break;
                                        @case ('12')style="color:#b55aa5"@break;
                                        @case ('13')style="color:#ff73a5" @break;
                                        @case ('14')style="color:#bda55a"@break;
                                        @case ('15')style="color:#d6b55a" @break;
                                        @case ('16')style="color:#6363b5"@break;
                                        @case ('17')style="color:#735a4a"@break;
                                        @case ('18')style="color:#9cadf7"@break;
                                        @endswitch>{{$next->Nom}}
                                    </a>
                                </strong>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-4 mb-3" style="float: left">
                        <div class="card">
                            <div class="card-header" style="background-color: {{$color}}">
                                    <a>Pokedex Index :
                                        @switch(true)
                                            @case($pokemon->Id<10)
                                                <strong>00{{$pokemon->Id}}</strong>
                                                @break
                                            @case($pokemon->Id<100)
                                                <strong>0{{$pokemon->Id}}</strong>
                                                @break
                                            @case($pokemon->Id>=100)
                                                <strong>{{$pokemon->Id}}</strong>
                                                @break
                                        @endswitch
                                    </a>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img style="cursor: pointer;" onclick="Shiny('go')" id="go" src="../../../img/Sprite_Pokemon/Sprite_3D/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D}}">
                                    <img style="cursor: pointer;" hidden onclick="Shiny('back')" id="back" src="../../../img/Sprite_Pokemon/Sprite_3D_Shiny/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D}}">
                                    <p style="font-style: italic;font-size: 11px">(Click to see the shiny version !)</p>
                                    @foreach ($type_pokemon as $item) 
                                        @if ($pokemon->Type_1==$item->Id)
                                            <a hidden>{{$pokemon->Type_1.'.'.$pokemon->Type_2}}</a>
                                            <img src="../../../img/Sprite_Type/{{$item->Sprite}}">
                                        @endif
                                    @endforeach
                                    @foreach ($type_pokemon as $item) 
                                        @if ($pokemon->Type_2==$item->Id)
                                        - <img src="../../../img/Sprite_Type/{{$item->Sprite}}">
                                        @endif
                                    @endforeach
                                </div>
                                <br>
                                <div>
                                    <label for=""><strong style="color: {{$color}}">English Name :</strong></label>
                                    <a>{{$pokemon->Nom_Anglais}}</a>
                                    <br>
                                    <label for=""><strong style="color: {{$color}}">Generation :</strong></label>
                                    <a>{{$pokemon->Generation}}</a>
                                    <br>
                                    <label for=""><strong style="color: {{$color}}">Height :</strong></label>
                                    <a>{{$pokemon->Taille}}m</a>
                                    <br>
                                    <label for=""><strong style="color: {{$color}}">Weight :</strong></label>
                                    <a>{{$pokemon->Poid}}kg</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mb-3" style="float: right">
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header" style="background-color: {{$color}}">
                                </div>
                                <div class="card-body">
                                    <div class="col-md-8 mb-3">
                                        <h5 for="desc"><strong>Description</strong>:</h5>
                                        <p rows="2" name="desc" id="desc">{{$pokemon->Description}}</p>

                                        @if ($pokemon->Mega_Evolution)
                                            <h5 for="desc">
                                                <strong>Mega Evolution :</strong>
                                                <img src="../../../img/Sprite_Mega_Gemme/{{$pokemon->Nom."ite"}}.png"> 
                                            </h5>
                                            <a style="text-decoration: none" href="{{Pokemon::where('Id',$pokemon->Mega_Evolution)->first()->Nom}}">                                    
                                                <img src="../../../img/Sprite_Pokemon/Sprite_3D/{{$pokemon->Generation}}G/{{Pokemon::where('Id',$pokemon->Mega_Evolution)->first()->Sprite_3D}}">
                                            </a>
                                            @if ($pokemon->Nom=='Dracaufeu'||$pokemon->Nom=='Mewtwo')
                                                <?php
                                                    $pokemonX=Pokemon::where('Nom',$pokemon->Nom."-mega-x")->first();try{ ?>
                                                    <a style="text-decoration: none" href="{{$pokemonX->Nom}}">                                    
                                                        <img src="../../../img/Sprite_Pokemon/Sprite_3D/{{$pokemonX->Generation}}G/{{$pokemonX->Sprite_3D}}">
                                                    </a> <?php } catch (\Throwable $th) { }
                                                ?>
                                            @endif
                                        @endif

                                        @if ($pokemon->Form_Alola)
                                            <h5 for="desc"><strong>Alola Form</strong>:</h5>
                                            <a style="text-decoration: none" href="{{Pokemon::where('Id',$pokemon->Form_Alola)->first()->Nom}}">
                                                <img src="../../../img/Sprite_Pokemon/Sprite_3D/{{$pokemon->Generation}}G/{{Pokemon::where('Id',$pokemon->Form_Alola)->first()->Sprite_3D}}">
                                            </a>
                                        @endif

                                        @if ($pokemon->Sprite_3D_Giga)
                                            <h5 for="desc"><strong>Gigamax</strong>:</h5>
                                            <img src="../../../img/Sprite_Pokemon/Sprite_3D_Giga/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D_Giga}}">
                                        @endif
                                        
                                        <h5 for="desc"><strong>Evolution</strong>:</h5>
                                        <div class="alert alert-info" role="alert">
                                            SOON... 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <script>window.location = "/NoPokemonFound_ERROR";</script>')
    @endif
@endsection

<script>
    function Shiny(params) 
    {
       if (params=='go') 
       {
           document.getElementById('go').hidden=true;
           document.getElementById('back').hidden=false;
       }
       else
       {
           document.getElementById('back').hidden=true;
           document.getElementById('go').hidden=false;
       }
    }
</script>


