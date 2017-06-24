<?php
    require_once("DataCrypter.php");
    require_once("Security.php");
    //You can give a manuel Keys for login.
    //But you can login unsafe too.
    //I will give a manuel key to login after than i am going to give the Post/Get/Request Keys to MyClient.

    $Data=$_POST["Data"];


    //its my default login keys. And I will decrypt the data.
    $Hex_IV="0DB2F3EC14F946053ACAB47609C84674";
    $Secret="8e035a5537c0ea2d";

    $MCRypt = new MCrypt($Secret,$Hex_IV);
    $ClearData= $MCRypt->decrypt($Data);



    //Now i get The UserName And Password
    if($ClearData['UserName']=='MhmdAlmz'&&$ClearData['Password']=='FatihSultanMehmed1453')
    {

        $Result=array();
        $Result["Result"]="Successful";
        $Result["IV"]=CreateByteArray();
        $Result["SecretKey"]=substr(md5(uniqid(mt_rand(), true)), 0, 16);
        $Result["PostCounter"]=0;
        $Result["HexIV"]=ByteArrayToHexString($Result["IV"]);
        $Result["IV"]=implode(",",$Result["IV"]);
        $CrypedResult=$MCRypt->encrypt(json_encode($Result));
        print_r($CrypedResult);

    }else{
        $Result["Result"]="Unsuccessful";
        $CrypedResult=$MCRypt->encrypt(json_encode($Result));
        print_r($CrypedResult);
    }








