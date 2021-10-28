@php
  use \App\Models\Pokemon;
  use \App\Models\Calendrier;
  use \App\Models\Calendrier_Pokemon;
  use \App\Models\User;
@endphp

@extends('layouts.header')
@section('content')
@auth
    @php
        $user=User::where('id',Auth::user()->id)->firstOrFail();
    @endphp
@endauth
    @if ($calendrier->Public==0||$user->id==$calendrier->Id_User||$user->rang=='admin')
      <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
          @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </p>
          @endif
        @endforeach
      </div> 
      <div>  
        <form method="POST" action="/update_list/{{$calendrier->Id}}">
          @csrf
          <h1 class="text-center"><strong>List :</strong> 
            <a id="title">
              {{$calendrier->Libelle}}
            </a>
            <input type="text" value="{{$calendrier->Libelle}}" hidden name="titleEdit" id="titleEdit" >
            @auth
              @if (Auth::user()->id ==$calendrier->Id_User ||Auth::user()->rang =='admin')
                <i class="fas fa-edit" style="cursor: pointer;" onclick="changeTitle(0)" id="img0"></i>
                <i hidden class="fas fa-times" style="cursor: pointer;color: red;"  onclick="changeTitle(1)" id="img1"></i>
              @endif
            @endauth
          </h1>
          @guest
            <h5 class="text-center">Want to copy this list ? You need to <a href="../login">login first</a> and then come back to this page.</h5>
          @endguest
          <h4 class="text-center">Finish : 
            <?php 
              switch (true) 
              {
                  case $totalP==100:
                      echo '<a style="color: rgb(4, 216, 4)">'.$totalP.'%</a>';
                      break;
                  case $totalP>80:
                      echo '<a style="color: rgb(157, 255, 0)">'.$totalP.'%</a>';
                      break;
                  case $totalP>60:
                      echo '<a style="color: rgb(255, 217, 0)">'.$totalP.'%</a>';
                      break;
                  case $totalP>40:
                      echo '<a style="color: orange">'.$totalP.'%</td>';
                      break;
                  case $totalP>20:
                      echo '<a style="color: rgb(255, 81, 0)">'.$totalP.'%</a>';
                      break;
                  case $totalP<20:
                      echo '<a style="color: red">'.$totalP.'%</a>';
                      break;
                      
              }
            ?>
          </h4>
          <div class="col-md-10 mx-auto" >
            <div class="card">
              <div class="card-header">
                <div style="float: right">
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('1')">1G</a> |
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('2')">2G</a> |
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('3')">3G</a> |
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('4')">4G</a> |
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('5')">5G</a> |
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('6')">6G</a> |
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('7')">7G</a> |
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('8')">8G</a> |
                  <a type="button" style="text-decoration: none; color: rgb(65, 66, 68)" onclick="btnGen('')">
                    <i class="fas fa-times" style="color: red"></i>
                  </a>
                </div>
                <input autocomplete="off" style="float: left" type="text" class="form-control col-md-4" id="searchInp" onkeyup="searchBar()" placeholder="Search..">
              </div>
              <div style="height:600px; overflow:auto;" class="m-1">
                <table class="table table table-striped table-hover table-sm sortable" id="table">
                  <thead class="thead-dark" style="position: sticky; top: 0; z-index: 1;">
                      <tr>
                          <th>Index</th>
                          <th>Name</th>
                          <th>Sprite</th>
                          <th>Statut</th>
                          <th hidden>Gen</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                        $i=0;
                        foreach ($lignes as $ligne)
                        {
                          $i++;
                          $calendriers_pokemons = Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->get();
                          foreach ($calendriers_pokemons as $calendrier_pokemon) 
                          {
                            $pokemon=Pokemon::where('Id',$calendrier_pokemon->Id_Pokemon)->first();
                            switch ($calendrier_pokemon->Form)
                            {
                              case 0:
                                  $sprite="Sprite_3D";
                                  break;
                              case 1: 
                                  if ($pokemon->Sprite_3D_Giga) 
                                  {
                                      $sprite="Sprite_3D_Giga";
                                  }
                                  // else pour gerer erreur si le pokemon na pas de giga form qu'il puisse quand meme etre afficher
                                  else 
                                  {   
                                      $sprite="Sprite_3D";
                                  }
                                  break;
                            }
                            switch ($calendrier_pokemon->Shiny) 
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
                                <td>{{$i}}</td>
                                <td>
                                  <a style="color: inherit;text-decoration: none" href="../pokedex/{{$pokemon->Nom}}" style="text-decoration: none">{{$pokemon->Nom}}</a>
                                </td>
                                <td>
                                  <a style="color: inherit;text-decoration: none" href="../pokedex/{{$pokemon->Nom}}" style="text-decoration: none">
                                    <img src="../../../img/Sprite_Pokemon/{{$sprite}}{{$shiny}}/{{$pokemon->Generation}}G/{{$pokemon->$sprite}}">
                                  </a>
                                </td>  
                                <td>
                                    <input name="statut{{$calendrier_pokemon->Id}}" style="width: 30px; height: 30px;" class="form-check-input position-static" type="checkbox" id="statut{{$calendrier_pokemon->Id}}"
                                    <?php 
                                      if ($calendrier_pokemon->Statut==1) 
                                      {
                                        echo 'checked';
                                      }?> >
                                </td>
                                <td hidden>{{$pokemon->Generation}}</td>
                            </tr><?php
                          }
                        } 
                      ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="d-flex flex-row bd-highlight mb-3 justify-content-center">
            @auth
              @if (Auth::user()->id ==$calendrier->Id_User ||Auth::user()->rang =='admin' )
                  <div class="p-2 bd-highlight">
                    <button type="submit" class="btn btn-link" name="btnsubmit" id="btnsubmit" style="color: rgb(0, 0, 0);;font-size: 20px">
                        Save <i class="fas fa-save" style="color: rgb(21, 192, 35)"></i>
                      </button>
                    </form>
                  </div>
                  <div class="p-2 bd-highlight">
                    <a class="btn btn-link" href="../modify-list/{{$calendrier->Id}}" onclick="CreateJson()" style="color: rgb(0, 0, 0);font-size: 20px">
                      Modify <i class="fas fa-edit" style="color: rgb(0, 162, 255)"></i>
                    </a>
                  </div> 
                @endif
                  <div class="p-2 bd-highlight">
                    <a class="btn btn-link" href="../copy_list/{{$calendrier->Id}}" style="color: rgb(0, 0, 0);font-size: 20px">
                      Copy <i class="fas fa-copy" style="color: rgb(153, 0, 255)"></i>
                    </a>
                  </div>
              @if (Auth::user()->id ==$calendrier->Id_User ||Auth::user()->rang =='admin' )
                  <div class="p-2 bd-highlight">
                    <form method="POST" action="../../delete_list/0/{{$calendrier->Id}}" id="deleteform" onsubmit="return confirm('Are you sure you want to delete this list ?');">
                      @csrf
                      <button type="submit" class="btn btn-link" name="delete" id="delete" style="color: rgb(0, 0, 0);font-size: 20px">
                        Delete <i class="fas fa-trash" style="color: red;"></i>
                      </button>
                    </form>
                  </div>
                @endif    
            @endauth
          </div>
    @else
      <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
          <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
          <p>This list is not public and you are not the owner.</p>
      </div>
    @endif
