/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'grafite': '#2b2b2b',
        'roxo': '#570475',
        'branco': '#FFFFFF',
        'cinza': {
          DEFAULT: '#CFCFCF',
          '300': '#CFCFCF',
          '700': '#374151',
          '900': '#111827',
        },
      },
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
