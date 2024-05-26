"use strict";
/*function createNavigation(eintraegeMap){
    let unlist= document.createElement('ul');

    for(var [key,value] of eintraegeMap){
        let line = document.createElement('li');
        let link = document.createElement('a');

        if(value instanceof Array){
            link.setAttribute("href",value[0]);
            debugger;
            link.innerText=key;
            line.appendChild(link);
            line.appendChild(createNavigation(value[1]));
        }else{
            link.setAttribute("href",value);
            link.innerText=key;
            line.appendChild(link);
        }
        unlist.appendChild(line);
    }
    return unlist;
}

let eintraege= new Map();
eintraege.set('Home','/home');
eintraege.set('Kategorien','/categories');
eintraege.set('Verkaufen','/sell');

let unternehmenEintraege=new Map;
unternehmenEintraege.set('Philosophie','/philosophy');
unternehmenEintraege.set('Karriere','/career')

eintraege.set('Unternehmen',["/unternehmen",unternehmenEintraege]);



document.body.getElementsByTagName("nav")[0].appendChild(createNavigation(eintraege))
*/
const navListElements = [
    {
        name: "Home",
        subitems: [],
        ref: "/home"
    },
    {
        name:"Kategorien",
        subitems:[],
        ref: "/categories"
    },
    {
        name:"Verkaufen",
        subitems: [],
        ref: "/sell"
    },
    {
        name:"Unternehmen",
        subitems:[
            {
                name:"Philosophie",
                subitems:[],
                ref:"/philosophy"
            },
            {
                name: "Karriere",
                subitems: [],
                ref:"/career"
            }
        ],
        ref: "/company"
    }
];

class navbar
{
    constructor(obj) {
        this.obj = obj;
    }

    create()
    {
        //debugger;
        let outerUl = document.createElement('ul')
        outerUl.setAttribute("id", "navlist");
        for (let i = 0; i < this.obj.length; i++)
        {
            let listNode = document.createElement('li');
            let ref = this.obj[i].ref;
            let link = document.createElement("a");
            link.innerText=this.obj[i].name;
            link.setAttribute("href",ref);
            listNode.appendChild(link);

            outerUl.appendChild(listNode);
            if(this.obj[i].subitems != null && this.obj[i].subitems.length !== 0)
            {
                let innerUl = document.createElement('ul');
                let innerList = this.obj[i].subitems;
                for (let j = 0; j < innerList.length; j++)
                {
                    let innerListElement = innerList[j].name;
                    let innerListNode = document.createElement('li');
                    let ref = this.obj[i].subitems[j].ref;
                    let link = document.createElement("a");
                    link.innerText=innerListElement;
                    link.setAttribute("href",ref);
                    innerListNode.appendChild(link);
                    innerUl.appendChild(innerListNode);
                }
                listNode.appendChild(innerUl);
            }
        }
        document.getElementById("navmenu").appendChild(outerUl);

    }

}
let nav = new navbar(navListElements);
nav.create();


