@php
  use \App\Models\Pokemon;
@endphp

@extends('layouts.header')
@section('content')
  <h1 style="text-align: center">POKEDEX</h1>
  <br>
  <div class="flash-message">
      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
      @endforeach
  </div>

  <form action="../../create_selected" method="POST" onsubmit="return confirm('Are you sure you want to create this list ?');">
    @csrf
    <div class="col-md-auto">
      <div class="card">
        <div class="card-header">Pokedex
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
        </div>
        <div class="card-body">
          @auth
            <a class="btn btn-link" id="true" onclick="hideChekBox(true)" style="color: black; font-size: 15">
              Open the list editor
              <i class="fas fa-list" style="color: rgb(140, 0, 255);"></i>
            </a>
            <a class="btn btn-link" hidden id="false" onclick="hideChekBox(false)" style="color: black; font-size: 15">
                Cancel selection
                <i class="fas fa-ban" style="color: rgb(255, 174, 0);"></i>
            </a>
            <button class="btn btn-link" hidden id="create" type="submit" style="color: black; font-size: 15">
              Create List
              <i class="fas fa-plus" style="color: rgb(58, 197, 3);"></i>
            </button>
          @endauth
          
          <input autocomplete="off" style="float: right" type="text" class="form-control col-md-2" id="searchInp" onkeyup="searchBar()" placeholder="Search..">
            <br><br>
            <div class="table-responsive-sm">
              <table class="table table-striped table-hover table-sm sortable" id="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="row">Index</th>
                    <th></th>
                    <th>Name</th>
                    <th>English name</th>
                    <th>Type</th>
                    <th hidden>Gen</th>
                    @auth
                      <th hidden id="th">Add to List 
                        <a href="#" id="select" onclick="selectAll(true)">(Select All)</a>
                        <a href="#" id="unselect" hidden onclick="selectAll(false)" style="color: red">(Unselect All)</a>
                      </th>
                      {{-- seulement si admin --}}
                      @if (Auth::user()->rang =='admin')
                        <th >Utils</th>
                      @endif
                    @endauth
                  </tr>
                </thead>
                <tbody>
                  @php
                      $i=0;
                  @endphp
                  @foreach ($pokemons as $pokemon)
                      @if ($pokemon->Id<10000) {{-- Pour cacher les formes alola qui on un id de plus de 10.000 --}}
                        <tr>
                            <td> {{$pokemon->Id}} </td>
                            <td>
                              <a style="text-decoration: none"  href="../pokedex/{{$pokemon->Nom}}">
                                <img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$pokemon->Generation}}G/{{$pokemon->Sprite_2D}}" alt=""></td>
                              </a>
                            <td>
                              <a style="color: inherit;"  href="../pokedex/{{$pokemon->Nom}}">
                                {{$pokemon->Nom}}
                              </a>
                            </td>
                            <td> {{$pokemon->Nom_Anglais}} </td>
                            <td>
                              @foreach ($type_pokemon as $item) 
                                  @if ($pokemon->Type_1==$item->Id)
                                    <a hidden>{{$pokemon->Type_1.'.'.$pokemon->Type_2}}</a>
                                    <img alt="{{$pokemon->Type_1}}" src="../../../img/Sprite_Type/{{$item->Sprite}}">
                                  @endif
                              @endforeach
                              @foreach ($type_pokemon as $item) 
                                @if ($pokemon->Type_2==$item->Id)
                                  - <img alt="{{$pokemon->Type_2}}" src="../../../img/Sprite_Type/{{$item->Sprite}}">
                                @endif
                              @endforeach
                            </td>
                            <td hidden>{{$pokemon->Generation}}</td>
                            @auth
                              <td hidden name="td{{$i}}">
                                <input type="checkbox" id="{{$pokemon->Id}}" name="{{$pokemon->Id}}" value="{{$pokemon->Id}}" style="width: 25px; height: 25px;">
                              </td>
                            {{-- seulement si admin --}}
                              @if (Auth::user()->rang =='admin')
                                <form action="../../delete_pokemon/0/{{$pokemon->Id}}" method="POST">
                                  @csrf
                                  <td>
                                    <a class="btn btn-link" style="text-decoration: none" href="../../update/{{$pokemon->Id}}" >
                                    <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <button type="submit" class="btn btn-link" name="input" value="delete" onclick="return confirm('Are you sure you want to delete {{$pokemon->Nom}} ?');">
                                      <i class="fas fa-trash-alt fa-lg" style="text-decoration: none;color: red"></i>
                                    </button>
                                  </td>
                                </form>
                              @endif
                            @endauth
                        </tr>
                        @if ($pokemon->Form_Alola||$pokemon->Mega_Evolution)
                          @php 
                            if (isset($pokemon->Form_Alola))
                            {
                              $formPoke=Pokemon::where('Id',$pokemon->Form_Alola)->first();
                              $color='rgb(170, 79, 63)';
                              $mega=true;
                            }
                            else 
                            {
                              $formPoke=Pokemon::where('Id',$pokemon->Mega_Evolution)->first();
                              $color='rgb(63, 136, 170)';
                              $mega=false;
                            }
                          @endphp
                          <tr style="color:{{$color}}">
                            <td><a hidden>{{$pokemon->Id}}</a>
                              @if (!$mega)
                                <img src="../../../img/Sprite_Mega_Gemme/{{$pokemon->Nom."ite"}}.png">
                              @endif
                            </td>
                            <td>
                              <a style="text-decoration: none"  href="../pokedex/{{$formPoke->Nom}}">
                                <img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$formPoke->Generation}}G/{{$formPoke->Sprite_2D}}">
                              </a>
                            </td>
                            <td>
                              <a style="color: inherit;"  href="../pokedex/{{$formPoke->Nom}}">
                                {{$formPoke->Nom}}
                              </a>
                            </td>
                            <td> {{$formPoke->Nom_Anglais}} </td>
                            <td>
                              @foreach ($type_pokemon as $item) 
                                  @if ($formPoke->Type_1==$item->Id)
                                    <a hidden>{{$formPoke->Type_1.'.'.$formPoke->Type_2}}</a>
                                    <img src="../../../img/Sprite_Type/{{$item->Sprite}} ">
                                  @endif
                              @endforeach

                              @foreach ($type_pokemon as $item) 
                                @if ($formPoke->Type_2==$item->Id)
                                  - <img src="../../../img/Sprite_Type/{{$item->Sprite}}">
                                @endif
                              @endforeach
                            </td>
                            <td hidden>{{$pokemon->Generation}}</td>
                            {{-- seulement si admin --}}
                            @auth
                              <td hidden name="td{{$i}}">
                                <input type="checkbox" id="{{$formPoke->Id}}" name="{{$formPoke->Id}}" value="{{$formPoke->Id}}" style="width: 25px; height: 25px;">
                              </td>
                              @if (Auth::user()->rang =='admin')
                              
                                <form action="../../delete_pokemon/0/{{$pokemon->Id}}" method="POST">
                                  @csrf
                                  <td>
                                    <a class="btn btn-link" style="text-decoration: none" href="../../update/{{$formPoke->Id}}" >
                                    <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <button type="submit" class="btn btn-link" name="input" value="delete" onclick="return confirm('Are you sure you want to delete {{$formPoke->Nom}} ?');">
                                      <i class="fas fa-trash-alt fa-lg" style="text-decoration: none;color: red"></i>
                                    </button>
                                  </td>
                                </form>
                              @endif
                            @endauth            
                          </tr>
                          @if ($pokemon->Nom=='Dracaufeu'||$pokemon->Nom=='Mewtwo')
                            @php
                              $nom=$pokemon->Nom."-mega-x";
                              $formPokeX=Pokemon::where('Nom',$nom)->first();
                            @endphp
                            <tr style="color:{{$color}}">
                              <td>
                                <a hidden>{{$pokemon->Id}}</a>
                                <img src="../../../img/Sprite_Mega_Gemme/{{$pokemon->Nom."ite_X"}}.png">
                              </td>
                              <td>
                                <a style="text-decoration: none"  href="../pokedex/{{$formPokeX->Nom}}">
                                  <img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$formPokeX->Generation}}G/{{$formPokeX->Sprite_2D}}">
                                </a>
                              </td>
                              <td>
                                <a style="color: inherit;"  href="../pokedex/{{$formPokeX->Nom}}">
                                  {{$formPokeX->Nom}}
                                </a>
                              </td>
                              <td> {{$formPokeX->Nom_Anglais}} </td>
                              <td>
                                @foreach ($type_pokemon as $item) 
                                    @if ($formPokeX->Type_1==$item->Id)
                                    <a hidden>{{$formPokeX->Type_1.'.'.$formPokeX->Type_2}}</a>
                                      <img src="../../../img/Sprite_Type/{{$item->Sprite}} ">
                                    @endif
                                @endforeach

                                @foreach ($type_pokemon as $item) 
                                  @if ($formPokeX->Type_2==$item->Id)
                                    - <img src="../../../img/Sprite_Type/{{$item->Sprite}}">
                                  @endif
                                @endforeach
                              </td>
                              <td hidden>{{$pokemon->Generation}}</td>
                              {{-- seulement si admin --}}
                              @auth
                                <td hidden name="td{{$i}}">
                                  <input type="checkbox" id="{{$formPokeX->Id}}" name="{{$formPokeX->Id}}" value="{{$formPokeX->Id}}" style="width: 25px; height: 25px;">
                                </td>
                                @if (Auth::user()->rang =='admin')
                                  <form action="../../delete_pokemon/0/{{$pokemon->Id}}" method="POST">
                                    @csrf
                                      <td>
                                        <a class="btn btn-link" style="text-decoration: none" href="../../update/{{$formPokeX->Id}}" >
                                        <i class="fas fa-edit fa-lg"></i>
                                        </a>
                                        <button type="submit" class="btn btn-link" name="input" value="delete" onclick="return confirm('Are you sure you want to delete {{$formPokeX->Nom}} ?');">
                                          <i class="fas fa-trash-alt fa-lg" style="text-decoration: none;color: red"></i>
                                        </button>
                                      </td>
                                  </form>
                                @endif
                              @endauth            
                            </tr> 
                          @endif
                        @endif
                        @php
                            $i++;
                        @endphp
                      @endif
                  @endforeach  
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </form>
@endsection

