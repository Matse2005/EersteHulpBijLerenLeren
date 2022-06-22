module.exports = {
  content: ["./**/*.html", "./**/*.php"],
  themeVariants: ["dark"],
  theme: {
    colors: {
      secondary: "#F4F2ED",
      black: "black",
      white: "white",
      red: {
        100: "#fff5f5",
        200: "#fed7d7",
        300: "#feb2b2",
        400: "#fc8181",
        500: "#f56565",
        600: "#e53e3e",
        700: "#c53030",
        800: "#9b2c2c",
        900: "#742a2a",
      },
    },
    fontFamily: {
      "pt-serif": ["PT Serif", "serif"],
      "source-code-pro": ["Source Code Pro", "monospace"],
    },
    backgroundSize: {
      auto: "auto",
      cover: "cover",
      contain: "contain",
      "100%": "100%",
    },
    extend: {
      backgroundImage: {
        underline1: "url('/assets/img/template/Underline1.svg')",
        underline2: "url('/assets/img/template/Underline2.svg')",
        underline3: "url('/assets/img/template/Underline3.svg')",
        underline4: "url('/assets/img/template/Underline4.svg')",
        highlight3: "url('/assets/img/template/Highlight3.svg')",
      },
      keyframes: {
        "fade-in-down": {
          "0%": {
            opacity: "0",
            transform: "translateY(-10px)",
          },
          "100%": {
            opacity: "1",
            transform: "translateY(0)",
          },
        },
      },
      animation: {
        "fade-in-down": "fade-in-down 0.5s ease-out",
      },
    },
    extend: {},
  },
  plugins: [],
};
