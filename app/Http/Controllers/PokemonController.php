<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Type_Pokemon;
use App\Models\Pokemon;
use App\Models\Calendrier;
use App\Models\Calendrier_Pokemon;
use App\Models\Ligne;
use App\Models\User;
use Auth;


class PokemonController extends Controller
{
/**********           FUNCTION           **********/

    /******* POKEMON *******/
        protected function create()
        {
            $Pokemon= new Pokemon;
            if (request()->index) 
            {
                $Pokemon->Id= request()->index;
            }
            $Pokemon->Nom= request()->name;
            $Pokemon->Nom_Anglais= request()->en_name;
            $Pokemon->Type_1= request()->Type_1ImgInput;
            $Pokemon->Type_2= request()->Type_2ImgInput;
            $Pokemon->Generation= request()->gen;
            $Pokemon->Poid= request()->weight;
            $Pokemon->Taille= request()->height;
            $Pokemon->Description= request()->desc;
            $Pokemon->Sprite_2D= request()->Sprite_2D;
            $Pokemon->Sprite_3D= request()->Sprite_3D;
            $Pokemon->Sprite_3D_Shiny= request()->Sprite_3D_Shiny;
            $Pokemon->Sprite_3D_Mega= request()->Sprite_3D_Mega;
            $Pokemon->Sprite_3D_Mega_Shiny= request()->Sprite_3D_Mega_Shiny;
            $Pokemon->Sprite_3D_Giga= request()->Sprite_3D_Giga;
            $Pokemon->Sprite_3D_Giga_Shiny= request()->Sprite_3D_Giga_Shiny;
            try 
            {
                $Pokemon->save();
                request()->session()->flash('alert-success', 'Pokemon was successful added!');  
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong...'); 
            }
            return redirect()->back();
        }
        public function update($id)
        {
            $Pokemon= Pokemon::find($id);
            $Pokemon->Id= request()->index;
            $Pokemon->Nom= request()->name;
            $Pokemon->Nom_Anglais= request()->name_en;
            $Pokemon->Type_1= request()->Type_1ImgInput;
            $Pokemon->Type_2= request()->Type_2ImgInput;
            $Pokemon->Generation= request()->gen;
            $Pokemon->Taille= request()->height;
            $Pokemon->Poid= request()->weight;
            $Pokemon->Description= request()->desc;
            $Pokemon->Form_Alola=request()->Form_Alola;
            $Pokemon->Sprite_2D= request()->Sprite_2D;
            $Pokemon->Sprite_3D= request()->Sprite_3D;
            $Pokemon->Sprite_3D_Shiny= request()->Sprite_3D_Shiny;
            $Pokemon->Sprite_3D_Mega= request()->Sprite_3D_Mega;
            $Pokemon->Sprite_3D_Mega_Shiny= request()->Sprite_3D_Mega_Shiny;
            $Pokemon->Sprite_3D_Giga= request()->Sprite_3D_Giga;
            $Pokemon->Sprite_3D_Giga_Shiny= request()->Sprite_3D_Giga_Shiny;

            try 
            {
                $Pokemon->save();
                request()->session()->flash('alert-success', 'Pokemon was successful updated!');  
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong...'); 
            }
            return redirect()->back();
            
        }
        //GET ALL POKEMON ORDER BY ID
        protected function loadAllOrderById()
        {
            try 
            {
                $pokemons=Pokemon::orderBy('Id')->get();
                // SI PAGINATION                   
                // $pokemons=Pokemon::orderBy('Id')->paginate(20); 
                $type_pokemon=Type_Pokemon::all();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }

            return view('pokedex',compact('pokemons','type_pokemon'));
        }

