<?php

namespace App\Allegro;


 Class AllegroInit{


    public static function getAccessToken(): String
    {
        $authUrl = "https://allegro.pl.allegrosandbox.pl/auth/oauth/token?grant_type=client_credentials";
        $clientId = "b72645917b28421390d22a8ecbfd4bd5";
        $clientSecret = "d9CIhugR0Jry2eH82fydflgpDOlwgasnq8uiiB4dh28K37s3IYq9YEP8aly6DvbX";

        $ch = curl_init($authUrl);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERNAME, $clientId);
        curl_setopt($ch, CURLOPT_PASSWORD, $clientSecret);
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


public static function getMainCategories(String $token)
{
    //$getCategoriesUrl = "https://api.allegro.pl.allegrosandbox.pl/sale/categories/";
    $getCategoriesUrl = "https://api.allegro.pl.allegrosandbox.pl/sale/categories/?parent.id=5"; //Przejście do pod kategorii

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

    public static function main()
    {
        $token = self::getAccessToken();
        dump(self::getMainCategories($token));
    }
 }


    
    
