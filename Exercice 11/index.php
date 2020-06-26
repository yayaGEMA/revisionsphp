<?php

// Inclusion des dépendances ( pour avoir accès à la fonction dump() )
require '../vendor/autoload.php';

/*
Exercice : Créer une fonction getGoogleLogo() qui téléchargera le logo à l'adresse suivante : " https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png " et le rangera dans un sous dossier "logos/" sous le nom "logo_google.png" (dossier qui devra être créé par la fonction si ce dernier n'existe pas).
*/

// Fonction à créer ici
//-------------------------------------------------------------------------

function getGoogleLogo(){
    // Initialize a file URL to the variable
    $url = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png';

    // Use basename() function to return the base name of file
    $filename = basename($url);

    if(!file_exists('logos')) {
        mkdir('logos', 0777, true);
    }

    // Use file_get_contents() function to get the file
    // from url and use file_put_contents() function to
    // save the file by using base name
    file_put_contents( 'logos/'.$filename,file_get_contents($url));
}

//-------------------------------------------------------------------------


// Ne doit rien afficher à l'écran, par contre doit avoir créé le sous dossier "logos" s'il n'existe pas déjà, avec un fichier "logo_google.png" à l'intérieure
getGoogleLogo();