<script>
  //Remove alert apres 5000=5s
  window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
      });}, 5000);

  function searchBar() 
  {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInp");
    filter = input.value.toUpperCase();
    table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[2]; //[2] parce que on tri par nom du coup index 2 du tab
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
  
  function hideChekBox(par) 
  {
    @php
        echo "var lenght =".$i.";";
    @endphp
    if (par==true) 
    { 
        for (i = 0; i < lenght; i++) 
        {
          doc=document.getElementsByName('td'+i)
          doc.forEach(element =>{element.hidden=false;});
        }
        document.getElementById('th').hidden=false;
        document.getElementById('create').hidden=false;
        document.getElementById('false').hidden=false;
        document.getElementById('true').hidden=true;
    }
    else
    {
        for (i = 0; i < lenght; i++) 
        {
          doc=document.getElementsByName('td'+i)
          doc.forEach(element =>{element.hidden=true;});
        }
        document.getElementById('th').hidden=true;
        document.getElementById('create').hidden=true;
        document.getElementById('false').hidden=true;
        document.getElementById('true').hidden=false;
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
      td = tr[i].getElementsByTagName("td")[5]; 
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

  function selectAll(params) 
  {
    @php
        echo "let arrayPoke =".$pokemons=Pokemon::orderBy('Id')->get().";";
    @endphp
    if (params==true) 
    {
      document.getElementById("select").hidden=true;
      document.getElementById("unselect").hidden=false;

      arrayPoke.forEach(element => 
      {
        document.getElementById(element.Id).checked=true;
      });
    }
    else
    {
      document.getElementById("unselect").hidden=true;
      document.getElementById("select").hidden=false;

      arrayPoke.forEach(element => 
      {
        document.getElementById(element.Id).checked=false;
      });

    }
  
  }
</script>

