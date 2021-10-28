@php
  use \App\Models\Pokemon;
@endphp

@extends('layouts.header')
@section('content')
    @auth
        @if ($calendrier->Public==0||Auth::user()->id ==$calendrier->Id_User||Auth::user()->rang =='admin')
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </p>
                    @endif
                @endforeach
            </div>   
            <div class="col -md-12">
                <div class="card">
                    <div class="card-header">Modify List</div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form method="POST" action="/modify_list/{{$calendrier->Id}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="col-md-12">
                                                    <label for="" style="font-weight: bold">Form: </label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="Formradio" id="Formradio1" value="0" checked>
                                                        <label class="form-check-label" for="Formradio1">Normal</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="Formradio" id="Formradio3" value="1">
                                                        <label class="form-check-label" for="Formradio3">Gigamax</label>
                                                    </div>
                                                    <br>
                                                    <label for="" style="font-weight: bold">Shiny: </label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ShinyRadio" id="ShinyRadio1" value="0">
                                                        <label class="form-check-label" for="ShinyRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ShinyRadio" id="ShinyRadio2" value="1" checked>
                                                        <label class="form-check-label" for="ShinyRadio2">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <input autocomplete="off" id="searchInp" type="text" placeholder="Search..." class="form-control typeahead" onchange="setCookies()"/>
                                                    {{-- Script autoComplet --}}
                                                    <script>
                                                        var route = "{{ url('autocomplete') }}";    
                                                        $('input.typeahead').typeahead({
                                                            source: function (terms, process) {
                                                                return $.get(route, {terms: terms}, 
                                                                function (data) 
                                                                {
                                                                    return process(data);
                                                                });
                                                            }
                                                        });
                                                    </script>
                                                </div>
                                                <br>
                                                <hr>
                                                <!-- Submit -->
                                                <div class="col-md-12">
                                                    <label for="name" style="font-weight: bold">Liste Name: </label>
                                                    <input maxlength="254" autocomplete="off" required id="name" name="name" type="text" class="form-control" placeholder="MyListName..." value="{{$calendrier->Libelle}}" >
                                                    
                                                    <label for="" style="font-weight: bold">Do you want to make your list public: </label><br>
                                                    @if ($calendrier->Public==0)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="public" id="public" value="0"checked>
                                                            <label class="form-check-label" for="public">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="public" id="public" value="1" >
                                                            <label class="form-check-label" for="public">No</label>
                                                        </div> 
                                                    @else
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="public" id="public" value="0">
                                                            <label class="form-check-label" for="public">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="public" id="public" value="1" checked>
                                                            <label class="form-check-label" for="public">No</label>
                                                        </div> 
                                                    @endif
                                                    <br>
                                                    <br>
                                                </div>
                                                <div class="d-flex justify-content-start">
                                                    <div class="p-2 bd-highlight">
                                                        <button class="btn btn-link" style="color: inherit;font-size:15px" type="submit" name="submit" id="submit" onclick="createData()">
                                                            Save My List <i class="fas fa-save" style="color: rgb(21, 192, 35);"></i>
                                                        </button>
                                                    </div>
                                                    <div class="p-2 bd-highlight">
                                                        <a class="btn btn-link" style="color: inherit;font-size:15px" onclick="return confirm('Are you sure you want cancel the modifications ?');" href="../my_list"> 
                                                            Cancel <i class="fas fa-ban" style="color: rgb(255, 136, 0);"></i>
                                                        </a>
                                                    </div> 
                                                    <div class="p-2 bd-highlight">
                                                        <a class="btn btn-link" style="color: inherit;font-size:15px" onclick="clearAll()">
                                                            Clear The List <i class="fas fa-trash" style="color: red;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- la meme combine input cahcer pour get donner --}}
                                                    <div hidden >
                                                        <input type="text" name="pokemon_name" id="pokemon_name">
                                                    </div>
                                                <br>
                                            </div>
                                            <div class="col-md-8 card">
                                                <br>
                                                <div style="height:500px;overflow:auto;">
                                                    <table id="Table" class="table table table-striped table-hover table-sm">
                                                        <thead class="thead-dark" style="position: sticky; top: 0; z-index: 1;">
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Sprite</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                try 
                                                                {  
                                                                    $tab1=[];
                                                                    $tab2=[];
                                                                    $data=json_decode($_COOKIE["JsonModify"], true);
                                                                    try {$tab1= explode(",",$data['Last']);}catch (\Throwable $th) {}
                                                                    try {$tab2= explode(",",$data['New']);}catch (\Throwable $th) {}
                                                                    $tabs= array_merge($tab1,$tab2);
                                                                    foreach ($tabs as $tab) 
                                                                    {
                                                                        try 
                                                                        {   
                                                                            $newpokemon= explode("/",$tab);
                                                                            $tabPokemons[]=
                                                                            [
                                                                                "Name"=>$newpokemon[0],
                                                                                "Form"=>$newpokemon[1],
                                                                                "Shiny"=>$newpokemon[2],
                                                                                "Statut"=>$newpokemon[3]
                                                                            ];
                                                                        } catch (\Throwable $th) {}
                                                                    }
                                                                    foreach ($tabPokemons as $tabPokemon) 
                                                                    {
                                                                        try 
                                                                        {
                                                                            $pokemon=Pokemon::where('Nom',$tabPokemon['Name'])->firstOrFail();
                                                                            switch ($tabPokemon['Form'])
                                                                            {
                                                                                case 0:
                                                                                    $sprite="Sprite_3D";
                                                                                    break;
                                                                                case 1: 
                                                                                    if ($pokemon->Sprite_3D_Giga) 
                                                                                    {
                                                                                        $sprite="Sprite_3D_Giga";
                                                                                    }
                                                                                    else 
                                                                                    {      
                                                                                        $sprite="Sprite_3D";
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            switch ($tabPokemon['Shiny']) 
                                                                            {
                                                                                case 0:
                                                                                    $shiny="_Shiny";
                                                                                    break;
                                                                                case 1:
                                                                                    $shiny="";
                                                                                    break;
                                                                            }?>
                                                                            <tr>
                                                                                <td>{{$pokemon->Nom}}</td>
                                                                                <td><img src="../../../img/Sprite_Pokemon/{{$sprite}}{{$shiny}}/{{$pokemon->Generation}}G/{{$pokemon->$sprite}}"></td>  
                                                                                <td><i class="fas fa-trash-alt" style="color: red" onclick="deleteCookies('{{$tabPokemon['Name']}}','{{$tabPokemon['Form']}}','{{$tabPokemon['Shiny']}}','{{$tabPokemon['Statut']}}')"></i></td>
                                                                            </tr><?php
                                                                        } catch (\Throwable $th) {}
                                                                    }
                                                                }
                                                                catch (\Throwable $th){}
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
                <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
                <p>This list is not public and you are not the owner.</p>
            </div>
        @endif
    @endauth 
    @guest
        <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
            <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
            <p>You must log in to access this page</p><a href="./login" class="alert-link">LOGIN ?</a>
        </div>
    @endguest
@endsection
<script>
    //Remove alert apres 5000=5s
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
      });}, 5000);

    function createData() 
    {
        console.log(getCookie('JsonModify'));
        var string=getCookie('JsonModify').
            replaceAll('"',"").
            replace(',,',",").
            replaceAll('{Last:,',"").
            replaceAll('New:',"").
            replaceAll('}',"");
        console.log(string);
        document.getElementById('pokemon_name').value=string;
        document.cookie = 'JsonModify=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        document.location.reload();
    }

    function setCookies() 
    { 
        var name=document.getElementById('searchInp').value;
        if (name.length>=4) 
        {
            document.cookie='JsonModify='+JSON.stringify
                ({
                    Last:getCookie("JsonModify").
                         replaceAll('"',"").
                         replaceAll('{Last:',"").
                         replaceAll('New:',"").
                         replaceAll('}',"").
                         replaceAll(/\\/g,""),

                    New: name+'/'+radioCheck(document.getElementsByName('Formradio'))+'/'+radioCheck(document.getElementsByName('ShinyRadio'))+'/0'
                })+';path=/;max-age=7200';
            document.location.reload();
        }
        else
        {
            if (name=='Abo'|| name=='Mew'|| name=='Tic') 
            {
                document.cookie='JsonModify='+JSON.stringify
                ({
                    Last:getCookie("JsonModify").
                         replaceAll('"',"").
                         replaceAll('{Last:',"").
                         replaceAll('New:',"").
                         replaceAll('}',"").
                         replaceAll(/\\/g,""),

                    New: ','+name+'/'+radioCheck(document.getElementsByName('Formradio'))+'/'+radioCheck(document.getElementsByName('ShinyRadio'))+'/0'
                })+';path=/;max-age=7200';
                document.location.reload();
            }
        }
    }

    function radioCheck(radio) 
    {
        for (var i = 0, length = radio.length; i < length; i++) 
        {
            if (radio[i].checked) 
            {
                return radio[i].value;
                break;
            }
        }
    }

    function getCookie(cname) 
    {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) 
        {
            let c = ca[i];
            while (c.charAt(0) == ' ') 
            {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) 
            {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function deleteCookies(name,form,shiny,statut) 
    {
        string=name+'/'+form+'/'+shiny+'/'+statut
        document.cookie='JsonModify='+JSON.stringify
                ({
                    Last:getCookie("JsonModify").
                         replaceAll('{"Last":',"").
                         replaceAll('"',"").
                         replaceAll('New:',"").
                         replaceAll('}',"").
                         replaceAll(/\\/g,"").
                         replace(string,"").
                         replace(",,",",")
                         })+';path=/;max-age=7200';
        document.location.reload();
    }

    function clearAll() 
    {
        var agree=confirm("Are you sure you want to remove all pokemon from this list ?");
        if (agree)
        {
            document.cookie = 'JsonModify=; path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            document.location.reload();
        }
    }
</script>