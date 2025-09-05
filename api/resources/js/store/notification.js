import { reactive } from 'vue';

export const notificationStore = reactive({
  message: '',
  type: 'success', // 'success' or 'error'
  visible: false,

  show(message, type = 'success') {
    this.message = message;
    this.type = type;
    this.visible = true;

    setTimeout(() => {
      this.hide();
    }, 3000);
  },

  hide() {
    this.visible = false;
  }
});
