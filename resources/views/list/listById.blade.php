@php
  use \App\Models\Pokemon;
  use \App\Models\Calendrier;
  use \App\Models\Calendrier_Pokemon;
  use \App\Models\User;
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
      <div>  
        <form method="POST" action="/update_list/{{$calendrier->Id}}">
          @csrf
          <h1 class="text-center"><strong>List :</strong> 
            <a id="title">
              {{$calendrier->Libelle}}
            </a>
            <input type="text" value="{{$calendrier->Libelle}}" hidden name="titleEdit" id="titleEdit" style="width: auto">
              @if (Auth::user()->id ==$calendrier->Id_User ||Auth::user()->rang =='admin')
                <i class="fas fa-edit" style="cursor: pointer;" onclick="changeTitle(0)" id="img0"></i>
                <i hidden class="fas fa-times" style="color: red;cursor: pointer;"  onclick="changeTitle(1)" id="img1"></i>
              @endif
          </h1>
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
                                  if ($pokemon->Sprite_3D_Mega) 
                                  {
                                      $sprite="Sprite_3D_Mega";
                                  }
                                  else 
                                  {   
                                      $sprite="Sprite_3D";
                                  }
                                  break;
                              case 2: 
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
                                <td>{{$pokemon->Nom}}</td>
                                <td>
                                  <img src="../../../img/Sprite_Pokemon/{{$sprite}}{{$shiny}}/{{$pokemon->Generation}}G/{{$pokemon->$sprite}}">
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
          <br>
              @if (Auth::user()->id ==$calendrier->Id_User ||Auth::user()->rang =='admin' )
                  <div class="text-center">
                    <button type="submit" class="btn btn-secondary" name="btnsubmit" id="btnsubmit">
                      <img src="../../../img/pokeball_menu/Hyper_Ball.png" alt="pokeball">
                        Save Statut !
                        <img src="../../../img/pokeball_menu/Hyper_Ball.png" alt="pokeball">
                    </button>
                  </div>
          </form>
              <div class="text-center">
                <form method="POST" action="/delete_list/0/{{$calendrier->Id}}" id="deleteform" onsubmit="return confirm('Are you sure you want to delete this list ?');">
                  @csrf
                  <button type="submit" class="btn btn-danger" name="delete" id="delete" >
                      Delete <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
          @endif
      </div>
        
    @else
      <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
          <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
          <p>This list is not public and you are not the owner.</p>
      </div>
    @endif
  @endauth

  @guest
    {{-- Doublon de code a voir comment y remedier --}}
    @if ($calendrier->Public==0)
      <h1 class="text-center"><strong>List :</strong> 
        <a id="title">{{$calendrier->Libelle}}</a>
      </h1>
      <h4 class="text-center">Finish : <?php 
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
                
        }?>
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
                              if ($pokemon->Sprite_3D_Mega) 
                              {
                                  $sprite="Sprite_3D_Mega";
                              }
                              else 
                              {   
                                  $sprite="Sprite_3D";
                              }
                              break;
                          case 2: 
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
                            <td>{{$pokemon->Nom}}</td>
                            <td>
                              <img src="../../../img/Sprite_Pokemon/{{$sprite}}{{$shiny}}/{{$pokemon->Generation}}G/{{$pokemon->$sprite}}">
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
        
    @else
      <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
          <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
          <p>This list is not public and you are not the owner.</p>
      </div>
    @endif
  @endguest

@endsection
<script>
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
</script>