@endsection
<script>
  //Remove alert apres 5000=5s
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });}, 5000);

  function changeTitle(value) 
  {
    if (value==0) 
    {
      document.getElementById('titleEdit').hidden=false;
      document.getElementById('title').hidden=true;
      document.getElementById('img0').hidden=true;
      document.getElementById('img1').hidden=false;
    }
    else
    {
      document.getElementById('titleEdit').hidden=true;
      document.getElementById('title').hidden=false;
      document.getElementById('img0').hidden=false;
      document.getElementById('img1').hidden=true;

    }
  }
  
  function searchBar() 
  {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInp");
    filter = input.value.toUpperCase();
    table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[1]; 
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) 
        {
          tr[i].style.display = "";
        } 
        else 
        {
          tr[i].style.display = "none";
        }
      }       
    }
  }

  function btnGen(input) 
  {
    var filter, table, tr, td, i, txtValue;
    filter = input.toUpperCase();
    table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[4]; 
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) 
        {
          tr[i].style.display = "";
        } 
        else 
        {
          tr[i].style.display = "none";
        }
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

  function CreateJson() 
  {
    
    document.cookie = 'JsonModify=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    @php 
        foreach ($lignes as $ligne) 
        {
            $calendrier_Pokemon=Calendrier_Pokemon::where("Id",$ligne->Id_calendrier_pokemon)->first();
            $pokemons[]=Pokemon::where("Id",$calendrier_Pokemon->Id_Pokemon)->first()->Nom."/".$calendrier_Pokemon->Form."/".$calendrier_Pokemon->Shiny."/".$calendrier_Pokemon->Statut;
        }
            echo "var js_pokemon =".json_encode($pokemons).";";
    @endphp
    for (let index = 0; index < js_pokemon.length; index++) 
    {
      document.cookie='JsonModify='+JSON.stringify
          ({
              Last:getCookie("JsonModify").
                  replaceAll('"',"").
                  replaceAll('{Last:',"").
                  replaceAll('New:',"").
                  replaceAll('}',"").
                  replaceAll(/\\/g,"")+","+js_pokemon[index],
              })+';path=/;max-age=7200';
    }
  }
</script>