module.exports = {
    purge: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue"
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                primary: "#2384eb",
                secondary: "#7fccea",
                light: "#a7afca"
            }
        }
    },
    variants: {
        extend: {

        }
    },
    plugins: []
};
