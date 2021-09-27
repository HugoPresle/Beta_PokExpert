@php
  use \App\Models\Pokemon;
@endphp

@extends('layouts.header')
@section('content')
  <h1 style="text-align: center">POKEDEX</h1>
  <br>
  <div class="col-md-auto">
    <div class="card">
      <div class="card-header">Pokedex
        <div style="float: right;">
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex/gen/1">1G</a> |
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex/gen/2">2G</a> |
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex/gen/3">3G</a> |
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex/gen/4">4G</a> |
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex/gen/5">5G</a> |
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex/gen/6">6G</a> |
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex/gen/7">7G</a> |
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex/gen/8">8G</a> |
          <a style="text-decoration: none; color: rgb(65, 66, 68)" href="../../pokedex">
            <i class="fas fa-times" style="color: red"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
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
                  @auth
                    {{-- seulement si admin --}}
                    @if (Auth::user()->rang =='admin')
                      <th >Utils</th>
                    @endif
                  @endauth
                </tr>
              </thead>
              <tbody>
                @foreach ($pokemons as $pokemon)
                  <form action="../../delete_pokemon/{{$pokemon->Id}}" method="POST">
                    @csrf
                    @if ($pokemon->Id<10000) {{-- Pour cacher les formes alola qui on un id de plus de 10.000 --}}
                      <tr>
                          <td> {{$pokemon->Id}} </td>
                          <td><img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$pokemon->Generation}}G/{{$pokemon->Sprite_2D}}" alt=""></td>
                          <td> {{$pokemon->Nom}} </td>
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
                          {{-- seulement si admin --}}
                          @auth
                            @if (Auth::user()->rang =='admin')
                              <td>
                                <a class="btn btn-link" style="text-decoration: none" href="../../update/{{$pokemon->Id}}" >
                                 <i class="fas fa-edit fa-lg"></i>
                                </a>
                                <button type="submit" class="btn btn-link" name="input" value="delete" onclick="return confirm('Are you sure you want to delete {{$pokemon->Nom}} ?');">
                                  <i class="fas fa-trash-alt fa-lg" style="text-decoration: none;color: red"></i>
                                </button>
                              </td>
                            @endif
                          @endauth
                      </tr>
                      @if ($pokemon->Form_Alola||$pokemon->Mega_Evolution)
                        @php 
                          if ($pokemon->Form_Alola)
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
                          <td><img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$formPoke->Generation}}G/{{$formPoke->Sprite_2D}}" alt=""></td>
                          <td> {{$formPoke->Nom}} </td>
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
                          {{-- seulement si admin --}}
                          @auth
                            @if (Auth::user()->rang =='admin')
                              <td>
                                <a class="btn btn-link" style="text-decoration: none" href="../../update/{{$formPoke->Id}}" >
                                 <i class="fas fa-edit fa-lg"></i>
                                </a>
                                <button type="submit" class="btn btn-link" name="input" value="delete" onclick="return confirm('Are you sure you want to delete {{$formPoke->Nom}} ?');">
                                  <i class="fas fa-trash-alt fa-lg" style="text-decoration: none;color: red"></i>
                                </button>
                              </td>
                            @endif
                          @endauth            
                        </tr>
                        @if ($pokemon->Nom=='Dracaufeu'||$pokemon->Nom=='Mewtwo')
                          @php
                            $nom=$pokemon->Nom."-mega-x";
                            $formPokeX=Pokemon::where('Nom',$nom)->first();
                          @endphp
                          <tr style="color:{{$color}}">
                            <td><a hidden>{{$pokemon->Id}}</a><img src="../../../img/Sprite_Mega_Gemme/{{$pokemon->Nom."ite_X"}}.png"></td>
                            <td><img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$formPokeX->Generation}}G/{{$formPokeX->Sprite_2D}}" alt=""></td>
                            <td> {{$formPokeX->Nom}} </td>
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
                            {{-- seulement si admin --}}
                            @auth
                              @if (Auth::user()->rang =='admin')
                                <td>
                                  <a class="btn btn-link" style="text-decoration: none" href="../../update/{{$formPokeX->Id}}" >
                                   <i class="fas fa-edit fa-lg"></i>
                                  </a>
                                  <button type="submit" class="btn btn-link" name="input" value="delete" onclick="return confirm('Are you sure you want to delete {{$formPokeX->Nom}} ?');">
                                    <i class="fas fa-trash-alt fa-lg" style="text-decoration: none;color: red"></i>
                                  </button>
                                </td>
                              @endif
                            @endauth            
                          </tr> 
                        @endif
                      @endif
                    @endif
                  </form>
                @endforeach  
              </tbody>
            </table>
          </div>
        {{-- PAGINATION mais pas trop fan a voire --}}

        {{-- <div class="col-12 ">
          {{ $pokemons->links("pagination::bootstrap-4")}}
        </div> --}}
      </div>
    </div>
  </div>
@endsection

<script>
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
</script>

