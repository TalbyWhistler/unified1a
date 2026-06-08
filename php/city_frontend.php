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
function citiesPage() 
{
    $br='</br>';
    $titleBox=createElement('h1',"cityTitle","cityTitle",'Cities');
    $cityLabel=createElement('label','cityCityInputLabel','inputLabel','City:');
    
    $cityInputBox=createInput("cityCityInput","cityPanelInputs");
    
    $cityInput=''
        .$cityLabel 
        .$br 
        .$cityInputBox;
   
    $coOrdsLabel=createElement('label','citiesCoOrdsLabel','inputLabel','CoOrdinates:');
    $coOrdsInputBox=createInput('coordsCityInput','cityInputPanel');
    $submitButton=createButton("citySubmitButton","submitButton",'handleCitySubmit',"Submit");
    $coOrdsInput=''
        .$br 
        .$coOrdsLabel 
        .$coOrdsInputBox;
    
    $statusIndicator=createElement('div',"cityStatusIndicatorBox","statusIndicatorBox",createElement('p',"cityStatusIndicator","statusIndicator","Ready"));
    $inputBoxContents=''
        .$cityInput
        .$coOrdsInput 
        .$br 
        .$submitButton 
        .$statusIndicator;
   
    $inputBox=createElement("div","cityInputBox","inputBox",$inputBoxContents);
    
    $middleBand=createElement('div',"cityMiddleBand","middleBand",'');
    
    $infoOutputArea=createElement('div','cityInfoOutputArea','infoOutputArea','');
    $scriptLink='<script src="js/cityScripts.js"></script>';
    
    $pageOutputContents='' 
        .$titleBox 
        .$inputBox 
        .$scriptLink 
        .$middleBand 
        .$infoOutputArea;

    $pageOutput=createElement('div','cityPage','pageOutput',$pageOutputContents);

    return $pageOutput;
}
    

 
    
   // echo citiesPage();
?>