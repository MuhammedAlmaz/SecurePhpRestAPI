<?php

    function CreateByteArray(){
        $Bytes=array();
        for($i=0;$i<16;$i++)
        {
            $Bytes[]=rand(0,255);
        }
        return $Bytes;
    }

    function ByteArrayToHexString($ByteArray){

        $Hex='';
        foreach($ByteArray as $Byte)
        {
            $Hex.=sprintf('%02X',$Byte);
        }
        return $Hex;
    }
