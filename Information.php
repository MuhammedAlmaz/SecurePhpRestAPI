<?php
    require_once("DataCrypter.php");
    require_once("Security.php");


    $Data=$_POST["Data"];


    //Its my secret and IV keys i hide them inner My Database. I writed it manual.
    $Hex_IV="E16A27BB07DB9D8B4CE6CBA41FC05772";
    $Secret="f254f9f9ea5d4d9b";


    //i hide PostCounter inner database too.
    $PostCounter=0;
    $Result=array();

    $MCRypt = new MCrypt($Secret,$Hex_IV);
    $ClearData= $MCRypt->decrypt($Data);

    if($ClearData["PostCounter"]==$PostCounter)
    {
        //I Updating PostCounter if the Counter true.
        //$db->prepare("Update Users SET Counter=Counter+1 Where UserID=:UserID");
        $Result["Status"]="Successful";
        if($ClearData["Ask"]=='HowAreYou')
        {
            $Result["Answer"]="Fine";
        }else{
            $Result["Answer"]="What did you say ?";
        }

    }
    else{
        $Result["Status"]="Token breaked";
        //You need clear the tokens and PostCounter for security.
    }
    $CrypedResult=$MCRypt->encrypt(json_encode($Result));
    print_r($CrypedResult);

