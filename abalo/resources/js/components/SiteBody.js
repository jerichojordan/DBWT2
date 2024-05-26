import Impressum from "./Impressum.js";
import axios from "axios";
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
export default {
    props:['display-impressum','fire-search','page','found-articles','inputdata','previous-page','next-page','reset-page','abalo-id'],
    components: {Impressum},
    data(){
        return{
            currentInput: this.inputdata,
            userid : this.abaloId,
            articleoffer:[],
            old:this.foundArticles
        }
    },
    methods:{
        inputUpdate(){
            let newInput = this.currentInput;
            this.$emit('input-update',newInput);
        },
        angebotButton(id,name){
            if(!this.articleoffer.includes(id)) {
                this.articleoffer.push(id);
                axios.post('/api/angebot', { offer: this.articleoffer }, { withCredentials: true})
                    .then(response => {
                        //console.log("Angebot "+name+" wird geaddet");
                        let arrayoffer = response.data.articleoffer;
                        this.angebotOffered();
                        //console.log(arrayoffer);

                    })
                    .catch(error => {

                    });
            }

        },
        angebotOffered(){
            axios.get('/api/angebot',{
                withCredentials: true
            })
                .then(response => {
                    let arrayoffer = response.data.getoffer;
                    //console.log(arrayoffer);
                        this.foundArticles.forEach(article => {
                            if (arrayoffer.includes(article.id)) {
                                this.articleoffer = arrayoffer;
                                let offeredname = article.ab_name;
                                const message = `Der Artikel ${offeredname} wird nun günstiger angeboten! Greifen Sie schnell zu.`;
                                alert(message);
                                //console.log(message);

                            }
                        })
                })
                .catch(error => {
                    console.error('Error checking if article is offered:', error);
                });

        }
    },
    updated(){
        if(this.foundArticles !== this.old) {
            this.angebotOffered();
            //console.log(this.foundArticles);
            this.old = this.foundArticles;
        }
    },
    template:
        `
            <div>
            <Impressum v-if="displayImpressum"></Impressum>
            <div v-else>
                <input @input="inputUpdate();resetPage();fireSearch();" type="text" v-model="this.currentInput"
                       id="search"/>
                <table class="main__articleList">
                    <thead>
                    <tr>
                        <td class="header__id">id</td>
                        <td class="header__name">ab_name</td>
                        <td class="header__price">ab_price</td>
                        <td class="header__description">ab_description</td>
                        <td class="header__creator">ab_creator_id</td>
                        <td class="header__createDate">ab_createdate</td>
                    </tr>
                    </thead>
                    <tbody class="articleList__content">
                    <template v-for="article in foundArticles" :key="article.id">
                        <tr class="content__article">
                            <td :id="'articleId'+article.id" class="article__id">{{ article.id }}</td>
                            <td :id="'articleName'+article.id" class="article__name"><a v-if="this.articleoffer.includes(article.id)" class="highlighted">{{ article.ab_name }}</a><a v-else> {{article.ab_name}}</a></td>
                            <td :id="'articlePrice'+article.id" class="article__price">{{ article.ab_price }}</td>
                            <td :id="'articleDescription'+article.id" class="article__description">
                                {{ article.ab_description }}
                            </td>
                            <td :id="'articleCreatorId'+article.id" class="article__creatorId">
                                {{ article.ab_creator_id }}
                            </td>
                            <td :id="'articleCreateDate'+article.id" class="article__createDate">
                                {{ article.ab_createdate }}
                            </td>
                            <td :id="'articleImage'+article.id" class="article__image"><img :src="article.picture"></td>
                            <td class="article__buttonholder">
                                <button type="button" class="inWarenkorb" :value="article.id">+</button>
                            </td>
                            <td v-if="article.ab_creator_id  === userid">
                                <button type="button" id="angebot" @click="angebotButton(article.id, article.ab_name)">Artikel jetzt als
                                    Angebot anbieten
                                </button>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
                <span class="main__buttons">
                   <button @click="previousPage">&lt</button>
                   <button @click="nextPage">&gt</button>
               </span>
            </div>
            </div>

        `
}
