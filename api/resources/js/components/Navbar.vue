<template>
  <nav class="grafite shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <router-link :to="{ name: 'home' }" class="text-2xl font-bold text-roxo">Gym<span class="text-branco">Assistant</span></router-link>
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <router-link :to="{ name: 'alunos.index' }" class="text-cinza-300 hover:bg-cinza-700 hover:text-branco px-3 py-2 rounded-md text-sm font-medium" active-class="bg-cinza-900 text-branco">Alunos</router-link>
              <router-link :to="{ name: 'academias.index' }" class="text-cinza-300 hover:bg-cinza-700 hover:text-branco px-3 py-2 rounded-md text-sm font-medium" active-class="bg-cinza-900 text-branco">Academias</router-link>
              <router-link :to="{ name: 'fichas.create' }" class="text-cinza-300 hover:bg-cinza-700 hover:text-branco px-3 py-2 rounded-md text-sm font-medium" active-class="bg-cinza-900 text-branco">Fichas</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navbar'
}
</script>
