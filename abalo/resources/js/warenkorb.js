"use strict";



function updateButtonPlus(){
    let buttonsPlus =document.getElementsByClassName('inWarenkorb');

    for(let i = 0; i < buttonsPlus.length; i++) {
        let anchor = buttonsPlus[i];
        anchor.addEventListener('click',function (e){
            if(document.getElementById(anchor.getAttribute('value')+'Cart')==null) {
                addToCart(anchor.getAttribute('value'));
                e.preventDefault();
                let xhr = new XMLHttpRequest();
                xhr.open('POST','/api/shoppingcart');
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send("articleid="+anchor.getAttribute('value'));
            }
        });
    }
}


let cart= new Array();
for(var i in shoppingcartItems){
    cart.push(shoppingcartItems[i].ab_article_id);
}

function addToCart(id){
    updateCart();
}

function removeFromCart(id){
    let xhr = new XMLHttpRequest();
    xhr.open('DELETE','/api/shoppingcart/'+shoppingcartid+"/articles/"+id);
    xhr.send(null);
    updateCart();
}

function updateCart(){
    let allArticlestemp= vm.$data.shoppingcartArticles;
    let length= allArticlestemp.length;
    document.getElementById("warenkorb").innerHTML ="";
    for(let i =0; i< allArticlestemp.length;i++){
        let obj = allArticlestemp[i];
        let item = document.createElement('div');
        item.setAttribute('id', obj.id + 'Cart');
        let itemText = document.createElement("span");
        itemText.innerText = obj.id + "-" + obj.ab_name;
        let itemImage = document.createElement('img');
        itemImage.setAttribute("src",obj.picture);
        let itemRemove = document.createElement("button");
        itemRemove.setAttribute('type', 'button');
        itemRemove.innerText = '-';
        itemRemove.setAttribute('value', obj.id);

        itemRemove.onclick = function () {
            removeFromCart(obj.id);
        }

        item.appendChild(itemText);
        item.appendChild(itemImage);
        item.appendChild(itemRemove);
        document.getElementById("warenkorb").appendChild(item);
    }
}





