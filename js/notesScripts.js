function notesTestFunction0()
{
    console.log("NOtes test function");
    notesCallBackend("testFunction",'',testPrint);
}


function notesScriptsInit()
{
    console.log("notesScripts init");
    attachStyleSheet();
    fetchNotes();
}

function fetchNotes()
{
    notesCallBackend("fetchNotes",'',printNotes);
}

function attachStyleSheet()
{
    const styleSheetLocation='css/notesStyles.css';
    const styleLink=document.createElement('link');
    styleLink.rel='stylesheet';
    styleLink.type='text/css';
    styleLink.href=styleSheetLocation;
    document.head.appendChild(styleLink);
}

function testPrint(data)
{
    console.log(data);
}


function notesCallBackend(inputFunction,parameters,callback)
{
    let fetchTarget='php/notes_app_backend.php';
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

function printNotes(data)
{
    let notesOutput=document.getElementById("notesOutputArea");
    try 
    {
        if (data.length==0)
        {
            notesOutput.innerHTML='';
            return false;
        }
    }
    catch(e)
    {
        notesOutput.innerHTML='';
        return false;
    }
    let tableOpener=
    `
        <table id="notesOutputTable"><tbody>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let middleRows='';
    for (let i=0;i<data.length;i++)
    {
        let buttonNote=data[i]["note"].replaceAll("'","&&&");
        middleRows=middleRows+
        `
            <tr class="noteRows">
                <td class="noteEntry">${data[i]["note"]}<td>
                
                <td class="deleteColumn"><button class="noteDeleteButton" onclick="handleNoteDelete('${buttonNote}')">Del</button></td>
            </tr>
        `;
    }
    let fullOutput=
    `
        ${tableOpener}
        ${middleRows}
        ${tableCloser}
    `;
    notesOutput.innerHTML=fullOutput;
}


function handleNoteDelete(note)
{
    console.log("Handle note delete for",note);
    let inputNote=note.replaceAll("&&&","'");
    notesCallBackend("deleteNote",{note:inputNote},afterDelete);
}

function afterDelete(data)
{
    let statusIndicator=document.getElementById("notesStatusIndicator");
    let inputArea=document.getElementById("notesInput");
    statusIndicator.innerHTML=data;
    fetchNotes();
}

function handleNotesSubmitButton()
{
    console.log("Submit button");
    let statusIndicator=document.getElementById("notesStatusIndicator");
    let inputArea=document.getElementById("notesInput");
    let inputNote=inputArea.value;
    console.log("Submitting ",inputNote);
    if (!validateNoteInput(inputNote))
    {
        statusIndicator.innerHTML='Invalid Input';
    }
    else 
    {
        statusIndicator.innerHTML='Input Accepted';
        notesCallBackend("submitNote",{note:inputNote},afterUpdate);
    }
}

function afterUpdate(data)
{
    let statusIndicator=document.getElementById("notesStatusIndicator");
    let inputArea=document.getElementById("notesInput");
    statusIndicator.innerHTML=data;
    inputArea.value='';
    
    fetchNotes();
}


function validateNoteInput(note)
{
    
    if (note.length==0)
    {
       // 
        return false;
    }
    //
    return true;
}














notesScriptsInit();