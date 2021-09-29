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
                light: "#a7afca",
                dark: '#666666',
                error: '#ff6961',
                success: '#4FA64F',
                grey: {
                    100: '#EFEFEF',
                    200: '#c6c6c6',
                    300: '#575656'
                },
                red: {
                    200: '#bd1d1d'
                },
                orange: {
                    200: '#f8aa00'
                }
            }
        }
    },
    variants: {
        extend: {
            opacity: ['disabled'],
        }
    },
    plugins: []
};
