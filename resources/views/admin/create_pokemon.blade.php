@extends('layouts.header')
@section('content')
    @auth
        @if (Auth::user()->rang =='admin')
            <h1 style="text-align: center">CREATE POKEMON</h1>
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </p>
                    @endif
                @endforeach
            </div>
            
            <form method="POST" action="/create_pokemon">
                @csrf
                <div class="col-md-12">
                    <div class="col-md-8 mb-3" style="float: left">
                        <div class="card">
                            <div class="card-header">Create Pokemon</div>
                                <div class="card-body">
                                    <!-- INDEX &NAME -->
                                    <div class="form-group">
                                        <div class="form-row align-items-center">
                                            <div class="col-md-4 mb-3">
                                                <label for="name">Index</label>
                                                <?php
                                                    try 
                                                    {
                                                        $index=htmlspecialchars($_COOKIE["index"]);?>
                                                        <input autocomplete="off" type="text" class="form-control" name="index" id="index" value="{{$index}}"><?php
                                                    } 
                                                    catch (\Throwable $th) 
                                                    {?>
                                                        <input autocomplete="off" type="text" class="form-control" name="index" id="index" placeholder="001"><?php 
                                                    }
                                                ?>
                                                </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="Sprite_2D">Sprite 2D</label>
                                                <div class="custom-file">
                                                    <input required type="file" class="custom-file-input"  name="Sprite_2D" id="Sprite_2D" onchange="imgChange('Sprite_2D');">
                                                    <label class="custom-file-label" for="Sprite_2D">Choose file</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="sprite_3D">Sprite 3D</label>
                                                <div class="custom-file">
                                                    <input required type="file" class="custom-file-input"  name="Sprite_3D" id="Sprite_3D" onchange="imgChange('Sprite_3D');">
                                                    <label class="custom-file-label" for="sprite_3D">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- GEN & HEIGHT & WEIGHT -->
                                    <div class="form-group">
                                        <div class="form-row align-items-center">
                                            <div class="col-md-4 mb-3">
                                                <label for="gen">Generation</label>
                                                <select required class="custom-select" name="gen" id="gen">
                                                    <option value="1">GENERATION 1</option>
                                                    <option value="2">GENERATION 2</option>
                                                    <option value="3">GENERATION 3</option>
                                                    <option value="4">GENERATION 4</option>
                                                    <option value="5">GENERATION 5</option>
                                                    <option value="6">GENERATION 6</option>
                                                    <option value="7">GENERATION 7</option>
                                                    <option value="8">GENERATION 8</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="height">Height</label>
                                                <input required type="number" step="0.1" min="0" class="form-control" name="height" id="height" placeholder="0,7">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="weight">Weight</label>
                                                <input required type="number" step="0.1" min="0" class="form-control" name="weight" id="weight" placeholder="6,9">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- DESC -->
                                    <div class="form-group">
                                        <div class="form-row align-items-center">
                                            <div class="col-md-8 mb-3">
                                                <label for="desc">Description</label>
                                                <textarea required class="form-control" rows="2" name="desc" id="desc"></textarea>
                                            </div><div class="col-md-4 mb-3">
                                                <label for="sprite_3D">Sprite Form Gigamax</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"  name="Sprite_3D_Giga" id="Sprite_3D_Giga" onchange="imgChange('Sprite_3D_Giga');">
                                                    <label class="custom-file-label" for="sprite_3D">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TYPE -->
                                    <div class="form-group">
                                        <div class="form-row align-items-center">
                                            <div class="col-md-6 mb-3" style="float: left">
                                                <div class="card">
                                                    <div class="card-header">First Type<input type="text" id="Type_1ImgInput" name="Type_1ImgInput" style="visibility: hidden" value="10"></div>
                                                    <div class="card-body">
                                                        @foreach ($type_pokemon as $item)
                                                            <img id="{{$item->Id}}" src="../../../img/Sprite_Type/{{$item->Sprite}}" onclick="change('{{$item->Sprite}}','Type_1Img',{{$item->Id}});"/>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3" style="float: right" >
                                                <div class="card">
                                                    <div class="card-header">Second Type<input type="text" id="Type_2ImgInput" name="Type_2ImgInput" style="visibility: hidden"></div>
                                                    <div class="card-body">
                                                        @foreach ($type_pokemon as $item)
                                                            <img src="../../../img/Sprite_Type/{{$item->Sprite}}" onclick="change('{{$item->Sprite}}','Type_2Img',{{$item->Id}});"/>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Submit -->
                                    <br>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-secondary" name="submit" id="submit" onclick="addIndex()">
                                            <img src="../../../img/pokeball_menu/Poke_Ball.png" alt="pokeball">
                                            CREATE !
                                            <img src="../../../img/pokeball_menu/Poke_Ball.png" alt="pokeball">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- REVIEW --}}
                    <div class="col-md-4 mb-3" style="float: right">
                        <div class="card">
                            <div class="card-header">Preview</div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">Name</div>
                                    <div class="card-body">
                                        <div class="form-row align-items-center">
                                            <div class="col-md-6 mb-3">
                                                <label for="name">Name</label>
                                                <input autocomplete="off" required type="text" class="form-control" name="name" id="name" placeholder="Bulbizarre">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="en_name">English Name</label>
                                                <input autocomplete="off" type="text" class="form-control" name="en_name" id="en_name" placeholder="Bulbasaur">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                {{-- TYPE Review --}}
                                <div class="card">
                                    <div class="card-header">Type</div>
                                    <div class="card-body">
                                        <img id="Type_1Img">
                                        <i class="fas fa-times" onclick="cancel('Type_1Img');" id="Type_1Img_cancel" style="color: red;cursor: pointer;" hidden></i>
                                        <br>
                                        <img id="Type_2Img">
                                        <i class="fas fa-times" onclick="cancel('Type_2Img');" id="Type_2Img_cancel" style="color: red;cursor: pointer;" hidden></i>
                                    </div>
                                </div>

                                <br>
                                {{-- Sprite Review --}}
                                <div class="card">
                                    <div class="card-header">Sprite</div>
                                    <div class="card-body">
                                        <label style="font-weight: bold" for="Sprite_2D">Sprite 2D :</label>
                                        <img id="Sprite_2DImg"/>
                                        <i class="fas fa-times" onclick="cancel('Sprite_2DImg');" id="Sprite_2DImg_cancel" style="color: red;cursor: pointer;" hidden></i>
                                        <br>
                                        
                                        <label style="font-weight: bold" for="Sprite_3D">Sprite 3D :</label>
                                        <img id="Sprite_3DImg"/>
                                        <i class="fas fa-times" onclick="cancel('Sprite_3DImg');" id="Sprite_3DImg_cancel" style="color: red;cursor: pointer;" hidden></i>
                                        <br>

                                        <label style="font-weight: bold" for="Sprite_3D_Shiny">Sprite 3D Shiny :</label>
                                        <img id="Sprite_3D_ShinyImg"/>
                                        <i class="fas fa-times" onclick="cancel('Sprite_3D_ShinyImg');" id="Sprite_3D_ShinyImg_cancel" style="color: red;cursor: pointer;" hidden></i>
                                        <br>

                                        <label style="font-weight: bold" for="Sprite_3D_Giga">Sprite 3D Giga :</label>
                                        <img id="Sprite_3D_GigaImg"/>
                                        <i class="fas fa-times" onclick="cancel('Sprite_3D_GigaImg');" id="Sprite_3D_GigaImg_cancel" style="color: red;cursor: pointer;" hidden></i>
                                        <br>

                                        <label style="font-weight: bold" for="Sprite_3D_Giga_Shiny">Sprite 3D Giga Shiny :</label>
                                        <img id="Sprite_3D_Giga_ShinyImg"/>
                                        <i class="fas fa-times" onclick="cancel('Sprite_3D_Giga_ShinyImg');" id="Sprite_3D_Giga_ShinyImg_cancel" style="color: red;cursor: pointer;" hidden></i>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
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
    
    //Remove alert apres 5000=5s
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });}, 5000);
    function change(spriteUrl,imgID,spriteId) 
    {
        //on recupere l'url du sprite de la bdd et l'id de la <img> 
        //Puis on prend la div corespondante pour changer la src et on affche la croix pour cancel
        document.getElementById(imgID).src='../../../img/Sprite_Type/'+spriteUrl;
        document.getElementById(imgID+'_cancel').hidden=false;

        //permet de contrer le manque d'input pour les type vu que ce'st de IMG du coup on en creer un invisble avec les atribues
        if (imgID=="Type_1Img") 
        {
            document.getElementById('Type_1ImgInput').value=spriteId; 
        } 
        else 
        {
            document.getElementById('Type_2ImgInput').value=spriteId;
        }
    }
    
    function imgChange(sprite) 
    {
        console.log(sprite);
        var gen=document.getElementById('gen').value;
        var path= document.getElementById(sprite).files[0].name; 

        //on recupere l'url du sprite de la bdd et l'id de la <img> 
        //Puis on prend la div corespondante pour changer la src et on affche la croix pour cancel
        document.getElementById(sprite+'Img').src='../../../img/Sprite_Pokemon/'+sprite+'/'+gen+'G/'+path; 
        document.getElementById(sprite+'Img_cancel').hidden=false; 

        if (sprite=="Sprite_2D") 
        {
            var pokeName =(path.charAt(0).toUpperCase() + path.substring(1).toLowerCase()).replace(".png","");
            document.getElementById("name").value=pokeName;
        } 
        else 
        {
            var pokeName =(path.charAt(0).toUpperCase() + path.substring(1).toLowerCase()).replace(".gif","");
            document.getElementById("en_name").value=pokeName;   
            document.getElementById(sprite+'_ShinyImg').src='../../../img/Sprite_Pokemon/'+sprite+'_Shiny/'+gen+'G/'+path; 
            document.getElementById(sprite+'_ShinyImg_cancel').hidden=false;     
        }
    }

    function cancel(imgID) 
    {
        //Cancel the Type selected
        document.getElementById(imgID).src="";
        document.getElementById(imgID+'_cancel').hidden=true;


        // ON suprr les value des inputs invisible
        if (imgID=="Type_1Img") 
        {
            document.getElementById('Type_1ImgInput').value=null; 
        } 
        else 
        {
            document.getElementById('Type_2ImgInput').value=null;
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

    function addIndex() 
    {       
        index=+document.getElementById("index").value+1;
        document.cookie='index='+index;
    }
</script>