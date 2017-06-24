<?php

   



    class MCrypt {
        public $Hex_Iv ; # converted Java byte code in to HEX and placed it here
        public $SecretKey;

        function __construct($Key,$Hex) {
            $this->SecretKey = hash('sha256', $Key, true);
            $this->Hex_Iv=$Hex;


        }



        function encrypt($CryptingData) {
            $TD = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            mcrypt_generic_init($TD, $this->SecretKey, $this->hexToStr($this->Hex_Iv));
            $Block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $Pad = $Block - (strlen($CryptingData) % $Block);
            $CryptingData .= str_repeat(chr($Pad), $Pad);
            $encrypted = mcrypt_generic($TD, $CryptingData);
            mcrypt_generic_deinit($TD);
            mcrypt_module_close($TD);
            return base64_encode($encrypted);
        }

        function decrypt($CryptedData) {
            $TD = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            mcrypt_generic_init($TD, $this->SecretKey, $this->hexToStr($this->Hex_Iv));
            $CryptedData = mdecrypt_generic($TD, base64_decode($CryptedData));
            $Block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            mcrypt_generic_deinit($TD);
            mcrypt_module_close($TD);
            $ClearData=$this->strippadding($CryptedData);
            return json_decode($ClearData,true);
        }

        private function strippadding($Text) {
            $Slast = ord(substr($Text, -1));
            $SlastChar = chr($Slast);
            if (preg_match("/$SlastChar{" . $Slast . "}/", $Text)) {
                $Text = substr($Text, 0, strlen($Text) - $Slast);
                return $Text;
            } else {
                return false;
            }
        }
        function hexToStr($hex)
        {
            $string='';
            for ($i=0; $i < strlen($hex)-1; $i+=2)
            {
                $string .= chr(hexdec($hex[$i].$hex[$i+1]));
            }
            return $string;
        }
    }




