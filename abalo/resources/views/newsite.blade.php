<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    @vite(['resources/css/articles.scss'])
    @vite('resources/js/app.js')
    @vite('resources/js/cookiecheck.js')
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<script>
    //var shoppingcartid = {{$_SESSION['abalo_shoppingcartid']}};
    //var shoppingcartItems= {!!json_encode(\App\Models\shoppingcart::getShoppingcartItems($_SESSION['abalo_shoppingcartid']))!!};
</script>
<div :inputdata="inputdata" @input-update="inputdata = $event" id="app">
    <site-header></site-header>
    <main class="body__main">
    <site-body :display-impressum="displayImpressum" :get-all-articles="getAllArticles" :fire-search="fireSearch"
               :inputdata="inputdata" :page="page" :found-articles="foundArticles" :previous-page="previouspage" :next-page="nextpage"
               :reset-page="resetPage" @input-update="inputhandle" :abalo-id={{ session('abalo_id', '') }} ></site-body>
    </main>
    <site-footer @toggle-impressum="toggleImpressum"></site-footer>
    <vue-scroll-up
        tag="div"
        custom-class="vue-scroll-up"
        :scroll-duration="1000"
        :scroll-y="250"
        :always-show="false">
        ^
    </vue-scroll-up>
</div>

</body>
</html>