        //GET ALL POKEMON BY GEN
        protected function loadAllByGen($gen)
        {
            try 
            {
                $type_pokemon=Type_Pokemon::all();
                $pokemons=Pokemon::where('Generation',$gen)->get();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('pokedex',compact('pokemons','type_pokemon'));
        }
        
        //Load POKEMON BY ID
        public function loadById($id)
        {
            try 
            {
                $type_pokemon=Type_Pokemon::all();
                $pokemon=Pokemon::where('Id',$id)->first();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('admin/update_pokemon',compact('pokemon','type_pokemon'));
            
        }

    /******* LIST *******/
        public function create_list()
        { 
            try 
            {
                $success=0; // variable pour gerer si le pokemon ecrit existe

                $calendrier = new Calendrier;
                $calendrier->Id_User=request()->user;
                $calendrier->Statut=0; // 0-> pas commencer 1-> en cour 2-> FINI
                $calendrier->Libelle=request()->name;
                $calendrier->Public=request()->public;
                $calendrier->save(); 
                
                if (request()->pokemon_name!=null) 
                {
                    $pokemonSplit= explode("/",request()->pokemon_name);
                    foreach ($pokemonSplit as $value) 
                    {
                        list($name,$form,$shiny)=explode(",",$value);
                        try 
                        {
                            $calendrier_Pokemon= new Calendrier_Pokemon;
                            $calendrier_Pokemon->Id_Pokemon=Pokemon::where('Nom',$name)->first()->Id;
                            $calendrier_Pokemon->Shiny=$shiny;
                            $calendrier_Pokemon->Form=$form;
                            $calendrier_Pokemon->Statut=0; // 0-> pas capturer 1-> capturer 
                            $calendrier_Pokemon->save();
        
                            $ligne= new Ligne;
                            $ligne->Id_calendrier=$calendrier->Id;
                            $ligne->Id_calendrier_pokemon=$calendrier_Pokemon->Id;
                            $ligne->save();
                            
                            $success++;
                        } 
                        catch (\Throwable $th) 
                        { 
                            request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.');   
                        }
                    }
                    if ($success>0) 
                    {
                        request()->session()->flash('alert-success', 'Your List was successful created!'); 
                    }
                    else 
                    {
                        Calendrier::where("Id",$calendrier->Id)->delete();
                        request()->session()->flash('alert-warning', '
                        You have selected a Pokemon which does not exist, please try again.');
                    }
                }
                else 
                {
                    request()->session()->flash('alert-warning', 'You need to have a least one pokemon in your list.');
                }
                    
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return redirect()->back();
        }

        public function update_list($id)
        { 
            try 
            {
                $calendrier=Calendrier::where('Id',$id)->first();
                $calendrier->Libelle=request()->titleEdit;
                $lignes=Ligne::where('Id_calendrier',$id)->get();
                $nb=count($lignes);
                $i=0; //var temp
                foreach ($lignes as $ligne) 
                {
                    $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                    $satut='statut'.$calendrier_Pokemon->Id;
                    if (request()->$satut=="on") 
                    {
                        $calendrier_Pokemon->Statut=1;
                        $calendrier_Pokemon->save();
                        $i++;
                    }
                    else
                    {
                        $calendrier_Pokemon->Statut=0;
                        $calendrier_Pokemon->save();
                    }
                    $calendrier->Statut=1;
                    $calendrier->save();
                }
                request()->session()->flash('alert-success', 'Your List was successful update!');
                if ($nb==$i) 
                {
                    $calendrier->Statut=2;
                    $calendrier->save();
                    request()->session()->flash('alert-success', 'GG YOU JUST FINISH YOUR LIST !!!!');
                }
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            
            return redirect()->back();
        }

        public function delete_list($test,$id)
        { 
            try 
            {
                $calendrier=Calendrier::where('Id',$id)->first();
                $lignes=Ligne::where('Id_calendrier',$id)->get();

                foreach ($lignes as $ligne) 
                {
                    $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                    $ligne->delete();
                    $calendrier_Pokemon->delete();
                }
                $calendrier->delete();
                request()->session()->flash('alert-success', 'Your List was successful delete!');
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            if ($test==0) 
            {
                return redirect('/my_list');
            }
            else 
            {
                return redirect()->back();
            }
        }

        public function load()
        { 
            try 
            {
                $pokemons=Pokemon::all();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('list/create_list',compact('pokemons'));
        }

        public function loadPublicList()
        { 
            try 
            {
                $calendriers=Calendrier::where('Public',0)->get();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('/list/list',compact('calendriers'));
        }

        public function loadListById($id)
        {
            try 
            {
                $calendrier=Calendrier::where('Id',$id)->first();
                $lignes=Ligne::where('Id_calendrier',$calendrier->Id)->get();
                $nbPokemonCapturer=0;
                $nbPokemonRestant=0;
                foreach ($lignes as $ligne) 
                {
                    $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                    if ($calendrier_Pokemon->Statut==1) 
                    {
                        $nbPokemonCapturer++;
                    }
                    else
                    {
                        $nbPokemonRestant++;
                    }
                }
                
                $total=($nbPokemonCapturer+$nbPokemonRestant);
                $totalP=round(((100*$nbPokemonCapturer)/$total), 2);
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('/list/listById',compact('calendrier','lignes','totalP'));
        }

    /******* PROFILE *******/
        public function getProfile($name)
        { 
            try 
            {
                $user = User::where("name",$name)->first();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('profile',compact('user'));
        }

        public function update_profile($id)
        { 
            try 
            {
                $exist=0;
                $user = User::where("id",$id)->first();

                if ($user->name!=request()->name) 
                {
                    $users=User::all();
                    foreach ($users as $value) 
                    {
                        if ($value->name!=request()->name) 
                        {
                            $exist=1;
                        }    
                    }
                    if ($exist==0) 
                    {
                        $user->name=request()->name;
                    } 
                    else 
                    {
                        request()->session()->flash('alert-warning', '
                        Name already taken. Please try a different one.');
                    }
                }
                $user->email=request()->email;
                $user->description=request()->description;
                try 
                {
                    $user->rang=request()->rang;
                } catch (\Throwable $th) {} //pas de catch car on verifie juste si la request existe si elle xiste pas bah rien
                
                try 
                {
                    $user->Sprite=request()->SpriteImgInput;
                    $user->friend_Code=request()->friendCode;
                } catch (\Throwable $th) {}
                
                
                $user->save();

                request()->session()->flash('alert-success', 'The profile was successful update!');
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            
            return redirect()->back();
        }

        public function delete_profile($id)
        { try 
            {
                $user=User::where('id',$id)->first();
                $name=$user->name;
                $calendriers=Calendrier::where('Id_User',$id)->get();
                foreach ($calendriers as $calendrier) 
                {
                    $lignes=Ligne::where('Id_calendrier',$calendrier->Id)->get();
                    foreach ($lignes as $ligne) 
                    {
                        $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                        $ligne->delete();
                        $calendrier_Pokemon->delete();
                    }
                    $calendrier->delete();
                }

                $user->delete();
                request()->session()->flash('alert-success', 'The profile "'.$name.'" was successful delete!');
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            
            return redirect()->back();
        }
        
        public function getStats()
        {
            try 
            {
                $pageUser=Auth::user();
            
                $nbListFini=0;
                $nbListEnCour=0;
                $nbListCreer=0;
                
                $nbPokemonCapturerALL=0;
                $nbPokemonShinyCapturerALL=0;
                $nbPokemonRestantALL=0;
                $nbPokemonBylist=[];
                try 
                {
                    $calendriers=Calendrier::where('Id_User',$pageUser->id)->get();
                    foreach ($calendriers as $calendrier) 
                    {
                        /*****    Nb_List    *****/
                        $nbListCreer++;
                        switch ($calendrier->Statut) 
                        {
                            case 1:
                                $nbListEnCour++;
                                break;
                            case 2:
                                $nbListFini++;
                                break;
                        }
            
                        /*****    Nb_Pokemon    *****/
                        $nbPokemonCapturer=0;
                        $nbPokemonRestant=0;

                        $lignes=Ligne::where('Id_calendrier',$calendrier->Id)->get();
                        foreach ($lignes as $ligne) 
                        {
                            $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                            if ($calendrier_Pokemon->Statut==1) 
                            {
                                $nbPokemonCapturerALL++;
                                $nbPokemonCapturer++;
                                if ($calendrier_Pokemon->Shiny==0) 
                                {
                                    $nbPokemonShinyCapturerALL++;
                                }
                            }
                            else
                            {
                                $nbPokemonRestantALL++;
                                $nbPokemonRestant++;
                            }
                        }
                        $nbPokemonBylist[]=[$calendrier->Id=>[$nbPokemonCapturer,$nbPokemonRestant]];
                    }
                } 
                catch (\Throwable $th) 
                {
                    request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.');
                }
                $list=[$nbListCreer,$nbListEnCour,$nbListFini];
                $total=[$nbPokemonCapturerALL,$nbPokemonShinyCapturerALL,$nbPokemonRestantALL];
                
                $stats=[$total,$list,$nbPokemonBylist];
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            
            return view('/statistics',compact('stats'));
        }

    /******* TYPE *******/
        //GET ALL TYPE
        public function getType()
        { 
            try 
            {
                $type_pokemon=Type_Pokemon::all();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('admin/create_pokemon',compact('type_pokemon'));
        }



    /******* ADMIN *******/
        
        public function admin()
        {
            try 
            {
                $users = User::all();
                $calendriers=Calendrier::all();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('admin/admin',compact('users','calendriers'));
        }

        public function update_admin($id)
        { 
            try 
            {
                if (request()->input=='update') 
                {
                    self::update_profile($id);
                }
                else if (request()->input=='delete') 
                {
                    self::delete_profile($id);
                }
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            
            return redirect()->back();
        }
    
 

/**********           FUNCTION            **********/   

    public function autocompleteSearch(Request $request)
    {        
        return Pokemon::select('Nom','Sprite_2D')
        ->where('Nom', 'like', "%{$request->terms}%")
        ->pluck('Nom');
    } 
    
}
