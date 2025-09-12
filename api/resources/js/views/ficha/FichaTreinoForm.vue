<template>
  <div>
    <h1 class="text-2xl font-semibold mb-6">Gerador de Ficha de Treino</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
      <!-- Seletor de Aluno -->
      <div class="mb-6">
        <label for="aluno" class="block text-sm font-medium text-gray-700">Selecione o Aluno</label>
        <select id="aluno" v-model="selectedAlunoId" @change="loadAlunoData" class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-purple focus:ring-purple sm:text-sm">
          <option disabled value="">Por favor, selecione um aluno</option>
          <option v-for="aluno in alunos" :key="aluno.id" :value="aluno.id">
            {{ aluno.name }}
          </option>
        </select>
      </div>

      <!-- Formulário de Geração -->
      <div v-if="selectedAlunoId">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <div>
            <h3 class="font-semibold text-lg text-grafite mb-2">Informações do Aluno</h3>
            <p><span class="font-semibold">Objetivo:</span> {{ selectedAluno.objective }}</p>
            <p><span class="font-semibold">Nível:</span> {{ selectedAluno.experience_level }}</p>
            <p><span class="font-semibold">Condições de Saúde:</span> {{ selectedAluno.health_conditions || 'Nenhuma' }}</p>
          </div>
          <div>
            <h3 class="font-semibold text-lg text-grafite mb-2">Frequência de Treino</h3>
            <select v-model="frequencia" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple focus:ring-purple sm:text-sm">
              <option value="3x por semana">3x por semana</option>
              <option value="4x por semana">4x por semana</option>
              <option value="5x por semana">5x por semana</option>
              <option value="5x por semana">6x por semana</option>
            </select>
          </div>
        </div>

        <!-- Botão de Sugestão -->
        <div class="text-center">
          <button 
            @click="getSuggestion"
            :disabled="suggestionLoading" 
            class="bg-purple-600 hover:bg-purple-800 text-white font-bold py-3 px-6 rounded-lg text-lg shadow-lg transform hover:scale-105 transition-transform duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
            <span v-if="suggestionLoading">Gerando...</span>
            <span v-else>Sugerir Exercícios com IA</span>
          </button>
        </div>
      </div>

    </div>

    <!-- Área de Resultado da IA -->
    <div v-if="suggestion" class="mt-8 bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-semibold mb-4">Sugestão de Treino</h2>
      <WorkoutDisplay :workout-json="formattedSuggestion"/>
      <div class="flex justify-end mt-6">
          <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-4">Editar</button>
          <button class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">Salvar Ficha</button>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import WorkoutDisplay from "../../components/WorkoutDisplay.vue";

export default {
  name: 'FichaTreinoForm',
    components: {WorkoutDisplay},
  data() {
    return {
      alunos: [],
      selectedAlunoId: '',
      selectedAluno: null,
      loading: true,
      suggestionLoading: false,
      frequencia: '3x por semana',
      suggestion: ''
    };
  },
  computed: {
    formattedSuggestion() {
      return this.suggestion ? this.suggestion : '';
    }
  },
  mounted() {
    axios.get('/api/alunos')
      .then(response => {
        this.alunos = response.data;
      })
      .catch(error => console.error("Erro ao buscar alunos:", error))
      .finally(() => this.loading = false);
  },
  methods: {
    loadAlunoData() {
      if (this.selectedAlunoId) {
        this.selectedAluno = this.alunos.find(a => a.id === this.selectedAlunoId);
        this.suggestion = ''; // Limpa a sugestão anterior ao trocar de aluno
      }
    },
    getSuggestion() {
      if (!this.selectedAlunoId) return;

      this.suggestionLoading = true;
      this.suggestion = '';

      const dias = parseInt(this.frequencia.charAt(0));

      axios.post('/api/fichas/suggest', {
        aluno_id: this.selectedAlunoId,
        frequencia: this.frequencia,
        dias: dias
      })
      .then(response => {
        this.suggestion = response.data.suggestion;
      })
      .catch(error => {
        console.error("Erro ao obter sugestão:", error);
        alert("Houve um erro ao gerar a sugestão. Tente novamente.");
      })
      .finally(() => {
        this.suggestionLoading = false;
      });
    }
  }
}
</script>
