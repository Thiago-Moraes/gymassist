<template>
  <div>
    <h1 class="text-2xl font-semibold mb-6">{{ isEditing ? 'Editar Aluno' : 'Novo Aluno' }}</h1>
    <div v-if="loading" class="text-center text-cinza-500">Carregando...</div>
    <form v-else @submit.prevent="submitForm">
      <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Nome -->
          <div>
            <label for="name" class="block text-sm font-medium text-cinza-700">Nome</label>
            <input type="text" v-model="form.name" id="name" class="mt-1 block w-full rounded-md border-cinza-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm" required>
          </div>

          <!-- Data de Nascimento -->
          <div>
            <label for="birth_date" class="block text-sm font-medium text-cinza-700">Data de Nascimento</label>
            <input type="date" v-model="form.birth_date" id="birth_date" class="mt-1 block w-full rounded-md border-cinza-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm" required>
          </div>

          <!-- Objetivo -->
          <div>
            <label for="objective" class="block text-sm font-medium text-cinza-700">Objetivo Principal</label>
            <input type="text" v-model="form.objective" id="objective" placeholder="Ex: Hipertrofia, emagrecimento..." class="mt-1 block w-full rounded-md border-cinza-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm" required>
          </div>

          <!-- Nível de Experiência -->
          <div>
            <label for="experience_level" class="block text-sm font-medium text-cinza-700">Nível de Experiência</label>
            <select v-model="form.experience_level" id="experience_level" class="mt-1 block w-full rounded-md border-cinza-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm" required>
              <option>Iniciante</option>
              <option>Intermediário</option>
              <option>Avançado</option>
            </select>
          </div>

        </div>

        <!-- Botões -->
        <div class="flex justify-end mt-6">
          <router-link :to="{ name: 'alunos.index' }" class="bg-cinza-200 hover:bg-cinza-300 text-cinza-800 font-bold py-2 px-4 rounded mr-4">
            Cancelar
          </router-link>
          <button type="submit" class="bg-roxo hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
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
