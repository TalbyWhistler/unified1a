<?php 


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

function itemPage()
{
    $titleBox=createElement('h1','itemTitle','itemTitle',"Item Keeper");
        $br='</br>';
        $cityInputLabel=createElement('label','cityInputLabel','inputLabel','City:');
        $cityInputBox=createInput("itemCityInput","itemPanelInputs");
       
        $cityInput=''
            .$cityInputLabel  
            .$br 
            .$cityInputBox 
        ;
        $itemLabel=createElement('label','itemInputLabel','inputLabel','Item:');
        $itemInputBox=createInput("itemItemInput","itemPanelInputs");
        
        $itemInput=''
            .$br 
            .$itemLabel 
            .$br 
            .$itemInputBox;
        
        $priceLabel=createElement('label','itemPriceInputLabel','inputLabel','Price:');
        $priceInput=createInput("itemPriceInput","itemPanelInputs");
        
        $costInput=''
            .$br 
            .$priceLabel 
            .$br
            .$priceInput;
        
        $submitButton=createButton("itemSubmitButton","submitButton","handleItemSubmit","Submit");
        
        $itemSubmitButton=''
            .$br 
            .$submitButton;

        $indicator=createElement('p','itemStatusIndicator','statusIndicator','Ready');
        $indicatorBox=createElement('div','itemStatusIndicatorBox','indicatorBox',$indicator);
        
        $inputBoxContents=''
            .$cityInput 
            .$itemInput 
            .$costInput 
            .$itemSubmitButton 
            .$indicatorBox;

        $inputBox=createElement('div','itemInputBox','itemInputPanel',$inputBoxContents);
        $scriptLink='<script src="js/item_scripts_0.js"></script>';
      
        $cityButtonArea=createElement('div','cityButtonArea','infoSubArea','');
        $itemButtonArea=createElement('div','itemButtonArea','infoSubArea','');

        $middleBandContents='' 
            .$cityButtonArea 
            .$itemButtonArea;
       
        $middleBand=createElement('div','itemMiddleBand','midBandArea',$middleBandContents);   
        
        $infoOutputArea=createElement('div','itemInfoOutputArea','outputArea','');
        
        $pageContents=''
            .$titleBox
            .$inputBox 
            .$scriptLink 
            .$middleBand 
            .$infoOutputArea;
        
        $pageOutput=createElement('div','itemPage','page',$pageContents);
        
        return $pageOutput;
}

echo itemPage();
        
?>