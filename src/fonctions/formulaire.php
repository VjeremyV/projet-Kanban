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
                $errors[] = "L'adresse mail n'est pas valide'";
            }
        }
        if ($type == 'int') {
            if (!is_numeric($input)) {
                $errors[] = "Un champs qui requiert un chiffre a mal été renseigné";
            }
        }
    } else {
        $errors[] = "vous n'avez pas rempli tous les champs";
    }
    if (count($errors) > 0) {
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
function isUnique(array $bddMail, string $email, string $cle):bool
{
    foreach ($bddMail as $key => $mail) {
        if ($mail[$cle] == $email) {
            return false;
        }
    }
    return true;
}
/**
 * verifie la validité d'une date
 *
 * @param [string] $date à checker
 * @param string $format à tester
 * @return bool
 */
function validateDate(string $date, string $format = 'Y-m-d H:i:s'):bool
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


 /**
  *   valide le telechargement d'une photo de profil
  * @param string $name
  * @param [array] $extensions
  * @param [string] $dir
  * @param [string] $typeFichier
  * @return boolean
  */
function validFile(string $name, array $extensions, string $dir, string $typeFichier = null):bool
{
    if ($_FILES[$name]['name'] !== '') {
        $type = $_FILES[$name]['type'];
        $type = explode('/', $type);
        $type = $type[1];
        $accept = $extensions;
        if (in_array($type, $accept)) {
            $upload = __DIR__.$dir;
            if (!$directory = opendir($upload)) {
                echo '<p>Impossible d\'ouvrir le répertoire</p>';
            }
            $countFile=0;
            while ($file = readdir($directory)) {
                if (!is_dir($file)) {
                    $tempType = explode('.', $file);
                    if (count($tempType) > 1) {
                        $tempType = $tempType[count($tempType)-1];
                        if (in_array($tempType, $accept)) {
                            $countFile = $countFile+1;
                        }
                    }
                }
            }
            $countFile = $countFile+1;
            $date = date('YmdHms');
            if (!move_uploaded_file($_FILES[$name]['tmp_name'], $upload.$date.$countFile.'.'.$type)) {
                echo 'une erreur est survenue pendant le téléchargement du fichier';
            } else {
                if ($typeFichier == 'photo') {
                    $_POST['photo'] =  $date.$countFile.'.'.$type;
                } else {
                    $_POST['fichier'] = $date.$countFile.'.'.$type;
                }
                return true;
            }
        } else {
            return false;
        }
    }
}
