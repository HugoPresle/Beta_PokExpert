@php
  use \App\Models\Pokemon;
  use \App\Models\Calendrier;
  use \App\Models\User;
@endphp

@extends('layouts.header')
@section('content')
    @auth
        <h1 class="text-center">STATISTICS</h1>
        <h4 class="text-center">All the stats a good hunter needs to be a Poker Expert are here</h4>
        <br>
        @php
            foreach ($stats as $key => $value) 
            {
                switch ($key) 
                {
                    case 0:
                        foreach ($value as $key => $variable) 
                        {
                            switch ($key) 
                            { 
                                case 0:
                                    $totalCaptured=$variable;
                                    break;

                                case 1:
                                    $totalShinyCaptured=$variable;
                                    break;
                                    
                                case 2:
                                    $totalToCaptured=$variable;
                                    break;
                            }
                        }
                        break;
                        
                    case 1:
                        foreach ($value as $key => $variable) 
                        {
                            switch ($key) 
                            { 
                                case 0:
                                    $createListe=$variable;
                                    break;
                                case 1:
                                    $startListe=$variable;
                                    break;
                                    
                                case 2:
                                    $completeListe=$variable;
                                    break;
                            } 
                        }
                        break;
                    
                    case 2:
                        $lists=$value;    
                }
            }
        @endphp

        <div class="col-md-12 mt-3 mb-1">
            <div class="col-md-12 mt-3 mb-1">
                <hr>
                <h4 style="color: rgb(81, 77, 82)"><strong>Pokemon Stats</strong></h4>
                <div class="row">
                    <div class="col-xl-6 col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="media align-items-stretch">
                                        <div class="align-self-center">
                                            <img src="../../../img/pokeball_menu/Filet_Ball.png" class="mr-3" width="50">
                                        </div>
                                        <div class="media-body">
                                            <h4>Total Pokemon Caught</h4>
                                            <span style="color: rgb(8, 155, 160)">Displays the number of captured Pokemon from all your lists</span>
                                        </div>
                                        <div class="align-self-center">
                                            <h1>{{$totalCaptured}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="media align-items-stretch">
                                        <div class="align-self-center">
                                            <img src="../../../img/pokeball_menu/Luxe_Ball.png" class="mr-3" width="50">
                                        </div>
                                        <div class="media-body">
                                            <h4>Total of Shiny Pokemon Caught</h4>
                                            <span style="color: darkred">Displays the number of captured shiny Pokémon from all your lists</span>
                                        </div>
                                        <div class="align-self-center"> 
                                            <h1>{{$totalShinyCaptured}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row d-flex justify-content-start">
                    <div class="col-xl-6 col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="media align-items-stretch">
                                        <div class="align-self-center">
                                            <img src="../../../img/pokeball_menu/Chrono_Ball.png" class="mr-3" width="50">
                                        </div>
                                        <div class="media-body">
                                            <h4>Total Pokemon to Catch</h4>
                                            <span style="color: rgb(255, 72, 0)">Shows how many Pokémon you still need to catch from all your lists</span>
                                        </div>
                                        <div class="align-self-center">
                                            <h1 class="mr-2">{{$totalToCaptured}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3 mb-1">
            <hr>
                <h4 style="color: rgb(81, 77, 82)" class="d-flex justify-content-end"><strong>List Stats</strong></h4>
                <div class="row d-flex justify-content-end">
                    <div class="col-xl-6 col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="media align-items-stretch">
                                        <div class="align-self-center">
                                            <img src="../../../img/pokeball_menu/Soin_Ball.png" class="mr-3" width="50">
                                        </div>
                                        <div class="media-body">
                                            <h4>Total List Create</h4>
                                            <span style="color: rgb(236, 11, 169)">Displays the number of list created</span>
                                        </div>
                                        <div class="align-self-center">
                                            <h1 class="mr-2">{{$createListe}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xl-6 col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="media align-items-stretch">
                                        <div class="align-self-center">
                                            <img src="../../../img/pokeball_menu/Scuba_Ball.png" class="mr-3" width="50">
                                        </div>
                                        <div class="media-body">
                                            <h4>Total List Started</h4>
                                            <span style="color: rgb(0, 110, 255)">Displays the number of list started</span>
                                        </div>
                                        <div class="align-self-center">
                                            <h1>{{$startListe}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="media align-items-stretch">
                                    <div class="align-self-center">
                                        <img src="../../../img/pokeball_menu/Faiblo_Ball.png" class="mr-4" width="50">
                                    </div>
                                    <div class="media-body">
                                        <h4>Total List Completed</h4>
                                        <span style="color: rgb(57, 219, 42)">Displays the number of list completed</span>
                                    </div>
                                    <div class="align-self-center"> 
                                        <h1>{{$completeListe}}</h1>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <h4 style="color: rgb(81, 77, 82)" class="text-center"><strong>Stats By List</strong></h4>
            <div class="col-md-12 mt-3 mb-1">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive-sm ">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Catch</th>
                                        <th scope="col">Missing</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Finish</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($lists as $variable) 
                                        {
                                            foreach ($variable as $key => $value) 
                                                {?>
                                                    <tr>
                                                        <th scope="row"><a href="../list/{{$key}}">{{Calendrier::where('Id',$key)->first()->Libelle}}</a></th>
                                                        <?php 
                                                        foreach ($value as $key=> $a) 
                                                        {
                                                            switch ($key) 
                                                            {
                                                                case 0:
                                                                    $nbPoke=$a;
                                                                    break;
                                                                    
                                                                case 1:
                                                                    $nbPokeR=$a;
                                                                    break;
                                                            }
                                                            
                                                        }
                                                        $total=($nbPoke+$nbPokeR);
                                                        $totalP=round(((100*$nbPoke)/$total), 2);
                                                    ?>
                                                        <td>{{$nbPoke}}</td>
                                                        <td>{{$nbPokeR}}</td>
                                                        <td>{{$total}}</td>
                                                        <?php 
                                                            switch (true) 
                                                            {
                                                                case $totalP==100:
                                                                    echo '<td style="color: rgb(4, 216, 4)">'.$totalP.'%</td>';
                                                                    break;
                                                                case $totalP>80:
                                                                    echo '<td style="color: rgb(157, 255, 0)">'.$totalP.'%</td>';
                                                                    break;
                                                                case $totalP>60:
                                                                    echo '<td style="color: rgb(255, 217, 0)">'.$totalP.'%</td>';
                                                                    break;
                                                                case $totalP>40:
                                                                    echo '<td style="color: orange">'.$totalP.'%</td>';
                                                                    break;
                                                                case $totalP>20:
                                                                    echo '<td style="color: rgb(255, 81, 0)">'.$totalP.'%</td>';
                                                                    break;
                                                                case $totalP<20:
                                                                    echo '<td style="color: red">'.$totalP.'%</td>';
                                                                    break;
                                                                    
                                                            }
                                                        ?>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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