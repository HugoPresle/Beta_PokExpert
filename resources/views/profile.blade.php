@php
  use \App\Models\Sprite;
  use \App\Models\Calendrier;
  use \App\Models\Calendrier_Pokemon;
  use \App\Models\Ligne;
@endphp

@extends('layouts.header')
@section('content')
@auth
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
        @endforeach
    </div>
    @php
        $pageUser=Auth::user();
        $isUser=true;
        try 
        {
            if (Auth::user()->id!=$user->id) 
            {
                $pageUser=$user;
                $isUser=false; //valeure temp pour savoir si le user est sur ça propre page 
            }
        } 
        catch (\Throwable $th) 
        {
        }  
        $nbList=0;
        $nbPokemon=0;
        $calendriers=Calendrier::where('Id_User',$pageUser->id)->get();
        foreach ($calendriers as $calendrier) 
        {
            if ($calendrier->Statut==2) 
            {
                $nbList++;
            }
            /*****    Nb_Pokemon    *****/
            $lignes=Ligne::where('Id_calendrier',$calendrier->Id)->get();

            foreach ($lignes as $ligne) 
            {
                $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                if ($calendrier_Pokemon->Statut==1) 
                {
                    $nbPokemon++;
                }
            } 
        }
    @endphp
    <h1 class="text-center">PROFILE</h1>
    @if ($isUser)
        <h4 class="text-center">Welcome {{strtoupper($pageUser->name)}} !!!</h4>
    @else
        <h4 class="text-center">Welcome to {{strtoupper($pageUser->name)}}'s Page !!!</h4>
    @endif
    <br>
    <div class="container">
        <div class="main-body">
            <form action="../update_profile/{{ $pageUser->id }}" method="POST" id="form">
                @csrf
                <input hidden type="text" id="SpriteImgInput" name="SpriteImgInput" value="{{ $pageUser->Sprite }}">

                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="../../../img/Sprite_Trainer/{{ $pageUser->Sprite }}" id="SpriteImg" class="rounded-circle" width="400">
                                    <div class="mt-3">
                                        <h4>{{ strtoupper($pageUser->name) }}</h4>
                                        <p class="text-secondary mb-1">{{$pageUser->description}}</p>
                                        @if ($isUser)
                                            <a id="navbarDropdown" role="button" data-toggle="dropdown">
                                                <p class="text-secondary mb-1"> 
                                                    CHANGE PROFILE PICT
                                                    <i class="fas fa-edit"></i>
                                                </p>
                                            </a>
                                            <div class="dropdown-menu">
                                                @foreach (Sprite::all() as $type)
                                                <img src="../../../img/Sprite_Trainer/{{$type->Sprite_Libelle}}" style="width: 100px"
                                                onclick="change('{{$type->Sprite_Libelle}}','SpriteImg');"/>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                        </svg>
                                        Nintendo Code :
                                    </h6>
                                    <span id="friendCode" class="text-secondary">{{$pageUser->friend_Code}}</span>
                                    <input autocomplete="false" class="form-control"  hidden id="friendCodeEdit" name="friendCode" type="text" value="{{$pageUser->friend_Code}}" placeholder="0000-0000-0000" maxlength="14">
                                </li> 
                            </ul>
                            <script>
                                document.getElementById('friendCodeEdit').addEventListener("keyup", function()
                                {
                                    txt=this.value;
                                    if (txt.length==4 || txt.length==9)
                                        this.value=this.value+"-";
                                });
                            </script>
                        </div>
                    </div>

                    <div class="col-md-8">
                        @if ($isUser)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row" id="divName">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{$pageUser->name}}
                                        </div>
                                    </div>
                                    {{-- hiden when not modify --}}
                                    <div class="row" id="divNameEdit" hidden>  
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input maxlength="100" autocomplete="off" class="form-control" name="name" type="text" value="{{$pageUser->name}}">
                                        </div>
                                    </div>
                                        <hr>
                                    <div class="row" id="divEmail">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{$pageUser->email}}
                                        </div>
                                    </div>
                                    {{-- hiden when not modify --}}
                                    <div class="row" id="divEmailEdit" hidden>  
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input maxlength="254" autocomplete="off" class="form-control" name="email" type="text" value="{{$pageUser->email}}">
                                        </div>
                                    </div>
                                        <hr>
                                    <div class="row" id="divDescription">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Description</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{$pageUser->description}}
                                        </div>
                                    </div>
                                    {{-- hiden when not modify --}}
                                    <div class="row" id="divDescriptionEdit" hidden>  
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Description</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input autocomplete="off" class="form-control"  name="description" type="text" value="{{$pageUser->description}}">
                                        </div>
                                    </div>
                                        <hr>

                                    <div class="row">
                                        <div class="col-sm-12" id="Edit">
                                            <a class="btn btn-secondary " onclick="editionMode();">Edit</a>
                                        </div>
                                        <div class="col-sm-12" id="updateEdit" hidden>
                                            <button type="submit" class="btn btn-secondary" name="btnsubmit" id="btnsubmit">Update</button>
                                            <a class="btn btn-danger " href="./profile">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <hr>
                        <h4><strong>STATS</strong></h4>
                        <div class="row ">
                            <div class="col-xl-6 col-sm-6 col-12"> 
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="align-self-center">
                                                    <img src="../../../img/pokeball_menu/Filet_Ball.png" class="mr-3" width="50">
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3>{{$nbPokemon}}</h3>
                                                    <span style="color: rgb(8, 155, 160)">Total Pokemon Caught</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6 col-12"> 
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="align-self-center">
                                                    <img src="../../../img/pokeball_menu/Faiblo_Ball.png" class="mr-4" width="50">
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3>{{$nbList}}</h3>
                                                    <span style="color: rgb(57, 219, 42)">Total List Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endauth 
@guest
    <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
        <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
        <p>You must log in to access this page</p><a href="../login" class="alert-link">LOGIN ?</a>
    </div>
@endguest
@endsection
<script>
    //Remove alert apres 5000=5s
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
      });}, 5000);
    function change(sprite,imgID) 
    {
        document.getElementById(imgID).src='../../../img/Sprite_Trainer/'+sprite;
        document.getElementById('SpriteImgInput').value=sprite; 
        document.getElementById('form').submit();
    }
    function editionMode() 
    {
        document.getElementById('friendCodeEdit').hidden=false;
        document.getElementById('friendCode').hidden=true;

        document.getElementById('divNameEdit').hidden=false;
        document.getElementById('divName').hidden=true;
        
        document.getElementById('divEmailEdit').hidden=false;
        document.getElementById('divEmail').hidden=true;
        
        document.getElementById('divDescriptionEdit').hidden=false;
        document.getElementById('divDescription').hidden=true;

        document.getElementById('updateEdit').hidden=false;
        document.getElementById('Edit').hidden=true;
        
    }
</script>