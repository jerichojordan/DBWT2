<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="/css/articles.css">
    <script src="https://unpkg.com/vue@3"></script>
    @vite(['resources/css/articles.scss'])
</head>
<body>
<script>
    var shoppingcartid = {{$_SESSION['abalo_shoppingcartid']}};
    var shoppingcartItems= {!!json_encode(\App\Models\shoppingcart::getShoppingcartItems($_SESSION['abalo_shoppingcartid']))!!} ;
</script>
<span id="app">
<nav id="navmenu"></nav>
<main class="body__main">
    <div id="warenkorb" class="main_warenkorb">
    </div>
    <form method="get" action="">
        <input @input="fireSearch" type="text" v-model="inputdata" id="search"/>
    </form>
    @if(isset($insertError)&&$insertError==true)
        Beim Einfügen des Neuen Artikels ist ein Fehler unterlaufen. Versuchen Sie es erneut.
    @endif
    <table class="main__articleList">
        <thead class="articleList__header">
        <tr>
            <td class="header_id">id</td>
            <td class="header_name">ab_name</td>
            <td class="header_price">ab_price</td>
            <td class="header_description">ab_description</td>
            <td class="header_creator">ab_creator_id</td>
            <td class="header_createDate">ab_createdate</td>
        </tr>
        </thead>
        <tbody class="articleList__content">
        <template v-for="article in foundArticles.slice(0,5)" :key="article.id">
            <tr class="content__article">
                <td :id="'articleId'+article.id" class="article__id">@{{article.id}}</td>
                <td :id="'articleName'+article.id" class="article__name">@{{article.ab_name}}</td>
                <td :id="'articlePrice'+article.id" class="article__price">@{{article.ab_price}}</td>
                <td :id="'articleDescription'+article.id" class="article__description">@{{article.description}}</td>
                <td :id="'articleCreatorId'+article.id" class="article__creatorId">@{{article.ab_creator_id}}</td>
                <td :id="'articleCreateDate'+article.id" class="article__createDate">@{{article.ab_createdate}}</td>
                <td :id="'articleImage'+article.id" class="article__image"><img :src="article.picture"></td>
                <td class="article__buttonholder"><button type="button" class="inWarenkorb" :value="article.id">+</button></td>
            </tr>
        </template>
        </tbody>
    </table>

</main>
</span>

<script src="{{ asset('/js/Navigation.js') }}"></script>
<script src="{{ asset('/js/cookiecheck.js') }}"></script>
<script src="{{ asset('/js/warenkorb.js') }}"></script>
<script>
    let appdata={}
    let vm =Vue.createApp({
        data(){
            return{
                shoppingcartArticles:[],
                foundArticles:[],
                inputdata:""
            };
        },
        mounted(){
            this.fireSearch();
            this.getAllArticles();
            updateButtonPlus();
        },
        updated(){
            updateCart();
            updateButtonPlus();
            this.getAllArticles();
        },
        methods: {
            fireSearch() {
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let res = JSON.parse(this.responseText);
                        vm.$data.foundArticles = res.article;
                    }
                };
                if (this.inputdata != null && this.inputdata.length > 2) {
                    xhr.open("GET", "/api/articles?search=" + this.inputdata);
                } else {
                    xhr.open("GET", "/api/articles?search=");
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
            }
        }
    }).mount('#app');
</script>
</body>



