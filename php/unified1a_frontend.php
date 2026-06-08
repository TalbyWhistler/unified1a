<?php 
    include 'trading_frontend_0.php';
    include 'item_frontend_0.php';
    include 'city_frontend.php';
    include 'notes_frontend.php';

    $headerBand=createElement('div','unifiedHeaderBand','headerBand','');
    $leftBand=createElement('div','unifiedLeftBand','headerBand','');
    $rightBand=createElement('div','unifiedRightBand','headerBand','');
    $invisibleDiv=createElement('div','unifiedInvisibleDiv','invisibleDiv','');

    $tradingWidget=tradingPage();
    $itemWidget=itemPage();
    $cityWidget=citiesPage();
    $notesWidget=notesPage();
    

    $applicationFrameContents=''
        .$leftBand
        .$tradingWidget
        .$itemWidget
        .$notesWidget
        .$cityWidget
       // .$invisibleDiv
        .$rightBand;

    $applicationFrame=createElement('div','appFrame','appFrame', $applicationFrameContents);
    $pageOutput=''
        .$headerBand 
        .$applicationFrame;
    
    echo $pageOutput;
?>