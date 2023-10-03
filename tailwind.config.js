/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
  theme: {
    extend: {
      fontFamily: {
        poppins: ["Poppins", "sans-serif"],
      },
      colors: {
        white: {
          DEFAULT: "#FFF8D6",
          hover: "#E5DFC1",
        },
        beige: {
          DEFAULT: "#F7E1AE",
          hover: "#DECA9C",
        },
        mint: {
          DEFAULT: "#A4D0A4",
          hover: "#91B891",
        },
        teal: {
          DEFAULT: "#617A55",
          hover: "#4D6144",
        },
      },
    },
  },
  plugins: [],
};
