@extends('layouts.header')
@section('content')
    @auth 
        @if (Auth::user()->rang =='admin')
            @if ($pokemon!=null)
                <h1 style="text-align: center">
                    @if ($pokemon->Id -1 !=0)
                        <a href="../update/{{$pokemon->Id -1}}" style="color: black;text-decoration: none;">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif
                    <strong>
                        | {{$pokemon->Nom}} 
                    <img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$pokemon->Generation}}G/{{$pokemon->Sprite_2D}}" width="100px">  |</strong>
                    @if ($pokemon->Id +1 < 898)
                        <a href="../update/{{$pokemon->Id +1}}" style="color: black">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
                </h1>
                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            </p>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-12">
                    <form method="POST" action="/update_pokemon/{{$pokemon->Id}}">
                        @csrf
                        <div class="card">
                            <div class="card-header">Update pokemon</div>
                            <div class="card-body">
                                {{-- Left partie avec les img --}}
                                <div class="col-md-4 mb-3" style="float: left">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="accordion" id="accordionExample">
                                                {{-- 1 volet --}}
                                                    <div class="card">
                                                        <div class="card-header" id="headingOne">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                    [2D/3D/3D_Shiny]
                                                                </button>
                                                            </h2>
                                                        </div>
                                                
                                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                {{-- 2D --}}
                                                                <div class="form-row align-items-center"> 
                                                                    <div style="float: left">
                                                                        <img id="Sprite_2DImg" src="../../../img/Sprite_Pokemon/Sprite_2D/{{$pokemon->Generation}}G/{{$pokemon->Sprite_2D}}" width="100px">
                                                                    </div>
                                                                    <div style="float: right">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="Sprite_2D_inp" onchange="imgChange('Sprite_2D');">
                                                                            <label class="custom-file-label" for="Sprite_2D">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                
                                                                {{-- 3D --}}
                                                                <div class="form-row align-items-center">
                                                                    <div style="float: left">
                                                                        <img id="Sprite_3DImg" src="../../../img/Sprite_Pokemon/Sprite_3D/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D}}">
                                                                    </div>
                                                                    <div style="float: right">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="Sprite_3D_inp" onchange="imgChange('Sprite_3D');">
                                                                            <label class="custom-file-label" for="sprite_3D">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                {{-- 3D_Shiny --}}
                                                                <div class="form-row align-items-center">
                                                                    <div style="float: left">
                                                                        <img id="Sprite_3D_ShinyImg" src="../../../img/Sprite_Pokemon/Sprite_3D_Shiny/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D_Shiny}}">
                                                                    </div>
                                                                    <div style="float: right">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="Sprite_3D_Shiny_inp" onchange="imgChange('Sprite_3D_Shiny');">
                                                                            <label class="custom-file-label" for="sprite_3D_Shiny">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>  
                                                        </div>
                                                    </div>
                                                {{-- 2 volet --}}
                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    [3D_Mega/3D_Mega_Shiny]
                                                                </button>
                                                            </h2>
                                                        </div>
                                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                {{-- 3D_Mega --}}
                                                                <div class="form-row align-items-center">
                                                                    <div style="float: left">
                                                                        <img id="Sprite_3D_MegaImg" src="../../../img/Sprite_Pokemon/Sprite_3D_Mega/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D_Mega}}"/>
                                                                    </div>
                                                                    <div style="float: right">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="Sprite_3D_Mega_inp" onchange="imgChange('Sprite_3D_Mega');">
                                                                            <label class="custom-file-label" for="Sprite_3D_Mega">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                
                                                                {{-- 3D_Mega_Shiny --}}
                                                                <div class="form-row align-items-center">
                                                                    <div style="float: left">
                                                                        <img id="Sprite_3D_Mega_ShinyImg" src="../../../img/Sprite_Pokemon/Sprite_3D_Mega_Shiny/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D_Mega_Shiny}}"/>
                                                                    </div>
                                                                    <div style="float: right">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="Sprite_3D_Mega_Shiny_inp" onchange="imgChange('Sprite_3D_Mega_Shiny');">
                                                                            <label class="custom-file-label" for="Sprite_3D_Mega_Shiny">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- 3 volet --}}
                                                    <div class="card">
                                                        <div class="card-header" id="headingThree">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                    [3D_Gigamax/3D_Gigamax_Shiny]
                                                                </button>
                                                            </h2>
                                                        </div>
                                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                {{-- 3D_Giga --}}
                                                                <div class="form-row align-items-center">
                                                                    <div style="float: left">
                                                                        <img id="Sprite_3D_GigaImg" src="../../../img/Sprite_Pokemon/Sprite_3D_Giga/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D_Giga}}"/>
                                                                    </div>
                                                                    <div style="float: right">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="Sprite_3D_Giga_inp" onchange="imgChange('Sprite_3D_Giga');">
                                                                            <label class="custom-file-label" for="Sprite_3D_Mega">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- 3D_Giga_Shiny --}}
                                                                <div class="form-row align-items-center">
                                                                    <div style="float: left">
                                                                        <img id="Sprite_3D_Giga_ShinyImg" src="../../../img/Sprite_Pokemon/Sprite_3D_Giga_Shiny/{{$pokemon->Generation}}G/{{$pokemon->Sprite_3D_Giga_Shiny}}"/>
                                                                    </div>
                                                                    <div style="float: right">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="Sprite_3D_Giga_Shiny_inp" onchange="imgChange('Sprite_3D_Giga_Shiny');">
                                                                            <label class="custom-file-label" for="Sprite_3D_Mega">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                {{-- Partie Right avec les info  --}}
                                <div class="col-md-8 mb-3" style="float: right">
                                    <div class="card">
                                        <div class="card-body">  
                                            {{-- INDEX NAME ENNAME GEN --}}
                                            <div class="form-row align-items-center">
                                                <div class="col-md-3 mb-3">
                                                    <label style="font-weight: bold">Index</label>
                                                    <input autocomplete="off" type="text" class="form-control" name="index" id="index" value="{{$pokemon->Id}}">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label style="font-weight: bold">Name</label>
                                                    <input autocomplete="off" type="text" class="form-control" name="name" id="name" value="{{$pokemon->Nom}}">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label style="font-weight: bold">English Name</label>
                                                    <input autocomplete="off" type="text" class="form-control" name="name_en" id="name_en" value="{{$pokemon->Nom_Anglais}}">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label style="font-weight: bold" for="gen">Generation</label>
                                                    <select class="custom-select" name="gen" id="gen">
                                                        {{-- TO DO Dans un lointain futur faire un truc plus propre mdrr --}}
                                                        @switch($pokemon->Generation)
                                                            @case(1)
                                                                <option value="1" selected>GENERATION 1</option>
                                                                <option value="2">GENERATION 2</option>
                                                                <option value="3">GENERATION 3</option>
                                                                <option value="4">GENERATION 4</option>
                                                                <option value="5">GENERATION 5</option>
                                                                <option value="6">GENERATION 6</option>
                                                                <option value="7">GENERATION 7</option>
                                                                <option value="8">GENERATION 8</option>
                                                                @break
                                                            @case(2)
                                                                <option value="1">GENERATION 1</option>
                                                                <option value="2" selected>GENERATION 2</option>
                                                                <option value="3">GENERATION 3</option>
                                                                <option value="4">GENERATION 4</option>
                                                                <option value="5">GENERATION 5</option>
                                                                <option value="6">GENERATION 6</option>
                                                                <option value="7">GENERATION 7</option>
                                                                <option value="8">GENERATION 8</option>
                                                                @break
                                                            @case(3)
                                                                <option value="1">GENERATION 1</option>
                                                                <option value="2">GENERATION 2</option>
                                                                <option value="3" selected>GENERATION 3</option>
                                                                <option value="4">GENERATION 4</option>
                                                                <option value="5">GENERATION 5</option>
                                                                <option value="6">GENERATION 6</option>
                                                                <option value="7">GENERATION 7</option>
                                                                <option value="8">GENERATION 8</option>
                                                                @break
                                                            @case(4)
                                                                <option value="1">GENERATION 1</option>
                                                                <option value="2">GENERATION 2</option>
                                                                <option value="3">GENERATION 3</option>
                                                                <option value="4" selected>GENERATION 4</option>
                                                                <option value="5">GENERATION 5</option>
                                                                <option value="6">GENERATION 6</option>
                                                                <option value="7">GENERATION 7</option>
                                                                <option value="8">GENERATION 8</option>
                                                                @break
                                                            @case(5)
                                                                <option value="1">GENERATION 1</option>
                                                                <option value="2">GENERATION 2</option>
                                                                <option value="3">GENERATION 3</option>
                                                                <option value="4">GENERATION 4</option>
                                                                <option value="5" selected>GENERATION 5</option>
                                                                <option value="6">GENERATION 6</option>
                                                                <option value="7">GENERATION 7</option>
                                                                <option value="8">GENERATION 8</option>
                                                                @break
                                                            @case(6)
                                                                <option value="1">GENERATION 1</option>
                                                                <option value="2">GENERATION 2</option>
                                                                <option value="3">GENERATION 3</option>
                                                                <option value="4">GENERATION 4</option>
                                                                <option value="5">GENERATION 5</option>
                                                                <option value="6" selected>GENERATION 6</option>
                                                                <option value="7">GENERATION 7</option>
                                                                <option value="8">GENERATION 8</option>
                                                                @break
                                                            @case(7)
                                                                <option value="1">GENERATION 1</option>
                                                                <option value="2">GENERATION 2</option>
                                                                <option value="3">GENERATION 3</option>
                                                                <option value="4">GENERATION 4</option>
                                                                <option value="5">GENERATION 5</option>
                                                                <option value="6">GENERATION 6</option>
                                                                <option value="7" selected>GENERATION 7</option>
                                                                <option value="8">GENERATION 8</option>
                                                                @break
                                                            @case(8)
                                                                <option value="1">GENERATION 1</option>
                                                                <option value="2">GENERATION 2</option>
                                                                <option value="3">GENERATION 3</option>
                                                                <option value="4">GENERATION 4</option>
                                                                <option value="5">GENERATION 5</option>
                                                                <option value="6">GENERATION 6</option>
                                                                <option value="7">GENERATION 7</option>
                                                                <option value="8" selected>GENERATION 8</option>
                                                                @break
                                                            @default
                                                        @endswitch
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- TYPE --}}
                                            <div class="form-row align-items-center">
                                                <div class="col-md-4 mb-3" >
                                                    <label style="font-weight: bold">First TYPE : </label>
                                                    @foreach ($type_pokemon as $item)
                                                        @if ($pokemon->Type_1==$item->Id)
                                                            <img id="Type_1Img" src="../../../img/Sprite_Type/{{$item->Sprite}}">
                                                        @endif
                                                    @endforeach
                                                    <a id="navbarDropdown" role="button" data-toggle="dropdown">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        @foreach ($type_pokemon as $type)
                                                            <img src="../../../img/Sprite_Type/{{$type->Sprite}}" onclick="change('{{$type->Sprite}}','Type_1Img',{{$type->Id}});"/>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold">Secondary TYPE : </label>
                                                    <img id="Type_2Img" 
                                                    @foreach ($type_pokemon as $item)
                                                        @if ($pokemon->Type_2==$item->Id)
                                                            src="../../../img/Sprite_Type/{{$item->Sprite}}"
                                                        @endif
                                                    @endforeach
                                                    >
                                                    <a id="navbarDropdown" role="button" data-toggle="dropdown">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <div class="dropdown-menu" >
                                                        @foreach ($type_pokemon as $type)
                                                            <img src="../../../img/Sprite_Type/{{$type->Sprite}}" onclick="change('{{$type->Sprite}}','Type_2Img',{{$type->Id}});"/>
                                                        @endforeach
                                                    </div>
                                                    <i class="fas fa-times" style="color: red; cursor: pointer;" onclick="delType()"></i>
                                                </div>

                                                <div class="col-md-2 mb-3">
                                                    <input type="text" id="Type_1ImgInput" name="Type_1ImgInput" style="visibility: hidden" value="{{$pokemon->Type_1}}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <input type="text" id="Type_2ImgInput" name="Type_2ImgInput" style="visibility: hidden" value="{{$pokemon->Type_2}}">
                                                </div>                                    
                                            </div>
                                            {{-- POID ET TAILLE --}}
                                            <div class="form-row align-items-center">
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold" for="height">Height</label>
                                                    <input type="number" step="0.1" min="0" class="form-control" name="height" id="height" value="{{$pokemon->Taille}}">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold" for="weight">Weight</label>
                                                    <input type="number" step="0.1" min="0" class="form-control" name="weight" id="weight" value="{{$pokemon->Poid}}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold" for="weight">Alola Form</label>
                                                    <input type="number" step="1" min="10000" class="form-control" name="Form_Alola" id="Form_Alola" value="{{$pokemon->Form_Alola}}">
                                                </div>
                                            </div>
                                            {{-- DESC --}}
                                            <div class="form-row align-items-center">
                                                <div class="col-md-8 mb-3">
                                                    <!-- textarea -->
                                                    <label for="desc">Description</label>
                                                    <textarea class="form-control" rows="2" name="desc" id="desc">{{$pokemon->Description}}</textarea>
                                                </div>
                                            </div>
                                            
                                            {{-- Temp for Sprite --}}
                                            <div class="form-row">
                                                <input hidden type="text" name="Sprite_2D" id="Sprite_2D" value="{{$pokemon->Sprite_2D}}">
                                                <input hidden type="text" name="Sprite_3D" id="Sprite_3D" value="{{$pokemon->Sprite_3D}}">
                                                <input hidden type="text" name="Sprite_3D_Shiny" id="Sprite_3D_Shiny" value="{{$pokemon->Sprite_3D_Shiny}}">
                                                <input hidden type="text" name="Sprite_3D_Mega" id="Sprite_3D_Mega" value="{{$pokemon->Sprite_3D_Mega}}">
                                                <input hidden type="text" name="Sprite_3D_Mega_Shiny" id="Sprite_3D_Mega_Shiny" value="{{$pokemon->Sprite_3D_Mega_Shiny}}">
                                                <input hidden type="text" name="Sprite_3D_Giga" id="Sprite_3D_Giga" value="{{$pokemon->Sprite_3D_Giga}}">
                                                <input hidden type="text" name="Sprite_3D_Giga_Shiny" id="Sprite_3D_Giga_Shiny" value="{{$pokemon->Sprite_3D_Giga_Shiny}}">
                                            </div>
                                            <!-- Submit -->
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-secondary" name="submit" id="submit"><img src="../../../img/pokeball_menu/Super_Ball.png" alt="pokeball">UPDATE !<img src="../../../img/pokeball_menu/Super_Ball.png" alt="pokeball"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <script>window.location = "/NoPokemonFound_ERROR";</script>')
            @endif

        @else
            <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
                <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
                <p>You don't have access to this page !<br> You are not a Pokemaster ...</p>
            </div>
        @endif  
    @endauth  
