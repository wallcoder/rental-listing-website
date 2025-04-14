/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  
  theme: {
    extend: {
      colors: {

        accent: '#57b360',
        "accent-2": '#d30303',
        bg: '#f7f7f7'
      }
    },
  },
  plugins: [],
}

