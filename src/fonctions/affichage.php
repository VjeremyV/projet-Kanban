<?php

function setContent($string1, $string2, $string3, $string4, $string5, $string6){
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
               echo $string1;
               break;
       }
   }
   else{
       echo $string1;
   }
}
