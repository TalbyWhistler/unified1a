function handleTestClick()
{
    console.log("Testo clicko");
    outputArea=document.getElementById("messageOut");
    outputArea.innerHTML='testo click';
}



function tradingPageInit()
{
    console.log('tradingPageInit');
    attachStyleSheet();
    fetchCities();
    fetchCommodities();
    
    //fetchCity('lisbon');
}

function attachStyleSheet()
{
    const styleSheetLocation='css/tradingStyles.css';
    const styleLink=document.createElement('link');
    styleLink.rel='stylesheet';
    styleLink.type='text/css';
    styleLink.href=styleSheetLocation;
    document.head.appendChild(styleLink);
    
}

function handleTradingSubmitButton()
{
    let cityInput=document.getElementById("cityInput");
    let commodityInput=document.getElementById("commodityInput");
    let buyingPriceInput=document.getElementById("buyingPriceInput");
    let sellingPriceInput=document.getElementById("sellingPriceInput")

    let city=cityInput.value.toLowerCase().trim();
    let commodity=commodityInput.value.toLowerCase().trim(); 
    let buyingPrice=buyingPriceInput.value.trim(); 
    let sellingPrice=sellingPriceInput.value.trim(); 

    console.log("input values",city,commodity,buyingPrice,sellingPrice);

    let functionName="inputRecord";
    let functionParams ={city:city,commodity:commodity,buyingPrice:buyingPrice,sellingPrice:sellingPrice};
    if (isAlphaT(city) &&isAlphaT(commodity) && isNumberT(buyingPrice)&&isNumberT(sellingPrice))
    {
        document.getElementById("tradingStatusIndicator").innerHTML="Input Accepted";
        callTradingBackend("inputRecord",functionParams,afterTradingUpdate);

        // let's not blank the city input for now 
        //document.getElementById("cityInput").value='';
        document.getElementById("commodityInput").value='';
        document.getElementById("buyingPriceInput").value='';
        document.getElementById("sellingPriceInput").value='';
        document.getElementById("commodityInput").focus();
       
    }
    else 
    {
        document.getElementById("tradingStatusIndicator").innerHTML="Invalid Input";
    }
    //let inputPackage={function:functionName,params:functionParams};
    
}


function afterTradingUpdate(data)
{
    statusIndicator=document.getElementById("tradingStatusIndicator");
    statusIndicator.innerHTML=data;
    fetchCommodities();
    fetchCities();
}


function fetchCities()
{
    callTradingBackend('fetchCities','',printCitiesT);
}

function printCitiesT(cities)
{
    console.log(cities);
    outputArea=document.getElementById("citiesArea");
    try 
    {
        if (cities.length==0)
        {
            return false;
        }
    }
    catch(e)
    {
        console.log(e);
        return false;
    }
    let outputMessage='';
    for(let i=0;i<cities.length;i++)
    {
        console.log(cities[i]);
        outputMessage=outputMessage+
        `
            <button class="cityButton" id="cityButton${i}" onclick="handleCityButton('${cities[i]}')">${cities[i]}</button>
        `;
    }
    citiesArea.innerHTML=outputMessage; 
}

function callTradingBackend(functionName,params,callback)
{
    let fetchTarget='php/trading_backend_0.php';
    let inputPackage={function:functionName,params:params};
    
    inputPackage=JSON.stringify(inputPackage);
    fetch(fetchTarget,
        {
            method:'POST',
            headers:{'Content-Type':'Application/json'},
            body:inputPackage
        }
    )
    .then(response=>response.json())
    .then(data=>callback(data));
}

function fetchCommodities()
{
    callTradingBackend('fetchCommodities','',printCommodities);
}

function printCommodities(commodities)
{
    console.log(commodities);
    //outputArea=document.getElementById("commoditiesArea");
    try 
    {
        if (commodities.length==0)
        {
            return false;
        }
    }
    catch(e)
    {
        console.log(e);
        return false;
    }
    let outputMessage='';
    for(let i=0;i<commodities.length;i++)
    {
        console.log(commodities[i]);
        outputMessage=outputMessage+
        `
            <button class="commodityButton" id="commodityButton${i}" onclick="handleCommodityButton('${commodities[i]}')">${commodities[i]}</button>
        `;
    }
    commoditiesArea.innerHTML=outputMessage; 
}

function handleCityButton(city)
{
    console.log('handle city button city is',city);
    fetchCity(city);
    fetchTradeRoutesByCity(city);
}


function printCityInfo(data,city)
{

    try 
    {
        if (data.length==0)
        {
            return false;
        }
    }
    catch(error)
    {
        console.log(error);
        return false;
    }
    let tableOpener=
    `
        <table class="infoTable"><tbody>
    `;
    let tableHeader=
    `
        <tr>
            <th>
                <h3>${city}</h3>
            </th>
        </tr>
        <tr>
            <th>Commodity</th>
            <th>Selling Price</th>
            <th>Buying Price</th>
            
        </tr>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let tableRows='';
    for (let i=0;i<data.length;i++)
    {
        console.log(data[i].commodity);
        tableRows=tableRows+
        `
            <tr>
                <td>${data[i].commodity}</td>
                <td>${data[i].sellingPrice}</td>
                <td>${data[i].buyingPrice}</td>
            </tr>
        `;
    }
    infoArea.innerHTML=tableOpener+tableHeader+tableRows+tableCloser;
}


function printCommodityInfo(data,commodity)
{

    try 
    {
        if (data.length==0)
        {
            return false;
        }
    }
    catch(error)
    {
        console.log(error);
        return false;
    }
    let tableOpener=
    `
        <table class="infoTable"><tbody>
    `;
    let tableHeader=
    `
        <tr id="infoTableHeader">
            <th>
                <h3>${commodity}</h3>
            </th>
        </tr>
        <tr>
            <th>City</th>
            <th>Selling Price</th>
            <th>Buying Price</th>         
        </tr>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let tableRows='';
    for (let i=0;i<data.length;i++)
    {
        console.log(data[i].city);
        tableRows=tableRows+
        `
            <tr>
                <td>${data[i].city}</td>
                <td>${data[i].sellingPrice}</td>
                <td>${data[i].buyingPrice}</td>
            </tr>
        `;
    }
    infoArea.innerHTML=tableOpener+tableHeader+tableRows+tableCloser;
}

