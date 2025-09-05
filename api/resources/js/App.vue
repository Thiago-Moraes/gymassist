<template>
  <div>
    <Navbar />
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <router-view />
      </div>
    </main>
    <Notification />
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue';
import Notification from './components/Notification.vue';

export default {
  components: {
    Navbar,
    Notification
  }
}
</script>
