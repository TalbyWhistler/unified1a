<?php 
    
function fetchCitiesInfo()
{
    include 'item_db_connect.php';
    $stmt=$conn->prepare("select * from cities");
    $outputArray=[];
    if ($stmt->execute())
        {
           // return 'statement has executed';
           $results=$stmt->get_result();
           while ($row=$results->fetch_assoc())
            {
                $unitArray=['city'=>$row["city"],'coordinates'=>$row["coordinates"]];
                array_push($outputArray,$unitArray);
            }
            return $outputArray;
        }
        else 
            {
                return 'statment not executed';
            }
}



function submitCityInfo($city,$coordinates)
{
    include 'item_db_connect.php';
    $stmt=$conn->prepare("delete from cities where city=?");
    $stmt->bind_param("s",$city);
    $stmt->execute();
    $stmt=$conn->prepare("insert into cities values(?,?)");
    $stmt->bind_param("ss",$city,$coordinates);
    if ($stmt->execute())
        {
            return "Record Updated";
        }
        else 
            {
                return "Error updating record.";
            }
}

?>