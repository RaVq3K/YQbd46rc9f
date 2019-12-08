<?php

namespace App\Integrations\Allegro;

Class AllegroRestApi{

    const authUrl = 'https://allegro.pl.allegrosandbox.pl/auth/oauth/token?grant_type=client_credentials';
    const redirectUri = 'http://127.0.0.1:8000/';

    const ClientId = 'b72645917b28421390d22a8ecbfd4bd5';
    const ClientSecret = 'd9CIhugR0Jry2eH82fydflgpDOlwgasnq8uiiB4dh28K37s3IYq9YEP8aly6DvbX';

    private $token = NULL;

//=====================[Pobieranie Klucza dostępowego]========================

    public static function GetAccessToken(){

        $ch = curl_init(self::authUrl);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERNAME, self::ClientId);
        curl_setopt($ch, CURLOPT_PASSWORD, self::ClientSecret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $tokenResult = curl_exec($ch);
        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($tokenResult === false || $resultCode !== 200) {
            exit ("Something went wrong");
    }

        $tokenObject = json_decode($tokenResult);

        return $tokenObject->access_token;
    }

//==========================================================================
    
//==========================[Pobieranie Kategorii===========================


    public static function getCategories($token, $url){

        if(isset($url) && $url == NULL){
            $getCategoriesUrl = 'https://api.allegro.pl.allegrosandbox.pl/sale/categories';
        }else{
            $getCategoriesUrl = 'https://api.allegro.pl.allegrosandbox.pl/sale/categories?parent.id='.$url.'';
        }

    $ch = curl_init($getCategoriesUrl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                 "Authorization: Bearer $token",
                 "Accept: application/vnd.allegro.public.v1+json"
    ]);

    $mainCategoriesResult = curl_exec($ch);
    $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($mainCategoriesResult === false || $resultCode !== 200) {
        exit ("Something went wrong");
    }

    $categoriesList = json_decode($mainCategoriesResult);

    return $categoriesList;
}

//===============================================================================

//==========================[Pobieranie nazwy Kategorii===========================


    public static function getCategoriesNames($token, $url){

        if(isset($url) && $url == NULL){
            $getCategoriesUrl = 'https://api.allegro.pl.allegrosandbox.pl/sale/categories';
        }else{
            $getCategoriesUrl = 'https://api.allegro.pl.allegrosandbox.pl/sale/categories/'.$url.'';
        }

    $ch = curl_init($getCategoriesUrl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                 "Authorization: Bearer $token",
                 "Accept: application/vnd.allegro.public.v1+json"
    ]);

    $mainCategoriesResult = curl_exec($ch);
    $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($mainCategoriesResult === false || $resultCode !== 200) {
        exit ("Something went wrong");
    }

    $categoriesList = json_decode($mainCategoriesResult);

    if(isset($categoriesList->name)){
        return $categoriesList->name;
    }else{
       return NULL;
    }
}

//===============================================================================


//=======================[Zapamiętywanie URL do breadcrumbs]=====================

    public static function RememberQuery($query,$token)
    {
        session_start();

        if(isset($query) && $query != NULL)
        {   
            //Zapamiętywanie kroków w breadcrumbs oraz array_unique aby uniknąć dubli.
            array_push($_SESSION['memory'], ['id' => $query, 'name' => ''.self::getCategoriesNames($token,$query).'']);
            $_SESSION['memory'] = array_unique($_SESSION['memory'],SORT_REGULAR);


            //Cofanie w Breadcrumbs
            if(isset($_GET['reverse']) && $_GET['reverse'] != NULL){
                $elementsinMemory = sizeof($_SESSION['memory']);

                for ($i=$_GET['reverse']+1; $i <= $elementsinMemory; $i++) { 
                    unset($_SESSION['memory'][$i]);
                }   
            }

        }   
        else
        {
            $_SESSION['memory'] = [];
        }           

    }

//===============================================================================


//=============================[Setery i Getery]=================================

    public function SetToken($token){
        $this->token = $token;
    }

    public function GetToken(){
        return $this->token;
    }
 //===============================================================================   

}