/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  
  theme: {
    extend: {
      colors: {

        accent: '#F50761',
        "accent-2": '#F50761',
        bg: '#f7f7f7'
      }
    },
  },
  plugins: [],
}

