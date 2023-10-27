let routes= [];
let routes_list= [];

import List from '../pages/practices/List.vue'
import Form from '../pages/practices/Form.vue'
import Item from '../pages/practices/Item.vue'

routes_list = {

    path: '/practices',
    name: 'practices.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'practices.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'practices.view',
            component: Item,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;

