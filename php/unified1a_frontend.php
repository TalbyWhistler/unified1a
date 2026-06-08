<?php 
    include 'trading_frontend_0.php';
    include 'item_frontend_0.php';
    include 'city_frontend.php';
    include 'notes_frontend.php';

    $tradingWidget=tradingPage();
    $itemWidget=itemPage();
    $cityWidget=citiesPage();
    $notesWidget=notesPage();
    

    $applicationFrameContents=''
        .$tradingWidget
        .$itemWidget
        .$cityWidget
        .$notesWidget;

    $applicationFrame=createElement('div','appFrame','appFrame',$applicationFrameContents);

    
    echo $applicationFrame;
?>