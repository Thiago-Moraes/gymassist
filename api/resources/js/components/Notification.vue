<template>
  <div
    v-if="notification.visible"
    :class="[
      'fixed top-5 right-5 w-full max-w-sm p-4 rounded-lg shadow-lg text-white',
      notification.type === 'success' ? 'bg-green-500' : 'bg-red-500'
    ]"
    role="alert">
    <div class="flex items-center justify-between">
      <span>{{ notification.message }}</span>
      <button @click="notification.hide()" class="text-xl font-bold">&times;</button>
    </div>
  </div>
</template>

<script>
import { notificationStore } from '../store/notification';

export default {
  name: 'Notification',
  setup() {
    return {
      notification: notificationStore
    };
  }
}
</script>
