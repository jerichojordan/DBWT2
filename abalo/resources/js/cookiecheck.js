"use strict";
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


if(getCookie('cookiesAccepted')!='true') {
    let cookieContainer = document.createElement("div");
    cookieContainer.setAttribute("id", "cookieContainer");
    cookieContainer.style.background = "#faedcd";
    cookieContainer.style.width='100%';
    cookieContainer.style.position="fixed";
    cookieContainer.style.bottom="0px";

    let cookieText = document.createElement("p");
    cookieText.setAttribute("id", "cookieText");
    cookieText.innerText="Auf unserer Internetseite werden Cookies verwendet. Einige davon werden zwingend benötigt, während andere es uns ermöglichen, Ihre Nutzerinnen- und Nutzererfahrung auf unserer Internetseite zu verbessern."

    let breakC=document.createElement("br");

    let cookieAcceptButton= document.createElement("button");
    cookieAcceptButton.innerText="Akzeptieren";
    cookieAcceptButton.onclick= function (){
      setCookie('cookiesAccepted','true',10000);
      cookieContainer.style.display="none";
    };

    cookieContainer.appendChild(cookieText);
    cookieContainer.appendChild(breakC);
    cookieContainer.appendChild(cookieAcceptButton);

    document.body.appendChild(cookieContainer);


}
