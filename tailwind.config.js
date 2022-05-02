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
                error: '#ff6961',
                success: '#4FA64F',
                warning: '#F8AA02',
                grey: {
                    100: '#EFEFEF',
                    200: '#c6c6c6',
                    300: '#575656'
                },
                red: {
                    200: '#BD1D1D'
                },
                orange: {
                    200: '#F8AA02'
                }
            },
            backgroundImage: {
                'login': "url('/images/bg1.jpg')",
                'banner-1': "url('/images/bg2.jpg')",
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