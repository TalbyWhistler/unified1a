<?php 


function fetchCities()
{
    $statement='select distinct city from items';
    $attribute='city';
    $outputArray=selectOnly($statement,$attribute);
    if ($outputArray)
        {
            return $outputArray;
        }
    else 
        {
            return false;
        }
}

function fetchItems()
{
    $statement='select distinct item from items';
    $attribute='item';
    $outputArray=selectOnly($statement,$attribute);
    if ($outputArray)
        {
            return $outputArray;
        }
    else 
        {
            return false;
        }
}

function fetchItemInfoByCity($city)
{
      include 'item_db_connect.php';
      $outputArray=[];
      $stmt=$conn->prepare('select distinct item,price from items where city=?');
      $stmt->bind_param("s",$city);
      if ($stmt->execute())
        {
           
            $results=$stmt->get_result();
            while ($row=$results->fetch_assoc())
                {
                    $unitArray=['item'=>$row["item"],'price'=>$row["price"]];
                    array_push($outputArray,$unitArray);
                }
            return $outputArray;
        }
    else 
        {
            return 'statement has not executed';
        }
}

function fetchItemInfoByItem($item)
{
      include 'item_db_connect.php';
      $outputArray=[];
      $stmt=$conn->prepare('select distinct city,price from items where item=?');
      $stmt->bind_param("s",$item);
      if ($stmt->execute())
        {
           
            $results=$stmt->get_result();
            while ($row=$results->fetch_assoc())
                {
                    $unitArray=['city'=>$row["city"],'price'=>$row["price"]];
                    array_push($outputArray,$unitArray);
                }
            return $outputArray;
        }
    else 
        {
            return 'statement has not executed';
        }
}


function selectOnly($statement,$attribute)
{
    include 'item_db_connect.php';
    $stmt=$conn->prepare($statement);
    $outputMessage='';
    $outputArray=[];
    if ($stmt->execute())
        {
            $results=$stmt->get_result();
            while ($row=$results->fetch_assoc())
                {
                    $unitArray=[$attribute=>$row[$attribute]];
                    array_push($outputArray,$unitArray);
                }
            return $outputArray;
        }
        else 
            {
                return false;
            }
}


function submitItemEntry($item,$city,$price)
{
    include 'item_db_connect.php';
    $stmt=$conn->prepare("delete from items where item=? and city=?");
    $stmt->bind_param("ss",$item,$city);
    $stmt->execute();
    $stmt=$conn->prepare("insert into items values(?,?,?)");
    $stmt->bind_param("ssi",$item,$city,$price);
    if ($stmt->execute())
        {
            return 'Record updated';
        }
        else 
            {
                return "Update failed";
            }
}
?>