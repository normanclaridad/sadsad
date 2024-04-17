<?php 
// @session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Helpers {

    /**
     * ------------------------------------------------------
     * checkSession
     * ------------------------------------------------------
     * It will check if session is expired or not
     * 
     * @return  boolean 
     */
    public function checkSession() {
        if(!isset($_SESSION['SESS_AUTH'])) {
            return false;
        }
        return true;
    }
    
    public function redirectLogin() {
        header('Location: /login.php');
    }

    /**
     * ------------------------------------------------------
     * encryptDecrypt
     * ------------------------------------------------------
     * Allow integer to encrypt and decrypt
     * 
     * @param $string       string
     * @param $action       string
     * 
     * @return $encrypted   string
     */
    public function encryptDecrypt($string, $action = 'encrypt') {
        $encryptMethod = "AES-256-CBC";
        $secretKey     = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
        $secretIv      = '5fgf5HJ5g27'; // user define secret key
        $key    = hash('sha256', $secretKey);
        $iv     = substr(hash('sha256', $secretIv), 0, 16); // sha256 is hash_hmac_algo
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encryptMethod, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);
        }

        return $output;
    }
    
    /**
     * Check active menu
     * @param uri
     * @param activekeyword
     * 
     * @return boolean
     */

     public function checkactivemenu($uri, $activekeyword) : bool {
        if(stripos($uri, $activekeyword) !== false) {
            return true;
        }

        return false;
    }
}