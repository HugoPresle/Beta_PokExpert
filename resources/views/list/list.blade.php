@php
  use \App\Models\Pokemon;
  use \App\Models\Calendrier;
  use \App\Models\Calendrier_Pokemon;
  use \App\Models\Ligne;
  use \App\Models\User;
@endphp

@extends('layouts.header')
@section('content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </p>
        @endif
        @endforeach
    </div> 
    @if ($public)
        <h1 class="text-center">Public LIST</h1>
        <h5 class="text-center"> You want to create your own list? You need to <a href="./login">login first</a> and then go to the <a href="./create-list">Create a List </a>Section.</h5>
        <br>
        <h6 class="text-center">When you create a list you can choose if you want to make it public. 
            If you want to, your list goes here and people can watch them and see your progression.
            <br>
            ( of course they cannot modify them )
        </h6>
    @else
        <h1 class="text-center">MY LIST</h1>
        <h5 class="text-center"> You want to create a list ? Go to the 
            <a href="./create-list">Create a List </a>section.
        </h5>
        
    @endif
    <form action="../../delete_selected" method="POST" onsubmit="return confirm('Are you sure you want to delete this list ?');">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="p-2 bd-highlight ">
                <input autocomplete="off" type="text" onkeyup="search()" name="searchInp" id="searchInp" class="form-control" placeholder="Search titles..."> 
            </div>
        </div>
        @auth 
            @if (!$public||Auth::user()->rang =='admin')
                <div class="text-center">
                    <a class="btn btn-link" id="mul" onclick="hideChekBox(true)" style="color: black; font-size: 15">
                        Multiple Selections
                        <i class="fas fa-arrows-alt" style="color: rgb(140, 0, 255);"></i>
                    </a>
                    <a class="btn btn-link" hidden id="cancel" onclick="hideChekBox(false)" style="color: black; font-size: 15">
                        Cancel selection
                        <i class="fas fa-ban" style="color: rgb(255, 174, 0);"></i>
                    </a>
                    <button class="btn btn-link" hidden id="del" type="submit" style="color: black; font-size: 15">
                        Delete selected
                        <i class="fas fa-trash" style="color: red;"></i>
                    </button>
                </div>
            @endif
        @endauth
        
        <div class="row col-md-12 mx-auto"> 
            @php
                $i=0;
            @endphp
            @foreach ($calendriers as $calendrier)
                <div class="card col-md-2 col-sm-6" id="card{{$i}}">
                    <div class="text-center">
                        @php
                            $ligne=Ligne::where('Id_calendrier',$calendrier->Id)->first();
                            $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                            $pokemon=Pokemon::where('Id',$calendrier_Pokemon->Id_Pokemon)->first();
                        @endphp
                        <img class="card-img-top" src="../../../img/Sprite_Pokemon/Sprite_2D/{{$pokemon->Generation}}G/{{$pokemon->Nom}}.png" style="width: 30%">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-weight: bold ;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">{{$calendrier->Libelle}}</h5>
                    @if ($public)
                        <p class="card-text" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">By 
                            <a href="./profile/{{User::where('id',$calendrier->Id_User)->first()->name;}}" style="text-decoration: none; color: black;">
                                <strong>
                                    {{User::where('id',$calendrier->Id_User)->first()->name;}}
                                </strong>
                            </a>
                            <br>
                            <a>
                                <?php 
                                    if ($calendrier->Statut==2) 
                                    {
                                        echo '<strong style="color: rgb(21, 146, 21)">[COMPLETED]</strong>';
                                    }
                                    else 
                                    {
                                        echo '<strong style="color: rgb(97, 97, 97)">[...]</strong>';
                                    }
                                ?>
                            </a>
                        </p>
                        <a href="../list/{{$calendrier->Id}}" class="btn btn-secondary" style="font-weight: bold ;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">Let's GO</a>
                        <br><br>
                        <input hidden type="checkbox" id="check{{$i}}" name="check{{$i}}" value="{{$calendrier->Id}}" style="width: 25px; height: 25px;">
                    @else
                        <p class="card-text" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
                            <strong>Satut :</strong>
                            <?php 
                                switch ($calendrier->Statut) 
                                {
                                    case 0:
                                        echo '<a style="color: red">Not started yet...</a>';
                                        break;
                                    
                                    case 1:
                                        echo '<a style="color: orange">In Progress ! </a>';
                                        break;
                                    
                                    case 2:
                                        echo '<a style="color: green">Completed !!!</a>';
                                        break;
                                }
                            ?>
                        </p>
                        <a href="../list/{{$calendrier->Id}}" style="font-weight: bold ;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;" class="btn btn-secondary">Let's GO</a>
                        <br><br>
                        <input hidden type="checkbox" id="check{{$i}}" name="check{{$i}}" value="{{$calendrier->Id}}" style="width: 25px; height: 25px;">
                    @endif
                    </div> 
                </div>
                <br>
                @php
                    $i++;
                @endphp
            @endforeach
        </div>
    </form>
@endsection
<script>
    function submit() 
    {
        document.getElementById("sub").click();
    }
    function hideChekBox(par) 
    {
        @php
            echo "var lenght =".count($calendriers).";";
        @endphp
        if (par==true) 
        { 
            for (i = 0; i < lenght; i++) 
            {
                document.getElementById('check'+i).hidden=false;
            }
            document.getElementById('del').hidden=false;
            document.getElementById('cancel').hidden=false;
            document.getElementById('mul').hidden=true;
        }
        else
        {
            for (i = 0; i < lenght; i++) 
            {
                document.getElementById('check'+i).hidden=true;
            }
            document.getElementById('del').hidden=true;
            document.getElementById('cancel').hidden=true;
            document.getElementById('mul').hidden=false;
        }
    }
    function search() 
    {
        @php
            echo "var lenght =".count($calendriers).";";
        @endphp
        var input,div,h5, i, txtValue;
        input = document.getElementById("searchInp").value.toUpperCase();
        for (i = 0; i <= lenght; i++) 
        {
            div = document.getElementById("card"+i);
            h5=div.childNodes[3].childNodes[1];
            if (h5) {
                txtValue = h5.textContent || h5.innerText;
                if (txtValue.toUpperCase().indexOf(input) > -1) 
                {
                    div.style.display = "";
                } 
                else 
                {
                    div.style.display = "none";
                }
            }       
        }
    }

  //Remove alert apres 5000=5s
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });}, 5000);
</script>