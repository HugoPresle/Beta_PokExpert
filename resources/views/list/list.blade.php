@php
  use \App\Models\Pokemon;
  use \App\Models\Calendrier;
  use \App\Models\User;
@endphp

@extends('layouts.header')
@section('content')
    <h1 class="text-center">Public LIST</h1>
    <h5 class="text-center"> You want to create your own list? You need to <a href="./login">login first</a> and then go to the <a href="./create-list">Create a List </a>Section.</h5>
    <br>
    <h6 class="text-center">When you create a list you can choose if you want to make it public. 
        If you want to, your list goes here and people can watch them and see your progression.
        <br>
        ( of course they cannot modify them )
    </h6>
    <br>
    <div class="row col-md-12 mx-auto">
        @foreach ($calendriers as $calendrier)
            <div class="card col-md-2 col-sm-6">
                <div class="text-center">
                    <img class="card-img-top" src="../../../img/pokeball_menu/Hyper_Ball.png" style="width: 30%">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title" style="font-weight: bold">{{$calendrier->Libelle}}</h5>
                    <p class="card-text">By 
                        <a href="./profile/{{User::where('id',$calendrier->Id_User)->first()->name;}}" style="text-decoration: none; color: black">
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
                                    echo '<strong style="color: rgb(255, 255, 255)">[Hello ? wyd]</strong>';
                                }
                            ?>
                        </a>
                    </p>
                    <a href="../list/{{$calendrier->Id}}" class="btn btn-secondary">Let's GO</a>
                </div> 
            </div>
            <br>
        @endforeach
    </div>
@endsection