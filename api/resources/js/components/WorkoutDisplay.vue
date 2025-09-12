<template>
  <div class="workout-display p-4">
    <h2 class="text-2xl font-bold mb-4 text-roxo">Fichas de Treino Geradas</h2>

    <div v-if="Object.keys(parsedWorkouts).length === 0" class="text-gray-600">
      Nenhuma ficha de treino disponível.
    </div>

    <div v-for="(workoutSheet, sheetName) in parsedWorkouts" :key="sheetName" class="mb-8 p-6 bg-white rounded-lg shadow-md">
      <h3 class="text-xl font-semibold mb-4 text-grafite">{{ sheetName }}</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
          <thead class="bg-gray-100">
            <tr>
              <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-700">Exercício</th>
              <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-700">Séries</th>
              <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-700">Repetições</th>
              <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-700">Observações</th>
              <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-700">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in workoutSheet" :key="index" class="hover:bg-gray-50">
              <td class="py-3 px-4 border-b text-sm text-gray-800">{{ item.exercise }}</td>
              <td class="py-3 px-4 border-b text-sm text-gray-800">{{ item.sets }}</td>
              <td class="py-3 px-4 border-b text-sm text-gray-800">{{ item.repetitions }}</td>
              <td class="py-3 px-4 border-b text-sm text-gray-800">{{ item.Obs }}</td>
              <td class="py-3 px-4 border-b text-sm text-gray-800">
                <button @click="removeExercise(sheetName, index)" class="text-red-600 hover:text-red-800 font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                  Remover
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="add-exercise-form mt-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
        <h4 class="text-lg font-semibold mb-3 text-grafite">Adicionar Novo Exercício a {{ sheetName }}</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="newExerciseName" class="block text-sm font-medium text-gray-700">Nome do Exercício</label>
            <input type="text" v-model="newExercise.exercise" id="newExerciseName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm p-2" placeholder="Ex: Agachamento" />
          </div>
          <div>
            <label for="newExerciseSets" class="block text-sm font-medium text-gray-700">Séries</label>
            <input type="text" v-model="newExercise.sets" id="newExerciseSets" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm p-2" placeholder="Ex: 3" />
          </div>
          <div>
            <label for="newExerciseReps" class="block text-sm font-medium text-gray-700">Repetições</label>
            <input type="text" v-model="newExercise.repetitions" id="newExerciseReps" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm p-2" placeholder="Ex: 8-12" />
          </div>
          <div>
            <label for="newExerciseObs" class="block text-sm font-medium text-gray-700">Observações</label>
            <input type="text" v-model="newExercise.Obs" id="newExerciseObs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-roxo focus:ring-roxo sm:text-sm p-2" placeholder="Ex: Carga progressiva" />
          </div>
        </div>
        <button @click="addExercise(sheetName)" class="mt-4 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-roxo hover:bg-roxo-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-roxo">
          Adicionar Exercício
        </button>
      </div>
    </div>

    <div v-if="Object.keys(parsedWorkouts).length > 0" class="mt-8 text-center">
      <button @click="saveWorkouts" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-grafite hover:bg-roxo focus:outline-none focus:ring-2 focus::ring-offset-2 focus:ring-grafite">
        Salvar Ficha(s)
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'; // Import axios

export default {
  props: {
    workoutJson: {
      type: String,
      required: true,
    },
    alunoId: { // New prop for aluno_id
      type: Number,
      required: true,
    }
  },
  data() {
    return {
      parsedWorkouts: {},
      newExercise: {
        exercise: '',
        sets: '',
        repetitions: '',
        Obs: '',
      },
    };
  },
  watch: {
    workoutJson: {
      immediate: true,
      handler(newVal) {
        this.parseWorkoutData(newVal);
      },
    },
  },
  methods: {
    parseWorkoutData(jsonString) {
      try {
        this.parsedWorkouts = jsonString;
      } catch (e) {
        console.error("Erro ao parsear JSON da ficha de treino:", e);
        this.parsedWorkouts = {};
      }
    },
    removeExercise(sheetName, index) {
      if (this.parsedWorkouts[sheetName]) {
        this.parsedWorkouts[sheetName].splice(index, 1);
        if (this.parsedWorkouts[sheetName].length === 0) {
          delete this.parsedWorkouts[sheetName];
        }
      }
    },
    addExercise(sheetName) {
      if (!this.newExercise.exercise.trim()) {
        alert("O nome do exercício não pode ser vazio.");
        return;
      }

      if (this.parsedWorkouts[sheetName]) {
        this.parsedWorkouts[sheetName].push({ ...this.newExercise });
        this.newExercise = {
          exercise: '',
          sets: '',
          repetitions: '',
          Obs: '',
        };
      } else {
        alert("Erro: Ficha de treino não encontrada para adicionar o exercício.");
      }
    },
    async saveWorkouts() {
      if (Object.keys(this.parsedWorkouts).length === 0) {
        alert("Não há fichas de treino para salvar.");
        return;
      }

      const formattedFichas = Object.keys(this.parsedWorkouts).map(sheetName => {
        return {
          name: sheetName,
          exercicios: this.parsedWorkouts[sheetName].map(exercise => ({
            exercise: exercise.exercise,
            sets: exercise.sets,
            repetitions: exercise.repetitions,
            Obs: exercise.Obs, // Ensure 'Obs' matches backend's 'observations'
          }))
        };
      });

      try {
        const response = await axios.post('/api/fichas-treino', {
          aluno_id: this.alunoId,
          fichas: formattedFichas,
        });
        alert(response.data.message);
      } catch (error) {
        console.error("Erro ao salvar fichas de treino:", error.response || error);
        alert("Erro ao salvar fichas de treino: " + (error.response?.data?.message || error.message));
      }
    }
  },
};
</script>

<style scoped>
/* Estilos específicos do componente, se necessário */
</style>
