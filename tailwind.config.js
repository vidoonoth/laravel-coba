export default {
    presets: [preset],
    content: [
        './resources/views/**/*.blade.php',
    ],

        theme: {
          extend: {
            animation: {
              'fade-out': 'fadeOut 10s ease-out forwards', // Durasi 3 detik untuk animasi menghilang
            },
            keyframes: {
              fadeOut: {
                '0%': { opacity: '1', transform: 'translateY(0)' },
                '100%': { opacity: '0', transform: 'translateY(-100px)' }, // Menggeser ke atas dan memudar
              },
            },
          },
        },


}

// tailwind.config.js

