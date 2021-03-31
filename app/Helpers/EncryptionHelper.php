<?php
namespace App\Helpers;

class EncryptionHelper {

    const skey = "safwer4w45sd343gsdfd5gdf"; // you can change it

    public static function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);

        return $data;
    }

    public static function safe_b64decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }

        return base64_decode($data);
    }

    public static function encode($value) {
        if (!$value) {
            return false;
        }
        /*$text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        
        return trim($this->safe_b64encode($crypttext));*/
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($value, 'aes-256-cbc', static::skey, 0, $iv);
        return self::safe_b64encode($encrypted . '::' . $iv);
    }
    
    /**
     * 
     * @param string $value
     * @return string
     */
    public function decode($value) {
        if (!$value) {
            return false;
        }
        /*$crypttext = $this->safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        
        return trim($decrypttext);*/
        
        list($encrypted_data, $iv) = explode('::', $this->safe_b64decode($value), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', static::skey, 0, $iv);
    }
    
    /**
     * create password
     */
    public static function createPassword($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%)(_-+=';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
