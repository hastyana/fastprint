/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundColor: ['active'],
      screens: {
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1440px',
        '3xl': '1536px',
        '4xl': '1920px'
      },
      fontFamily: {
        signika: "'Signika', sans-serif",
        roboto: "'Roboto', sans-serif",
      },
      colors: {
        'black-1E1E1E': '#1E1E1E',
        'orange-FFAF61': '#FFAF61'
      }
    },
  },
  plugins: [],
}
