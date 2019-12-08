<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Integrations\Allegro\AllegroRestApi;

class AllegroStart extends Controller
{
    
    public function index()
    {


      //Symulowanie braku lub posiadanie tokenu ze względu że nie mogłem sobie poradzić z punktem nr. 1 Zadania a był potrzebny w wyświetlaniu kategorii :(
      $Tokenexist = 1; 
//===========================[Inicjalizacja Autoryzacyjna]========================

      $Allegro = new AllegroRestApi();

      $Allegro->SetToken(AllegroRestApi::getAccessToken());

//===============================================================================

//==========================[Query do pobierania Kategorii + Pamięć breadcrumbs]======================
    if($Tokenexist != 0){ 

      if(isset($_GET['query']) && $_GET['query'] != NULL){
        $Categories = AllegroRestApi::getCategories($Allegro->GetToken(),$_GET['query']);

        AllegroRestApi::RememberQuery($_GET['query'],$Allegro->GetToken());
      }else{
        $Categories = AllegroRestApi::getCategories($Allegro->GetToken(),NULL);

        AllegroRestApi::RememberQuery(NULL,$Allegro->GetToken());
      }

    }else{
      $Categories = [];
      $_SESSION['memory'] = [];
    }

      $memory = $_SESSION['memory'];

//===================================================================================================

      return view('welcome',compact('Categories','memory','Tokenexist'));
    }
}
