<?php 
     


$servername="localhost";
//$servername="%waters";
$username = "webUser1";
$password = "watersWeb";
$dbName = "unchartedWatersb";

$conn = new mysqli($servername,$username,$password,$dbName);
$returnValue=false;
if ($conn->connect_error)
    {
       // echo "</br>connect false";
    }
    else 
        {
           // echo "</br>connect true";
           $returnValue=true;
        }

return $returnValue;

?>