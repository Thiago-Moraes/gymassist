<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold">Lista de Alunos</h1>
      <router-link v-if="!loading && alunos.length > 0" :to="{ name: 'alunos.create' }" class="bg-roxo hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
        Novo Aluno
      </router-link>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="text-center py-10">
        <p class="text-cinza-500">Carregando...</p>
    </div>

    <!-- Empty State -->
    <div v-else-if="alunos.length === 0" class="text-center bg-white shadow-md rounded-lg p-12">
        <svg class="mx-auto h-12 w-12 text-cinza-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-cinza-900">Nenhum aluno cadastrado</h3>
        <p class="mt-1 text-sm text-cinza-500">Que tal adicionar o primeiro?</p>
        <div class="mt-6">
            <router-link :to="{ name: 'alunos.create' }" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-roxo hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-roxo">
                Novo Aluno
            </router-link>
        </div>
    </div>

    <!-- Data Table -->
    <div v-else class="bg-branco shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full leading-normal">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b-2 border-cinza-200 bg-cinza-100 text-left text-xs font-semibold text-cinza-600 uppercase tracking-wider">Nome</th>
            <th class="px-5 py-3 border-b-2 border-cinza-200 bg-cinza-100 text-left text-xs font-semibold text-cinza-600 uppercase tracking-wider">Objetivo</th>
            <th class="px-5 py-3 border-b-2 border-cinza-200 bg-cinza-100 text-left text-xs font-semibold text-cinza-600 uppercase tracking-wider">Nível</th>
            <th class="px-5 py-3 border-b-2 border-cinza-200 bg-cinza-100"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="aluno in alunos" :key="aluno.id">
            <td class="px-5 py-5 border-b border-cinza-200 bg-white text-sm"><p class="text-cinza-900 whitespace-no-wrap">{{ aluno.name }}</p></td>
            <td class="px-5 py-5 border-b border-cinza-200 bg-white text-sm"><p class="text-cinza-900 whitespace-no-wrap">{{ aluno.objective }}</p></td>
            <td class="px-5 py-5 border-b border-cinza-200 bg-white text-sm">
              <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                <span class="relative">{{ aluno.experience_level }}</span>
              </span>
            </td>
            <td class="px-5 py-5 border-b border-cinza-200 bg-white text-sm text-right">
              <router-link :to="{ name: 'alunos.edit', params: { id: aluno.id } }" class="text-roxo hover:text-purple-700 font-semibold">Editar</router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AlunoIndex',
  data() {
    return {
      alunos: [],
      loading: true,
    };
  },
  mounted() {
    this.fetchAlunos();
  },
  methods: {
    fetchAlunos() {
      this.loading = true;
      axios.get('/api/alunos')
        .then(response => {
          this.alunos = response.data;
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os alunos:", error);
        })
        .finally(() => {
          this.loading = false;
        });
    }
  }
}
</script>
