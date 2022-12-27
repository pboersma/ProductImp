import { createApp } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCircleQuestion } from '@fortawesome/free-regular-svg-icons';
import {
  faRotate, faTrash, faPenToSquare, faPlus,
} from '@fortawesome/free-solid-svg-icons';
import App from './App.vue';
import store from './store';
import './assets/tailwind.css';

library.add(faCircleQuestion, faRotate, faTrash, faPenToSquare, faPlus);

createApp(App).use(store).component('font-awesome-icon', FontAwesomeIcon).mount('#app');
// 50dbbd051f392257ccf81632285892cc536dba193ac407b1
