<?php 
    include 'trading_db_operations.php';
    $rawInput=file_get_contents('php://input');
    $jsonInput=json_decode($rawInput,true);
    $function=$jsonInput["function"];
    $returnMessage='';
    switch($function)
    {
        case 'inputRecord':
            {
                
                $functionParams=$jsonInput["params"];
                $city=$functionParams["city"];
                $commodity=$functionParams["commodity"];
                $buyingPrice=$functionParams["buyingPrice"];
                $sellingPrice=$functionParams["sellingPrice"];
               // $returnMessage='Input Record'.$city.' '.$commodity.' '.$buyingPrice.' '.$sellingPrice;
                $returnMessage=inputRecord($city,$commodity,$buyingPrice,$sellingPrice);
                break;
            }
        case 'fetchCities':
            {
                $returnMessage=fetchCities();
                break;
            }
        case 'fetchCommodities':
            {
                $returnMessage=fetchCommodities();
                break;
            }
        case 'fetchCity':
            {
                $functionParams=$jsonInput["params"];
                $city=$functionParams["city"];
                $returnMessage='fetchCity control'.$city;
                $returnMessage=fetchCityInfo($city);
                break;
            }
        case 'fetchCommodity':
            {
                $functionParams=$jsonInput["params"];
                $commodity=$functionParams["commodity"];
                $returnMessage='fetchCommodity control'.$commodity;
                $returnMessage=fetchCommodityInfo($commodity);
                break;
            }
        case 'tradeRoutesByCity':
            {
                $functionParams=$jsonInput["params"];
                $city=$functionParams["city"];
                $returnMessage=getTradeRouteByCity($city);
                break;
            }
        case 'tradeRoutesByCommodity':
            {
                $functionParams=$jsonInput["params"];
                $commodity=$functionParams["commodity"];
                $returnMessage=getTradeRouteByCommodity($commodity);
                break;
            }
    }

    echo json_encode($returnMessage);
    
    
    



?>