<template>
  <nav class="bg-gray-800 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <router-link :to="{ name: 'home' }" class="text-2xl font-bold text-purple-500">Gym<span class="text-white">Assistant</span></router-link>
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <router-link :to="{ name: 'alunos.index' }" class="text-gray-100 hover:bg-gray-700 hover:text-branco px-3 py-2 rounded-md text-sm font-medium" active-class="bg-purple-900 text-white">Alunos</router-link>
              <router-link :to="{ name: 'academias.index' }" class="text-gray-100 hover:bg-gray-700 hover:text-branco px-3 py-2 rounded-md text-sm font-medium" active-class="bg-purple-900 text-white">Academias</router-link>
              <router-link :to="{ name: 'fichas.create' }" class="text-gray-100 hover:bg-gray-700 hover:text-branco px-3 py-2 rounded-md text-sm font-medium" active-class="bg-purple-900 text-white">Fichas</router-link>
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
