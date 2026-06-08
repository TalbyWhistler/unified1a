<?php 
/*
function createElement($element,$id,$class,$inner)
    {
        $elementString='';
        $elementString=$elementString.'<'.$element.' id="'.$id.'" class="'.$class.'"';
        $elementString=$elementString.'>';
        $elementString=$elementString.$inner;
        $elementString=$elementString.'</'.$element.'>';
        return $elementString;
    }

function createInput($id,$class)
    {
        $elementString='';
        $elementString=$elementString.'<input id="'.$id.'" class="'.$class.'"';
        $elementString=$elementString.'/>';
       // $elementString=$elementString.$inner;
    //    $elementString=$elementString.'</'.$element.'>';
        return $elementString;
    }

function createButton($id,$class,$function,$inner)
    {
        $elementString='';
        $elementString=$elementString
            .'<button id='.$id.' class='.$class.' onclick="'.$function.'()">'
            .$inner 
            .'</button>';
        return $elementString;
    }
*/    
    function notesPage() 
    {
        $textAreaRows=5;

        $br='<br/>';

        $title=createElement('h1','notesTitle','title','Notes');
        $scriptLink='<script src="js/notesScripts.js"></script>';

    
        $inputTextbox='<textarea rows='.$textAreaRows.' id="notesInput" class="panelInput"></textarea>';
        $submitButton=createButton('notesSubmitButton','submitButton','handleNotesSubmitButton','Submit');
        $statusIndicator=createElement('div','notesStatusIndicatorBox','statusIndicatorBox',createElement('p','notesStatusIndicator','statusIndicator','Ready'));
        $notesOutputArea=createElement('div','notesOutputArea','outputArea','');
        
        $inputPanelContents='' 
            .$inputTextbox 
            .$br 
            .$submitButton 
            .$statusIndicator;
        $inputPanel=createElement('div','notesInputPanel','inputPanel',$inputPanelContents);

        $pageContents=''
            .$title 
            .$scriptLink 
            .$inputPanel 
            .$notesOutputArea;

        $pageOutput=createElement('div','notesPage','page',$pageContents);

    
        return $pageOutput;
    }
    
    //echo notesPage();
?> 