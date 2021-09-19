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
                  @if ($pokemon->Id<10000) {{-- Pour cacher les formes alola qui on un id de plus de 10.000 --}}
                    <tr>
                        <td> {{$pokemon->Id}} </td>
                        <td><img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$pokemon->Generation}}G/{{$pokemon->Sprite_2D}}" alt=""></td>
                        <td> {{$pokemon->Nom}} </td>
                        <td> {{$pokemon->Nom_Anglais}} </td>
                        <td>
                          @foreach ($type_pokemon as $item) 
                              @if ($pokemon->Type_1==$item->Id)
                                <a hidden>{{$pokemon->Type_1}}</a>
                                <img alt="{{$pokemon->Type_1}}" src="../../../img/Sprite_Type/{{$item->Sprite}}">
                              @endif
                          @endforeach
                          @foreach ($type_pokemon as $item) 
                            @if ($pokemon->Type_2==$item->Id)
                              <a hidden>{{$pokemon->Type_2}}</a>
                              - <img alt="{{$pokemon->Type_2}}" src="../../../img/Sprite_Type/{{$item->Sprite}}">
                            @endif
                          @endforeach
                      </td>
                        {{-- seulement si admin --}}
                        @auth
                          @if (Auth::user()->rang =='admin')
                            <td>
                              <a href="../../update/{{$pokemon->Id}}" >
                                <i class="fas fa-edit"></i>
                              </a>
                            </td>
                          @endif
                        @endauth
                    </tr>
                    @if ($pokemon->Form_Alola!= null)
                      @php
                        $pokeAlola=Pokemon::where('Id',$pokemon->Form_Alola)->first();
                      @endphp
                      <tr>
                        <td>{{$pokemon->Id}}</td>
                        <td><img src="../../../img/Sprite_Pokemon/Sprite_2D/{{$pokeAlola->Generation}}G/{{$pokeAlola->Sprite_2D}}" alt=""></td>
                        <td> {{$pokeAlola->Nom}} </td>
                        <td> {{$pokeAlola->Nom_Anglais}} </td>
                        <td>
                          @foreach ($type_pokemon as $item) 
                              @if ($pokeAlola->Type_1==$item->Id)
                                <a hidden>{{$pokeAlola->Type_1}}</a>
                                <img src="../../../img/Sprite_Type/{{$item->Sprite}} ">
                              @endif
                          @endforeach

                          @foreach ($type_pokemon as $item) 
                            @if ($pokeAlola->Type_2==$item->Id)
                              <a hidden>{{$pokeAlola->Type_2}}</a>
                              - <img src="../../../img/Sprite_Type/{{$item->Sprite}}">
                            @endif
                          @endforeach
                        </td>
                        {{-- seulement si admin --}}
                        @auth
                          @if (Auth::user()->rang =='admin')
                            <td>
                              <a href="../../update/{{$pokemon->Id +10000}}" >
                                <i class="fas fa-edit"></i>
                              </a>
                            </td>
                          @endif
                        @endauth            
                      </tr>
                    @endif
                  @endif
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

