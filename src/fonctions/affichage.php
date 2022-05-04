<?php
/**
 * affiche les elements en paramètres en fonction de la querystring 'page'
 *
 * @param [string] $string1
 * @param [string] $string2
 * @param [string] $string3
 * @param [string] $string4
 * @param [string] $string5
 * @param [string] $string6
 * @return void
 */
function setContent(string $string1, string $string2, string $string3, string $string4, string $string5, string $string6):void{
    if(isset($_GET['page'])){
       $page = $_GET['page'];
       switch($page){
           case 'inscription':
               echo $string2;
               break;
           case 'profil':
               echo $string3;
               break;
           case 'encours':
               echo $string4;
               break;

           case 'creerprojet':
               echo $string5;
               break;
           case 'terminer_projet':
               echo $string6;
               break;
          
           default:
               echo "Projet : ".$_GET['page'];
               break;
       }
   }
   else{
       echo "$string1";
   }
}