function handleCommodityButton(commodity)
{
    console.log('handle commodity button commodity:',commodity);
    fetchCommodity(commodity);
    fetchTradeRoutesByCommodity(commodity);
}

function fetchCity(city)
{
     let fetchTarget='php/trading_backend_0.php';
     let functionName='fetchCity';
     let params={city:city};
     let inputPackage={function:functionName,params:params};
     inputPackage=JSON.stringify(inputPackage);
     fetch(fetchTarget,
        {
            method:'POST',
            headers:{'Content-Type':'Application/json'},
            body:inputPackage
        }
     )
     .then(response=>response.json())
     .then(data=>printCityInfo(data,city));
}

function fetchCommodity(commodity)
{
     let fetchTarget='php/trading_backend_0.php';
     let functionName='fetchCommodity';
     let params={commodity:commodity};
     let inputPackage={function:functionName,params:params};
     inputPackage=JSON.stringify(inputPackage);
     fetch(fetchTarget,
        {
            method:'POST',
            headers:{'Content-Type':'Application/json'},
            body:inputPackage
        }
     )
     .then(response=>response.json())
     .then(data=>printCommodityInfo(data,commodity));
}


function fetchTradeRoutesByCity(city)
{
     callTradingBackend('tradeRoutesByCity',{city:city},printTradeRoutesByCity);
}

function fetchTradeRoutesByCommodity(commodity)
{
    let fetchTarget='php/trading_backend_0.php';
    let functionName='tradeRoutesByCommodity';
    let params={commodity:commodity};
    let inputPackage={function:functionName,params:params};
    inputPackage=JSON.stringify(inputPackage);
    fetch(fetchTarget,
        {
            method:'POST',
            headers:{'Content-Type':'Application/json'},
            body:inputPackage
        }
     )
     .then(response=>response.json())
     .then(data=>printTradeRoutesByCommodity(data,commodity));
}


function printTradeRoutesByCity(data)
{
    try 
    {
        if (data.length==0)
        {
            return false;
        }
    }
    catch(e)
    {
        return false;
    }
    let outputArea=document.getElementById("tradeRouteArea");
    let tableStart=
    `
        <table class="tradeRouteTable"><tbody>
    `;
    let tableHeader=
    `
        <tr>
            <th>
                <h3>Trade Routes</h3>
            </th>
        </tr>
 
        <tr>
            <th>Commodity</th>
            <th>From</th>
            <th>To</th>
            <th>Profit</th>
        </tr>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let tableRows='';
    for (let i=0;i<data.length;i++)
    {
        let commodity=data[i]["commodity"];
        let from=data[i]["from"];
        let to=data[i]["to"];
        let profit=data[i]["profit"];
        tableRows=tableRows+
        `
        <tr>
            <td>
                ${commodity}
            </td>
            <td>
                ${from}
            </td>
            <td>
                ${to}
            </td>
            <td>
                ${profit}
            </td>
        <tr>
        `;
    }
    let fullOutput=tableStart+tableHeader+tableRows+tableCloser;
    outputArea.innerHTML=fullOutput;
}


function printTradeRoutesByCommodity(data)
{
    try 
    {
        if (data.length==0)
        {
            return false;
        }
    }
    catch(e)
    {
        return false;
    }
    let outputArea=document.getElementById("tradeRouteArea");
    let tableOpener=
    `
        
        <table class="tradeRouteTable"><tbody>
    `;
    let tableHeaders=
    `
        
        <tr>
            <th>
                <h3>Trade Routes</h3>
            </th>
        </tr>
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Profit</th>
        </tr>
    `;
    let tableCloser=
    `
        </tbody>
        </table>
    `; 
    let tableRows='';
    for (let i=0;i<data.length;i++)
    {
        let from=data[i]["from"];
        let to=data[i]["to"];
        let profit=data[i]["profit"];
        tableRows=tableRows+
        `
            <tr>
                <td>${from}</td>
                <td>${to}</td>
                <td>${profit}</td>
            </tr>
        `;
    }
    let fullOutput=tableOpener+tableHeaders+tableRows+tableCloser;
    outputArea.innerHTML=fullOutput;
}




function isAlphaT(input)
{
    try 
    {
        let topLength=input.length;
        if (topLength==0)
        {
            return false;
        }
    }
    catch(e)
    {
        return false;
    }
    const contained='abcdefghijklmnopqrstuvwxyz ';
    console.log(input);
    for(let i=0;i<input.length;i++)
    {
        if (contained.indexOf(input[i])==-1)
        {
            return false;
        }
    }
    return true;
}

function isNumberT(input)
{
    try 
    {
        let topLength=input.length;
        if (topLength==0)
        {
            return false;
        }
    }
    catch(e)
    {
        return false;
    }
    const contained='0123456789';
    for (let i=0;i<input.length;i++)
    {
        if(contained.indexOf(input[i])==-1)
        {
            return false;
        }
    }
    return true;
}

tradingPageInit();