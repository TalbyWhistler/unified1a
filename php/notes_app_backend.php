<?php 
    include 'notes_db_operations.php';
    $rawInput=file_get_contents('php://input');
    $jsonInput=json_decode($rawInput,true);
    $function=$jsonInput["function"];
    $returnMessage='';
    switch($function)
    {
        case("testFunction"):
            {
                $returnMessage='test function control has fired';
                break;
            }
        case("fetchNotes"):
            {
                $returnMessage='fetch notes control has fired';
                $returnMessage=fetchNotes();
                break;
            }
        case("submitNote"):
            {
                $functionParams=$jsonInput["params"];
                $inputNote=$functionParams["note"];
                //$returnMessage='Submit note control has fired with note '.$inputNote;
                $returnMessage=submitNote($inputNote);
                break;
            }
        case("deleteNote"):
            {
                $functionParam=$jsonInput["params"];
                $inputNote=$functionParam["note"];
                $returnMessage='delete note control has fired with note '.$inputNote;
                $returnMessage=deleteNote($inputNote);
            }
    }
    echo json_encode($returnMessage);

?>