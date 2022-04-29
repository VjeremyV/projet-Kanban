<?php
/**
 * deconnecte un utilisateur / detruit une session
 * @return void
 */
function disconnect()
{
    if (isConnect()){
        session_destroy();
    }
}
/**
 * vérifie si une connexion est en cours
 * @return boolean
 */
function isConnect()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['mail'])) {
        return true;
    }
    session_destroy();
    return false;
}