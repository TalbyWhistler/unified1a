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

    function tradingPage()
    {
        $cityInputLabel=createElement('label','cityInputLabel','inputLabels','City');
        $cityInput=createInput("cityInput","panelInputs");
        $commodityInputLabel=createElement('label','commodityInputLabel','panelInputs',"Commodity");
        $commodityInput=createInput("commodityInput","panelInputs");
        $buyingInputLabel=createElement('label','buyingInputLabel','inputLabels',"Buying Price");
        $buyingInput=createInput('buyingPriceInput',"panelInputs");
        $sellingInputLabel=createElement('label','sellingInputLabel','inputLabels',"Selling Price");
        $sellingInput=createInput('sellingPriceInput','panelInputs');
        $button=createButton("tradingSubmitButton","tradingSubmitButton","handleTradingSubmitButton",'Submit');
        $br='</br>';
        $statusIndicator=createElement('p','tradingStatusIndicator','statusIndicator','Ready');
        $statusIndicatorBox=createElement('div','tradingStatusIndicatorBox','statusIndicatorBox',$statusIndicator);
        
        $panelContents=''
            .$cityInputLabel.$br.$cityInput.$br
            .$commodityInputLabel.$br.$commodityInput.$br 
            .$buyingInputLabel.$br.$buyingInput.$br 
            .$sellingInputLabel.$br.$sellingInput.$br 
            .$button
            .$statusIndicatorBox;

        $inputPanel=createElement('div','inputPanel','inputPanel',$panelContents);
        
    
        $scriptLink='<script src="js/tradingScripts.js"></script>';
        
        $citiesArea=createElement('div','citiesArea','infoOutputs','');
        $commoditiesArea=createElement('div','commoditiesArea','infoOutputs','');
        $infoArea=createElement('div','infoArea','infoOutputs','');
        $tradeRouteArea=createElement('div','tradeRouteArea','infoOutputs','');
        $displayRow=createElement('div',"tradingRow","row",$infoArea.$tradeRouteArea);
        $title=createElement('h1',"tradingTitle","tradingTitle","Trade Route Information");

        $outputPageContents=''
            .$title
            .$scriptLink
            .$inputPanel 
            .$citiesArea
            .$commoditiesArea
            .$displayRow;
            
        $outputPage=createElement('div','tradePage','tradePage',$outputPageContents);
        
        return $outputPage;
    }
    

   
    
   // echo tradingPage();
?>