@endsection


<script>
    function change(spriteUrl,imgID,spriteId) 
    {
        //on recupere l'url du sprite de la bdd et l'id de la <img> 
        //Puis on prend la div corespondante pour changer la src et on affche la croix pour cancel
        console.log(imgID);
        document.getElementById(imgID).src='../../../img/Sprite_Type/'+spriteUrl;
        //permet de contrer le manque d'input pour les type vu que ce'st de IMG du coup on en creer un invisble avec les atribues
        if (imgID=="Type_1Img") 
        {
            document.getElementById('Type_1ImgInput').value=spriteId; 
        } 
        else 
        {
            document.getElementById('Type_2ImgInput').value=spriteId;
        }

    }
    
    function imgChange(sprite) 
    { 
        var gen = document.getElementById('gen').value;
        var path = document.getElementById(sprite+'_inp').files[0].name;
        document.getElementById(sprite).value=path;

        //on recupere l'url du sprite de la bdd et l'id de la <img> 
        //Puis on prend la div corespondante pour changer la src et on affche la croix pour cancel
        document.getElementById(sprite+'Img').src='../../../img/Sprite_Pokemon/'+sprite+'/'+gen+'G/'+path; 
    }

    function delType() 
    {
        document.getElementById('Type_2Img').src="";
        document.getElementById('Type_2ImgInput').value=null;  
    }
</script>