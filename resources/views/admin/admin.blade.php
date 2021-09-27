@extends('layouts.header')
@section('content')
    @auth
        @if (Auth::user()->rang =='admin')
            <h1 style="text-align: center">ADMIN PANEL</h1>
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </p>
                    @endif
                @endforeach
            </div> 
            <div class="col-md-12 mt-3 mb-1">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive-sm ">
                            <table class="table table-hover" id="user">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Rank</th>
                                        <th scope="col">Description</th>
                                        <th>Utils</th>
                                        <th>Save</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <form method="POST" action="../update_admin/{{$user->id}}">
                                            @csrf
                                            <tr onclick="clique('{{$user->name}}');">
                                                <td>{{$user->id}}</td>
                                                <td><input autocomplete="off" name="name" class="form-control" type="text" value="{{$user->name}}"></td>
                                                <td><input autocomplete="off" name="email" class="form-control" type="email" value="{{$user->email}}"></td>
                                                <td><input autocomplete="off" name="rang" class="form-control" type="text" value="{{$user->rang}}"></td>
                                                <td><input autocomplete="off" name="description" class="form-control" type="text" value="{{$user->description}}"></td>
                                                <td>
                                                    <a class="btn btn-link" style="text-decoration: none" href="../profile/{{$user->name}}">
                                                        <i class="fas fa-id-card fa-lg"></i>
                                                    </a>
                                                    | 
                                                    <button type="submit" class="btn btn-link" name="input" value="delete" onclick="return confirm('Are you sure you want to delete {{$user->name}} ?');">
                                                        <i class="fas fa-trash-alt fa-lg" style="text-decoration: none;color: red"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-link" name="input" value="update">
                                                        <i class="fas fa-check fa-lg" style="text-decoration: none;color: green"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <div class="card col-md-10 mt-3 mb-1">
                        <div class="card-body">
                            <div class="table-responsive-sm ">
                                <table class="table table-hover" id="table">
                                    <input autocomplete="off" type="text" class="form-control col-md-2" id="searchInp" onkeyup="searchBar()" placeholder="Search..">
                                    <br>
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Name</th>
                                            <th>Utils</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($calendriers as $calendrier)
                                            <tr>
                                                <td>{{$calendrier->Id}}</td>
                                                
                                                @foreach ($users as $user)
                                                    @if ($user->id==$calendrier->Id_User)
                                                        <td>{{$user->name}}</td>
                                                    @endif
                                                @endforeach
                                                <td>{{$calendrier->Libelle}}</td>
                                                <td>
                                                    <form method="POST" action="/delete_list/1/{{$calendrier->Id}}" id="deleteform" onsubmit="return confirm('Are you sure you want to delete {{$calendrier->Libelle}} ?');">
                                                        @csrf
                                                        <a class="btn btn-link" href="../list/{{$calendrier->Id}}" style="text-decoration: none">
                                                            <i class="fas fa-list fa-lg"></i>
                                                        </a>
                                                        | 
                                                        <button type="submit" class="btn btn-link" name="delete" id="delete" >
                                                            <i class="fas fa-trash-alt fa-lg" style="text-decoration: none;color: red"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="alert alert-danger text-center col-md-6 mx-auto" role="alert">
                <h4><i class="fas fa-exclamation-triangle"></i> Arrhh</h4>
                <p>You don't have access to this page !<br> You are not a Pokemaster ...</p>
            </div>
        @endif
    @endauth 
    @guest
        <script>window.location = "/NoPageFound_ERROR";</script>')
    @endguest
@endsection


<script>

    function clique(input) 
    {
        var filter, table, tr, td, i, txtValue;
        filter = input.toUpperCase();
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
    function searchBar() 
    {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInp");
        filter = input.value.toUpperCase();
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[2]; 
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