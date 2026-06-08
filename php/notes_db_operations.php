<?php 
function fetchNotes()
{
    include 'db_connect.php';
    $stmt=$conn->prepare("select * from notes");
    $outputArray=[];
    if ($stmt->execute())
        {
            
            $results=$stmt->get_result();
            while($row=$results->fetch_assoc())
                {
                    $unitArray=['note'=>$row["note"]];
                    array_push($outputArray,$unitArray);
                }
            return $outputArray;
        }
        else 
            {
                return "statement didn't execute";
            }
}


function submitNote($note)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("insert into notes values(?)");
    $stmt->bind_param("s",$note);
    if ($stmt->execute())
        {
            return 'Record updated';
        }
        else 
            {
                return 'Update error';
            }
}


function deleteNote($note)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("delete from notes where note=?");
    $stmt->bind_param("s",$note);
    if ($stmt->execute())
        {
            return 'Note deleted';
        }
        else 
            {
                return "Delete Failed";
            }
}

?>