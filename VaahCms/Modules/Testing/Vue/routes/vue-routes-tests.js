let routes= [];
let routes_list= [];

import List from '../pages/tests/List.vue'
import Form from '../pages/tests/Form.vue'
import Item from '../pages/tests/Item.vue'
import PracticeCrud from '../pages/tests/PracticeCrudData.vue'

routes_list = {

    path: '/tests',
    name: 'tests.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'tests.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'tests.view',
            component: Item,
            props: true,
        },
        {
            path: 'practice/:id?',
            name: 'practice.crud',
            component: PracticeCrud,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;

