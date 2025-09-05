import { createRouter, createWebHistory } from 'vue-router';

import AlunoIndex from '../views/aluno/AlunoIndex.vue';
import AlunoForm from '../views/aluno/AlunoForm.vue';
import FichaTreinoForm from '../views/ficha/FichaTreinoForm.vue';
import AcademiaIndex from '../views/academia/AcademiaIndex.vue';

const Home = { template: '<div><h2>Página Inicial</h2><p>Bem-vindo ao assistente de criação de fichas de academia!</p></div>' };

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  // Alunos
  {
    path: '/alunos',
    name: 'alunos.index',
    component: AlunoIndex
  },
  {
    path: '/alunos/create',
    name: 'alunos.create',
    component: AlunoForm
  },
  {
    path: '/alunos/:id/edit',
    name: 'alunos.edit',
    component: AlunoForm,
    props: true
  },
  // Fichas
  {
    path: '/fichas/create',
    name: 'fichas.create',
    component: FichaTreinoForm
  },
  // Academias
  {
    path: '/academias',
    name: 'academias.index',
    component: AcademiaIndex
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
