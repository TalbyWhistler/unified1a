function testFunction0city()
{
    console.log("city scripts");
   
}

function printCitiesInfo(data)
{
    let outputArea=document.getElementById('cityInfoOutputArea');
    let statusArea=document.getElementById('cityStatusIndicator');
    try 
    {
        if (data.length==0)
        {
            outputArea.innerHTML='';
            statusArea.innerHTML='No data';
            return false;
        }
    }
    catch(e)
    {
        outputArea.innerHTML='';
        statusArea.innerHTML='No data';
        return false;
    }
    let tableOpener=
    `
        <table id="cityInfoTable"><tbody>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let tableHeader=
    `
        <tr>
            <th>City</th><th>CoOrdinates</th>
        </tr>
    `;
    let middleRows='';
    for (let i=0;i<data.length;i++)
    {
        middleRows=middleRows+
        `
            <tr>
                <td>${data[i]["city"]}</td>
                <td>${data[i]["coordinates"].toUpperCase()}</td>
            </tr>
        `;
    };
    let fullOutput=
    tableOpener+tableHeader+middleRows+tableCloser;
    outputArea.innerHTML=fullOutput;
    statusArea.innerHTML='Ready';
}

function citiesCallBackend(inputFunction,parameters,callback)
{
    let fetchTarget='php/city_backend_0.php';
    let inputPackage={function:inputFunction,params:parameters};
    inputPackage=JSON.stringify(inputPackage);
    fetch(fetchTarget, 
        {
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:inputPackage
        }
    )
    .then(response=>response.json())
    .then(data=>callback(data));
}

function isAlpha(input)
{
    const contained='abcdefghijklmnopqrstuvwxyz ';
    console.log('=================',input);
    for(let i=0;i<input.length;i++)
    {
        if (contained.indexOf(input[i])==-1)
        {
            return false;
        }
    }
    return true;
}

function isNumber(input)
{
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

function validateCityInput(city)
{
    if (city.length==0)
    {
        return false;
    }
    if (!isAlpha(city))
    {
        return false;
    }
    return true;
}

function validateCoordsInputB(coOrds)
{
    if (coOrds.length==0)
    {
        return false;
    }
    let inputCoOrds=coOrds.replace(' ','');
    if (!isNumber(inputCoOrds[0] || !isNumber(inputCoOrds[1]) || !isNumber(inputCoOrds[3]) || !isNumber(inputCoOrds[4])))
    {
        return false;
    }
    if (!isAlpha(inputCoOrds[2]) || !isAlpha(inputCoOrds[5]))
    {
        return false;
    }
    return true;
}


function validateCoordsInput(coOrds)
{
        if (coOrds.length==0)
    {
        return false;
    }
    let outputEntry='';
    let inputCoOrds=coOrds.replace(' ','');
    inputCoOrds=inputCoOrds.replace('*','');
    const directions="nsew";
    const numbers="0123456789";
    let index=0;
    if (directions.indexOf(inputCoOrds[0])==-1)
    {
        return false;
    }
    else 
    {
        outputEntry+=inputCoOrds[index];
        index+=1;
    }
    
    while(numbers.indexOf(inputCoOrds[index])!=-1)
    {
        outputEntry+=inputCoOrds[index];
        index+=1;
    }
    if (index>3)
    {
        return false;
    }
    if (directions.indexOf(inputCoOrds[index]) != -1)
    {
        outputEntry+=inputCoOrds[index];
        index+=1;
    }
       while(numbers.indexOf(inputCoOrds[index])!=-1)
    {
        outputEntry+=inputCoOrds[index];
        index+=1;
    }
    if (index>6)
    {
        return false;
    }
    return true;
    
}

function testPrint(data)
{
    console.log(data);
}

function fetchCitiesData()
{
    let functionName='fetchCitiesData';
    let params={'testParam':'Yes please all the data'};
    citiesCallBackend(functionName,params,printCitiesInfo);
}




function handleCitySubmit()
{
    console.log('js city submit button');
    let statusOutput=document.getElementById("cityStatusIndicator");
    let cityInput=document.getElementById("cityCityInput").value.toLowerCase().trim();
    let coOrdsInput=document.getElementById("coordsCityInput").value.toLowerCase().trim().replace('*','').replace(' ','');
    console.log('============',cityInput,coOrdsInput);
    if (validateCityInput(cityInput) && validateCoordsInput(coOrdsInput))
    {
        statusOutput.innerHTML='Input accepted'
        cityInput.value='';
        coOrdsInput.value='';
        console.log('ready to submit:'+cityInput+' '+coOrdsInput);
        let functionName='submitCitiesData';
        let params={city:cityInput,coOrds:coOrdsInput};
        citiesCallBackend(functionName,params,submitCallback);
        document.getElementById("cityCityInput").value='';
        document.getElementById("coordsCityInput").value='';
         document.getElementById("cityCityInput").focus();
        
    }
    else 
    {
        statusOutput.innerHTML='Invalid input'
    }
}

function submitCallback(data)
{
    let statusOutput=document.getElementById("cityStatusIndicator");
    statusOutput.innerHTML=data;
    fetchCitiesData();
}

function cityInit()
{
    console.log("city widget init");
    cityAttachStyleSheet();
    fetchCitiesData();
}

function cityAttachStyleSheet()
{
    const styleSheetLocation='css/cityStyles.css';
    const styleLink=document.createElement('link');
    styleLink.rel='stylesheet';
    styleLink.type='text/css';
    styleLink.href=styleSheetLocation;
    document.head.appendChild(styleLink);
    
}


cityInit();