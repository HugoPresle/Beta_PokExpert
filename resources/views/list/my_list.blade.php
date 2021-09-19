@php
  use \App\Models\Pokemon;
  use \App\Models\Calendrier;
  use \App\Models\User;
@endphp
@extends('layouts.header')
@section('content') 
@auth
    @php
        $calendriers=Calendrier::where('Id_User',Auth::user()->id)->get();
    @endphp
    <h1 class="text-center">MY LIST</h1>
    <h5 class="text-center"> You want to create a list ? Go to the 
        <a href="./create-list">Create a List </a>section.
    </h5>
    <br>
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </p>
            @endif
        @endforeach
    </div>  
    <div class="row col-xl-12 mx-auto">
        @foreach ($calendriers as $calendrier)
            <div class="card col-xl-2 col-sm-3 mb-2">
                <div class="text-center">
                    <img class="card-img-top" src="../../../img/pokeball_menu/Honor_Ball.png" style="width: 30%">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title" style="font-weight: bold">{{$calendrier->Libelle}}</h5>
                    <p class="card-text">
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
                    <a href="../list/{{$calendrier->Id}}" class="btn btn-secondary">Let's GO</a>
                </div> 
            </div>
            <br>
        @endforeach
    </div>
@endauth

@guest
    <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
        <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
        <p>You must log in to access this page</p><a href="./login" class="alert-link">LOGIN ?</a>
    </div>
@endguest
@endsection