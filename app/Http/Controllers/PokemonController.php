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
    
        //GETTER
        public function loadAllOrderById()
        {
            try 
            {
                $pokemons=Pokemon::orderBy('Id')->get();
                $type_pokemon=Type_Pokemon::all();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }

            return view('pokedex',compact('pokemons','type_pokemon'));
        }
        public function loadAllByGen($gen)
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
        public function loadAllByName($name)
        {
            try 
            {
                $type_pokemon=Type_Pokemon::all();
                $pokemon=Pokemon::where('Nom',$name)->first();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('pokemon',compact('pokemon','type_pokemon'));
        }
        //SETTER
        public function create()
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
            $Pokemon->Sprite_3D_Giga= request()->Sprite_3D_Giga;
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
            $Pokemon->Mega_Evolution=request()->Mega_Evolution;
            $Pokemon->Sprite_2D= request()->Sprite_2D;
            $Pokemon->Sprite_3D= request()->Sprite_3D;
            $Pokemon->Sprite_3D_Giga= request()->Sprite_3D_Giga;
            try 
            {
                $Pokemon->save();
                request()->session()->flash('alert-success', 'Pokemon was successful updated!');  
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong...'); 
            }
            return redirect('/pokedex');
            
        }
        public function delete($page,$id)
        {
            try 
            {
                $pokemon=Pokemon::where('id',$id)->first();
                $name=$pokemon->Nom;
                $pokemon->delete();
                request()->session()->flash('alert-success', 'The Pokemon "'.$name.'" was successful delete!');
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            if ($page==0) 
            {
                return redirect('/pokedex');
            }
            else 
            {
                return redirect()->back();
            }
        }
     
    /******* LIST *******/   
        //GETTER
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
                $public=true;
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('/list/list',compact('calendriers','public'));
        }
        public function loadUserList()
        { 
            try 
            {
                
                $calendriers=Calendrier::where('Id_User',Auth::user()->id)->get();
                $public=false;
                return view('/list/list',compact('calendriers','public'));
            } 
            catch (\Throwable $th) 
            {
                return redirect()->back();
            }
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
                
                return view('/list/listById',compact('calendrier','lignes','totalP'));
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'You don\'t have access to this list.');
                return redirect()->back(); 
            }
        }
        public function modifyListById($id)
        {
            try 
            {
                $calendrier=Calendrier::where('Id',$id)->first();
                $lignes=Ligne::where('Id_calendrier',$calendrier->Id)->get();
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return view('/list/modify_list',compact('calendrier','lignes'));
        }
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

        //SETTER
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
                    $pokemonSplit= explode(",",request()->pokemon_name);
                    foreach ($pokemonSplit as $value) 
                    {
                        list($name,$form,$shiny)=explode("/",$value);
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
                        }catch (\Throwable $th){}
                    }
                    if ($success>0) 
                    {
                        request()->session()->flash('alert-success', 'Your List was successfully created !'); 
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
                    Calendrier::where("Id",$calendrier->Id)->delete();
                    request()->session()->flash('alert-warning', 'You need to have a least one pokemon in your list.');
                }
                    
            } 
            catch (\Throwable $th) 
            {
                Calendrier::where("Id",$calendrier->Id)->delete();
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            return redirect()->back();
        }
        public function modify_list($id)
        { 
                $calendrier=Calendrier::where('Id',$id)->first();
                $calendrier->Libelle=request()->name;
                $calendrier->Public=request()->public;
                $calendrier->save(); 


                if (request()->pokemon_name!=null) 
                {
                    $lignes=Ligne::where('Id_calendrier',$id)->get();
                    foreach ($lignes as $ligne) 
                    {
                        $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                        $ligne->delete();
                        $calendrier_Pokemon->delete();
                    }
                    $pokemonSplit= explode(",",request()->pokemon_name);
                    foreach ($pokemonSplit as $value) 
                    {
                        try 
                        {
                            list($name,$form,$shiny,$statut)=explode("/",$value);
                            $calendrier_Pokemon= new Calendrier_Pokemon;
                            $calendrier_Pokemon->Id_Pokemon=Pokemon::where('Nom',$name)->first()->Id;
                            $calendrier_Pokemon->Shiny=$shiny;
                            $calendrier_Pokemon->Form=$form;
                            $calendrier_Pokemon->Statut=$statut;
                            $calendrier_Pokemon->save();
        
                            $ligne= new Ligne;
                            $ligne->Id_calendrier=$id;
                            $ligne->Id_calendrier_pokemon=$calendrier_Pokemon->Id;
                            $ligne->save();
                        }
                        catch (\Throwable $th){}
                        request()->session()->flash('alert-success', 'Your list was successfully saved !'); 
                    }
                }
                else
                {
                    request()->session()->flash('alert-warning', 'You have selected no Pokemon, please select at least one.');
                    return redirect()->back();
                }
            return redirect('/my_list');
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
                request()->session()->flash('alert-success', 'Your list '.$calendrier->Libelle.'  was successfully saved !');
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
        public function delete_list($page,$id)
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
                request()->session()->flash('alert-success', 'Your list was successfully deleted !');
            } 
            catch (\Throwable $th) 
            {
                request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
            }
            if ($page==0) 
            {
                return redirect('/my_list');
            }
            else 
            {
                return redirect()->back();
            }
        }
        public function delete_selected()
        {
            $tab=[];
            $calendriers=Calendrier::where('Id_User',Auth::user()->id)->get();
            for ($i=0; $i <count($calendriers) ; $i++) 
            { 
                $request="check".$i;
                if (isset(request()->$request)) 
                {
                    $tab[]=request()->$request;
                }
            } 
            if (count($tab)>0) 
            { 
                try 
                {
                    foreach ($tab as $value) 
                    {
                        $calendrier=Calendrier::where('Id',$value)->first();
                        $lignes=Ligne::where('Id_calendrier',$value)->get();
        
                        foreach ($lignes as $ligne) 
                        {
                            $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();
                            $ligne->delete();
                            $calendrier_Pokemon->delete();
                        }
                        $calendrier->delete();
                        request()->session()->flash('alert-success', 'Your list was successfully deleted !');
                    }
                    
                } 
                catch (\Throwable $th) 
                {
                    request()->session()->flash('alert-danger', 'Oops something went wrong... Please reload the page.'); 
                }
            }
            else
            {
                request()->session()->flash('alert-danger', 'There is no list selected...');  
            }
           

            return redirect()->back();
        }
        public function copyById($id)
        { 
            $calendrier=Calendrier::where("Id",$id)->first();

            $copy_calendrier=new Calendrier();
            $copy_calendrier->Id_User=Auth::user()->id;
            $copy_calendrier->Statut=$calendrier->Statut;
            $copy_calendrier->Libelle=$calendrier->Libelle.'_Copy';
            $copy_calendrier->Public=1;
            $copy_calendrier->save();

            $lignes=Ligne::where('Id_calendrier',$id)->get();
            foreach ($lignes as $ligne) 
            {
                try 
                {
                    $calendrier_Pokemon= Calendrier_Pokemon::where('Id',$ligne->Id_calendrier_pokemon)->first();

                    $copy_calendrier_Pokemon = new Calendrier_Pokemon;
                    $copy_calendrier_Pokemon->Id_Pokemon = $calendrier_Pokemon->Id_Pokemon;
                    $copy_calendrier_Pokemon->Shiny = $calendrier_Pokemon->Shiny;
                    $copy_calendrier_Pokemon->Form = $calendrier_Pokemon->Form;
                    $copy_calendrier_Pokemon->Statut = $calendrier_Pokemon->Statut;
                    $copy_calendrier_Pokemon->save();

                    $copy_ligne= new Ligne;
                    $copy_ligne->Id_calendrier=$copy_calendrier->Id;
                    $copy_ligne->Id_calendrier_pokemon=$copy_calendrier_Pokemon->Id;
                    $copy_ligne->save();
                }
                catch(\Throwable $th){}
            }
            request()->session()->flash('alert-success','Your list '.$calendrier->Libelle.' have been successfully copied to '.$copy_calendrier->Libelle.' !'); 
            return redirect()->back();

        }

    /******* PROFILE *******/
        //GETTER
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

        //SETTER
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
                if (request()->rang) 
                {
                    $user->rang=request()->rang;
                }
                if (request()->SpriteImgInput) 
                {
                    $user->Sprite=request()->SpriteImgInput;
                    $user->friend_Code=request()->friendCode;
                }
               
                
                
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
        { 
            try 
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
        
        

    /******* TYPE *******/
        //GETTER
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
        //GETTER
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

        //SETTER
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
