@php
  use \App\Models\Pokemon;
@endphp

@extends('layouts.header')
@section('content')
    @auth
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
                <div class="card-header">Create List</div>
                <div class="card-body">
                    <div class="container-fluid">
                        <form method="POST" action="/create_list">
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
                                                <input autocomplete="off" required id="name" name="name" type="text" class="form-control" placeholder="MyListName..." >
                                                
                                                <label for="" style="font-weight: bold">Do you want to make your list public: </label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="public" id="public" value="0">
                                                    <label class="form-check-label" for="public">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="public" id="public" value="1" checked>
                                                    <label class="form-check-label" for="public">No</label>
                                                </div>
                                                <br>
                                                <br>
                                                <div>
                                                    <button type="submit" class="btn btn-secondary" name="submit" id="submit" onclick="createData()">
                                                        <img src="../../../img/pokeball_menu/Hyper_Ball.png" alt="pokeball">
                                                        Create My list !
                                                        <img src="../../../img/pokeball_menu/Hyper_Ball.png" alt="pokeball">
                                                    </button>
                                                </div>
                                            </div>
                                            {{-- la meme combine input cahcer pour get donner --}}
                                            <div hidden >
                                                <input type="text" name="pokemon_name" id="pokemon_name">
                                                <input type="text" name="user" id="user" value="{{Auth::user()->id}}">
                                            </div><br>
                                        </div>
                                        <div class="col-md-8 card">
                                            <br>
                                            <div style="height:500px;overflow:auto;">
                                                <table class="table table table-striped table-hover table-sm">
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
                                                                $id=htmlspecialchars($_COOKIE["id"]);
                                                                for ($i=0; $i<$id;$i++ ) 
                                                                {    
                                                                    try 
                                                                    {
                                                                        $data=json_decode($_COOKIE["name$i"], true);
                                                                        $pokemon=Pokemon::where('Nom',$data['name'])->first();
                                                                        if ($pokemon) 
                                                                        {
                                                                            switch ($data['form'])
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
                                                                            switch ($data['shiny']) 
                                                                            {
                                                                                case 0:
                                                                                    $shiny="_Shiny";
                                                                                    break;
                                                                                case 1:
                                                                                    $shiny="";
                                                                                    break;
                                                                            }
                                                                            ?>
                                                                        <tr>
                                                                            <td>{{$pokemon->Nom}}</td>
                                                                            <td ><img src="../../../img/Sprite_Pokemon/{{$sprite}}{{$shiny}}/{{$pokemon->Generation}}G/{{$pokemon->$sprite}}"></td>  
                                                                            <td><i class="fas fa-trash-alt" style="color: red" onclick="deleteCookies('name{{$i}}')"></i></td>
                                                                        </tr><?php 
                                                                        }
                                                                        
                                                                    }
                                                                    catch (\Throwable $th)
                                                                    {
                                                                        echo '<div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
                                                                                <h4><i class="fas fa-exclamation-triangle"></i> Oops</h4>
                                                                                <p>Something went wrong... Please reload the page.</a>
                                                                            </div>';
                                                                    }  
                                                                } 
                                                            }catch (\Throwable $th){}
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
                                            <a style="color: red; font-weight: bold" type="button" onclick="clearAll()">
                                                Clear The List 
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth 
    @guest
        <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
            <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
            <p>You must log in to access this page</p><a href="./login" class="alert-link">LOGIN ?</a>
        </div>
    @endguest
@endsection
<script>
    window.onload = load();
    function load() 
    {
        if (!getCookie("id")) 
        {        
            document.cookie='id=0';
        }
    }

    function createData() 
    {
        var i=getCookie('id');
        var list="";
        for (let index = 0; index < i; index++) 
        {
            list=list+getCookie('name'+index);
            document.cookie = 'name'+index+'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            document.cookie = 'id=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
            // Pour avoir le string ideal pour le controler pour explode
        list=list
                .replaceAll("}{","/")
                .replaceAll("{","")
                .replaceAll("\"name\":","")
                .replaceAll("\"form\":","")
                .replaceAll("\"shiny\":","")
                .replaceAll("\"","")
                .replaceAll("}","")
                ;
        document.getElementById('pokemon_name').value=document.getElementById('pokemon_name').value+list;
    }

    function setCookies() 
    { 
        var name=document.getElementById('searchInp').value;
        if (name.length>=4) 
        {
            cookieId=getCookie("id");
            document.cookie='name'+cookieId+'='+JSON.stringify
                ({
                    name: name,
                    form:radioCheck(document.getElementsByName('Formradio')),
                    shiny:radioCheck(document.getElementsByName('ShinyRadio')) 
                })+';max-age=7200';

            cookieId=+cookieId+1
            document.cookie='id='+cookieId+';max-age=7200';
            document.location.reload();
        }
        else
        {
            if (name=='Abo'|| name=='Mew'|| name=='Tic') 
            {
                cookieId=getCookie("id");
                document.cookie='name'+cookieId+'='+JSON.stringify
                    ({
                        name: name,
                        form:radioCheck(document.getElementsByName('Formradio')),
                        shiny:radioCheck(document.getElementsByName('ShinyRadio')) 
                    })+';max-age=7200';

                cookieId=+cookieId+1
                document.cookie='id='+cookieId+';max-age=86400';
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

    function deleteCookies(cname) 
    {
        document.cookie = cname +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        document.location.reload();
    }

    function clearAll() 
    {
        var agree=confirm("Are you sure you want to remove all pokemon from this list ?");
        if (agree)
        {
            var i=getCookie('id');
            for (let index = 0; index < i; index++) 
            {
                document.cookie = 'name'+index+'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                document.cookie = 'id=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                document.location.reload();
            }
        }
    }
</script>