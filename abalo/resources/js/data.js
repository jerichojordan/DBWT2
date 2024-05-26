"use strict";
var data = {
    'produkte': [
        { name: 'Ritterburg', preis: 59.99, kategorie: 1, anzahl: 3 },
        { name: 'Gartenschlau 10m', preis: 6.50, kategorie: 2, anzahl: 5 },
        { name: 'Robomaster' ,preis: 199.99, kategorie: 1, anzahl: 2 },
        { name: 'Pool 250x400', preis: 250, kategorie: 2, anzahl: 8 },
        { name: 'Rasenmähroboter', preis: 380.95, kategorie: 2, anzahl: 4 },
        { name: 'Prinzessinnenschloss', preis: 59.99, kategorie: 1, anzahl: 5 }
    ],
    'kategorien': [
        { id: 1, name: 'Spielzeug' },
        { id: 2, name: 'Garten' }
    ]
};

function getMaxPreis(dat){
    let max= Number.MIN_SAFE_INTEGER;
    let name= null;
    for(const el of dat['produkte']){
        if(el['preis']>max){
            max=el['preis'];
            name=el['name'];
        }
    }
    return name;
}

function getMinPreisProdukt(data) {
    let MinPreisProduktName;
    let MinPreisProduktKategorie;
    let MinPreisProduktAnzahl;
    let MinPreis;
    for (let i = 0; i < data.produkte.length; i++) {
        if (data.produkte[i].preis < MinPreis || i == 0) {
            MinPreis = data.produkte[i].preis;
            MinPreisProduktName = data.produkte[i].name;
            MinPreisProduktKategorie = data.produkte[i].kategorie;
            MinPreisProduktAnzahl = data.produkte[i].anzahl;
        }
    }
    return {
        name: MinPreisProduktName,
        preis: MinPreis,
        kategorie: MinPreisProduktKategorie,
        anzahl: MinPreisProduktAnzahl

    };
}

function getPreisSum(dat){
    let sum=0;
    for(const el of dat['produkte']){
        sum+=el['preis'];
    }
    return sum;
}

function getGesamtWert(dat){
    let sum=0;
    for(const el of dat['produkte']){
        sum+=el['preis']*el['anzahl'];
    }
    return sum;
}

function getAnzahlProdukteOfKategorie(data,kategoriename)
{
    let KategorieID = 0;
    let Anzahl = 0;
    for(let i = 0;i<data.kategorien.length;i++){
        if(kategoriename == data.kategorien[i].name) KategorieID = data.kategorien[i].id;
    }

    for(let i = 0;i<data.produkte.length;i++)
    {
        if(data.produkte[i].kategorie == KategorieID)Anzahl++;
    }
    return Anzahl;
}



console.log("MaxPreis : "+getMaxPreis(data));
console.log(getMinPreisProdukt(data));
console.log("PreisSum : "+getPreisSum(data));
console.log("GesamtWert : "+ getGesamtWert(data));
console.log("Kategorie Spielzeug hat "+getAnzahlProdukteOfKategorie(data,"Spielzeug")+" Produkte");
console.log("Kategorie Garten hat "+ getAnzahlProdukteOfKategorie(data,"Garten")+ " Produkte");




