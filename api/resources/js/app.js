import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Importa o roteador
import WorkoutDisplay from './components/WorkoutDisplay.vue'; // Importa o novo componente

const app = createApp(App);

app.use(router); // Registra o roteador na aplicação

// Registra o componente WorkoutDisplay globalmente
app.component('WorkoutDisplay', WorkoutDisplay);

app.mount('#app');
