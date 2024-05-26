import './bootstrap';
import SiteHeader from './components/SiteHeader.js';
import SiteBody from './components/SiteBody.js';
import SiteFooter from './components/SiteFooter.js';
import Navigation from "./components/Navigation.js";
import { createApp } from 'vue/dist/vue.esm-bundler';
import VueScrollUp from "vue-scroll-up";


let connectionWS = new WebSocket('ws://localhost:8085/message');

connectionWS.onmessage= function (e){
    console.log('Received',e.data);
    alert(e.data);
};

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

const vm = createApp({
    components: {
        SiteHeader,SiteBody,SiteFooter,Navigation,VueScrollUp
    },data() {
        return {
            displayImpressum: false,
            page: 0,
            shoppingcartArticles:[],
            foundArticles:[],
            inputdata:""
        };
    },
    mounted(){
        this.fireSearch();
        this.getAllArticles();
        updateButtonPlus();
        console.log("Starting Connection to Websocket Server");
        let conn = new WebSocket('ws://localhost:8085/maintenance');

        conn.onmessage = function(e) {
            console.log('Received', e.data);
            alert(e.data);
        };
        /*this.connection = new WebSocket('ws://localhost:8085/maintenance');
        this.connection.onopen =  () => {
            console.log('Web Socket connected');
            alert('In Kürze verbessern wir Abalo für Sie! Nach einer kurzen Pause sind wir wieder für Sie da! Versprochen.');
            //this.connectedStatus = 'In Kürze verbessern wir Abalo für Sie! Nach einer kurzen Pause sind wir wieder für Sie da! Versprochen.';
        * */
    },
    updated(){
        this.getAllArticles();
        updateButtonPlus();
    },
    methods: {
        toggleImpressum() {
            this.displayImpressum = !this.displayImpressum;
        },
        fireSearch() {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let res = JSON.parse(this.responseText);
                    vm.$data.foundArticles = res.article;
                }
            };
            if (this.inputdata != null && this.inputdata.length > 2) {
                xhr.open("GET", "/api/articles?search=" + this.inputdata+"&page="+this.page);
            } else {
                xhr.open("GET", "/api/articles?search="+"&page="+this.page);
            }
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send();

        },
        getAllArticles(){
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let res = JSON.parse(this.responseText);
                    vm.$data.shoppingcartArticles = res.shoppingcart;
                }
            };
            xhr.open("GET", "/api/shoppingcart");
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send();
        },
        previouspage() {
            if (this.page > 0) {
                this.page--;
                this.fireSearch();
            }
        },
        nextpage() {
            this.page++;
            this.fireSearch();
        },
        resetPage() {
            this.page = 0;
        },
        inputhandle(value)
        {
            this.inputdata=value;
        }
    }
}).mount('#app');

