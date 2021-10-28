@extends('layouts.header')

@section('content')
    <div class="container">
        <H1 style="text-align: center">Welcome To PokExpert</H1>
        <br>
        <h4 class="text-center">
            PokExpert is a list-making tool allowing you to more easily capture these little pocket monsters and finish your different capture objectives.
            <br>
            <br>
            PokExpert also provides other tools to learn more about these little monster.
        </h4>
        <h3 class="text-center"> <strong>So let's start the chase 
            <img src="../../../img/pokeball_menu/Poke_Ball.png"> !!!</strong>
        </h3><br>
        <div class="card" >
            <div class="card-header"><strong>Menu</strong></div>
            <div class="card-body px-3"> 
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <img src="../../../img/pokeball_menu/Poke_Ball.png" alt="pokeball">
                        <a href="./login">Login</a>
                    </li>
                    <li class="nav-item">
                        <img src="../../../img/pokeball_menu/Super_Ball.png" alt="pokeball">
                        <a href="./pokedex">Pokedex</a>
                    </li>
                    <li class="nav-item">
                        <img src="../../../img/pokeball_menu/Hyper_Ball.png" alt="pokeball">
                        <a href="./list">List</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <img src="../../../img/pokeball_menu/Honor_Ball.png" alt="pokeball">
                            <a href="./my_list">My List</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
        <br><br>
        <div class="alert alert-info text-center" role="alert">
            <h5>PokExpert is actually in open beta.
            <br>I you found a bug please contact the support at <strong>support.pokexpert@pokexpert.net</strong>
            </h5>
        </div>
    </div>
@endsection

