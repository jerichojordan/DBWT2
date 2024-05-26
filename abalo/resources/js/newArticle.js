"use strict";
import { createApp } from 'vue/dist/vue.esm-bundler';

let vm= createApp({
    data(){
        return{
            name: "",
            price: 0,
            description: ""
        };
    },
    methods: {
        createText: function (forVal, textVal) {
            let text = document.createElement("label");
            text.setAttribute("for", forVal);
            text.textContent = textVal;
            return text;
        },
        createInput: function (nameVal, idVal, vmodel) {
            let input = document.createElement("input");
            input.setAttribute("name", nameVal);
            input.setAttribute("id", idVal);
            input.setAttribute("required", "");
            input.setAttribute("v-model", vmodel);
            return input;
        },
        createForm: function () {
            let nameText = this.createText("name", "Name: ");
            let nameInput = this.createInput("name", "name", "name");

            let priceText = this.createText("price", "Price: ");
            let priceInput = this.createInput("price", "price", "price");

            let descriptionText = this.createText("description", "Beschreibung: ");
            let descriptionInput = document.createElement("textarea");
            descriptionInput.setAttribute("id", "description");
            descriptionInput.setAttribute("cols", "40");
            descriptionInput.setAttribute("rows", "10");
            descriptionInput.setAttribute("name", "description");
            descriptionInput.setAttribute("v-model", "description");

            let articleForm = document.getElementById("articleForm");

            articleForm.appendChild(nameText);
            articleForm.appendChild(document.createElement("br"));
            articleForm.appendChild(nameInput);
            articleForm.appendChild(document.createElement("br"));
            articleForm.appendChild(priceText);
            articleForm.appendChild(document.createElement("br"));
            articleForm.appendChild(priceInput);
            articleForm.appendChild(document.createElement("br"));
            articleForm.appendChild(descriptionText);
            articleForm.appendChild(document.createElement("br"));
            articleForm.appendChild(descriptionInput);
        },
        submitForm() {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("information").innerText = "Erfolgreich";
                }
            };
            xhr.onerror = function () {
                document.getElementById("information").innerText = "Fehler";
            };
            xhr.open('POST', '/api/articles');
            let formData = new FormData();
            formData.append("price", document.getElementById("price").value);
            formData.append("name", document.getElementById("name").value);
            formData.append("description", document.getElementById("description").value);

            xhr.send(formData);
        }
    },
    mounted(){
        this.createForm();
    },
    template:`
    <div id="articleForm"></div>
    <input type="button" v-on:click="submitForm" value="Speichern">
    <p id="information"></p>
    `
}).mount("#app");
