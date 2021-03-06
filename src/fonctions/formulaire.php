<?php
/**
 * valide les entrées formulaires
 *
 * @param [string] $input valeur rentrée par l'utilisateur
 * @param [string] $type d'input
 * @return bool
 */
function validForm(string $input, string $type=null):bool
{
    $errors = [];
    if (isset($input) && !empty($input)) {
        if ($type == "mail") {
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "le mail est mauvais";
            }
        }
    } else {
        $errors[] = "vous devez remplir les champs";
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo $error;
        }
        return false;
    }
    return true;
}

/**
 * vérifie l'égalité entre 2 valeurs
 *
 * @param [mixed] $valeur1 string ou int
 * @param [mixed] $valeur2 string ou int
 * @return bool
 */
function egalvalue(mixed $valeur1, mixed $valeur2) :bool
{
    if ($valeur1 == $valeur2) {
        return true;
    }
    return false;
}
/**
 * verifie l'unicité d'un mail dans un tableau de mail
 *
 * @param [array] $bddMail
 * @param [string] $email
 * @param [string] $cle
 * @return bool
 */
function uniqueMail(array $bddMail, string $email, string $cle):bool{
    foreach($bddMail as $key => $mail){
        if($mail[$cle] == $email){
            return false;
        }
    }
    return true;
}