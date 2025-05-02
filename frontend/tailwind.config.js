/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  
  theme: {
    extend: {
      keyframes: {
        shimmer: {
          '0%': { transform: 'translateX(-100%)' },
          '80%': { transform: 'translateX(100%)' },
          '90%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(100%)' },
        }
      },
      animation: {
        shimmer: 'shimmer 1.5s infinite linear '
      },
      colors: {

        accent: '#F50761',
        "accent-2": '#F50761',
        bg: '#f7f7f7'
      }
    },
  },
  plugins: [],
}

