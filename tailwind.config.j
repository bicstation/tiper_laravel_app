/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme'; // この行を追加

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            spacing: { // ここにカスタム値を定義
                '14': '3.5rem',  // 56px (ナビバーの高さ)
                '70': '17.5rem', // 280px (サイドバーの幅)
            },
            width: { // widthにも同じ値を定義しておくと便利
                '70': '17.5rem',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')], // require('@tailwindcss/forms') に変更
};