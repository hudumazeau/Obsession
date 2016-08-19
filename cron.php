#!/usr/local/bin/php

<?php
/**
 * Created by PhpStorm.
 * User: hudumazeau
 * Date: 18/08/16
 * Time: 22:14
 */
$urlMiniature='img/affiches/miniature/';
$urlHD='img/affiches/HD/';
$urlWeb='web/bundles/obsessionmain/';
$urlSrc='src/ObsessionMainBundle/Ressources/public/';
$affichesWeb=scandir($urlWeb.$urlHD);
$affichesSrc=scandir($urlSrc.$urlHD);
if(count($affichesSrc)!=count($affichesWeb)){
    foreach ($affichesWeb as $afficheWeb){
        if(!in_array($afficheWeb,$affichesSrc)){
            copy($urlWeb.$urlHD.$afficheWeb,$urlSrc.$urlHD.$afficheWeb);
            copy($urlWeb.$urlMiniature.$afficheWeb,$urlSrc.$urlMiniature.$afficheWeb);
        }
    }
    foreach ($affichesSrc as $afficheSrc){
        if(!in_array($afficheSrc,$affichesWeb)){
            unlink($urlSrc.$urlMiniature.$afficheSrc);
            unlink($urlSrc.$urlHD.$afficheSrc);
        }
    }
}
?>