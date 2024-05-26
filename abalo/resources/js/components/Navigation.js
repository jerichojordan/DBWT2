export default {
    name:"Navigation",
    template: `
        <nav id="navmenu">
            <ul>
            <li v-for="item in navListElements">
                <a :href="item.ref">{{ item.name }}</a>
                <ul v-if="item.subitems.length > 0">
                    <li v-for="subitem in item.subitems">
                        <a :href="subitem.ref">{{ subitem.name }}</a>
                    </li>
                </ul>
            </li>
            </ul>
        </nav>
    `
    ,
    data() {
        return {
            navListElements : [
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
            ]
        };
    }

}
