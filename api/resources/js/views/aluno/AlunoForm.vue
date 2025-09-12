<template>
  <div>
    <h1 class="text-2xl font-semibold mb-6">{{ isEditing ? 'Editar Aluno' : 'Novo Aluno' }}</h1>
    <div v-if="loading" class="text-center text-gray-500">Carregando...</div>
    <form v-else @submit.prevent="submitForm">
      <div class="bg-white shadow-md rounded-lg p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input
              type="text"
              v-model="form.name"
              id="name"
              class="block mt-1 w-full shadow-sm focus:border-purple-200 focus:ring-purple sm:text-sm"
              required
              
            />
          </div>
          <div>
            <label for="birth_date" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
            <input type="date" v-model="form.birth_date" id="birth_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm" required>
          </div>
          <div>
            <label for="objective" class="block text-sm font-medium text-gray-700">Objetivo Principal</label>
            <input type="text" v-model="form.objective" id="objective" placeholder="Ex: Hipertrofia, emagrecimento..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm" required>
          </div>
          <div>
            <label for="experience_level" class="block text-sm font-medium text-gray-700">Nível de Experiência</label>
            <select v-model="form.experience_level" id="experience_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm" required>
              <option>Iniciante</option>
              <option>Intermediário</option>
              <option>Avançado</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end mt-6">
          <router-link :to="{ name: 'alunos.index' }" class="bg-gray-100 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-4">
            Cancelar
          </router-link>
          <button type="submit" class="bg-purple-500 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded">
            Salvar
          </button>
        </div>
        
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import { notificationStore } from '../../store/notification';

export default {
  name: 'AlunoForm',
  props: {
    id: { type: String, default: null }
  },
  data() {
    return {
      loading: false,
      form: {
        name: '',
        birth_date: '',
        objective: '',
        experience_level: 'Iniciante',
        filial_id: 1, // Temporário, até termos o CRUD de filiais no front
      }
    };
  },
  computed: {
    isEditing() {
      return !!this.id;
    }
  },
  mounted() {
    if (this.isEditing) {
      this.fetchAluno();
    }
  },
  methods: {
    fetchAluno() {
      this.loading = true;
      axios.get(`/api/alunos/${this.id}`)
        .then(response => {
          this.form = response.data;
        })
        .catch(error => {
          console.error("Erro ao buscar o aluno:", error);
          notificationStore.show('Falha ao carregar dados do aluno.', 'error');
        })
        .finally(() => {
          this.loading = false;
        });
    },
    submitForm() {
      const method = this.isEditing ? 'put' : 'post';
      const url = this.isEditing ? `/api/alunos/${this.id}` : '/api/alunos';

      axios[method](url, this.form)
        .then(() => {
          notificationStore.show(
            `Aluno ${this.isEditing ? 'atualizado' : 'criado'} com sucesso!`
          );
          this.$router.push({ name: 'alunos.index' });
        })
        .catch(error => {
          console.error("Erro ao salvar o aluno:", error.response.data);
          notificationStore.show('Erro ao salvar o aluno. Verifique os campos.', 'error');
        });
    }
  }
}
</script>
