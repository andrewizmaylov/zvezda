import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import aspectratio from '@tailwindcss/aspect-ratio';


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
                play: ['Play', ...defaultTheme.fontFamily.sans],
            },
            gridColumn: {
                auto: 'auto',
                'span-1': 'span 1 / span 1',
                'span-2': 'span 2 / span 2',
                'span-3': 'span 3 / span 3',
                'span-4': 'span 4 / span 4',
                'span-5': 'span 5 / span 5',
                'span-6': 'span 6 / span 6',
                'span-7': 'span 7 / span 7',
                'span-8': 'span 8 / span 8',
                'span-9': 'span 9 / span 9',
                'span-10': 'span 10 / span 10',
                'span-11': 'span 11 / span 11',
                'span-12': 'span 12 / span 12',
                'span-13': 'span 13 / span 13',
                'span-14': 'span 14 / span 14',
                'span-15': 'span 15 / span 15',
                'span-16': 'span 16 / span 16',
            },
            gridTemplateColumns: {
                '1': 'repeat(1, minmax(0, 1fr))',
                '2': 'repeat(2, minmax(0, 1fr))',
                '3': 'repeat(3, minmax(0, 1fr))',
                '4': 'repeat(4, minmax(0, 1fr))',
                '5': 'repeat(5, minmax(0, 1fr))',
                '6': 'repeat(6, minmax(0, 1fr))',
                '7': 'repeat(7, minmax(0, 1fr))',
                '8': 'repeat(8, minmax(0, 1fr))',
                '9': 'repeat(9, minmax(0, 1fr))',
                '10': 'repeat(10, minmax(0, 1fr))',
                '11': 'repeat(11, minmax(0, 1fr))',
                '12': 'repeat(12, minmax(0, 1fr))',
                '13': 'repeat(13, minmax(0, 1fr))',
                '14': 'repeat(14, minmax(0, 1fr))',
                '15': 'repeat(15, minmax(0, 1fr))',
                '16': 'repeat(16, minmax(0, 1fr))',
            },
            gridTemplateRows: {
                '1': 'repeat(1, minmax(0, 1fr))',
                '2': 'repeat(2, minmax(0, 1fr))',
                '3': 'repeat(3, minmax(0, 1fr))',
                '4': 'repeat(4, minmax(0, 1fr))',
                '5': 'repeat(5, minmax(0, 1fr))',
                '6': 'repeat(6, minmax(0, 1fr))',
                '7': 'repeat(7, minmax(0, 1fr))',
                '8': 'repeat(8, minmax(0, 1fr))',
                '9': 'repeat(9, minmax(0, 1fr))',
                '10': 'repeat(10, minmax(0, 1fr))',
                '11': 'repeat(11, minmax(0, 1fr))',
                '12': 'repeat(12, minmax(0, 1fr))',
                '13': 'repeat(13, minmax(0, 1fr))',
                '14': 'repeat(14, minmax(0, 1fr))',
                '15': 'repeat(15, minmax(0, 1fr))',
                '16': 'repeat(16, minmax(0, 1fr))',
            },
            boxShadow: {
                little: '0px 4px 8px rgba(56, 50, 71, 0.08)',
                element: '0px 16px 56px rgba(44, 39, 56, 0.08)',
                tag: '0px 1px 2px rgba(56, 50, 71, 0.01), 0px 2px 4px rgba(56, 50, 71, 0.08)',
            },
        },
    },
    corePlugins: {
        aspectRatio: false,
    },
    plugins: [forms, typography, aspectratio,
        
        function ({ addUtilities }) {
            addUtilities({
                '.text_34': {
                    '@apply lg:text-[34px] md:text-[30px] sm:text-[26px] text-[21px]': {},
                },
                '.text_32': {
                    '@apply lg:text-[32px] md:text-[28px] sm:text-[24px] text-[21px] lg:leading-[1.3] md:leading-[1.2] sm:leading-[1.1] leading-[1]': {},
                },
                '.text_28': {
                    '@apply lg:text-[28px] md:text-[25px] sm:text-[22px] text-[18px] lg:leading-[1.3] md:leading-[1.2] sm:leading-[1.1] leading-[1]': {},
                },
                '.text_24': {
                    '@apply lg:text-[24px] md:text-[21px] sm:text-[18px] text-[16px] lg:leading-[1.3] md:leading-[1.2] sm:leading-[1.1] leading-[1]': {},
                },
                '.text_21': {
                    '@apply lg:text-[21px] md:text-[18px] sm:text-[16px] text-[14px]': {},
                },
                '.text_18': {
                    '@apply lg:text-[18px] md:text-[16px] sm:text-[15px] text-[14px] lg:leading-[1.3] md:leading-[1.2] sm:leading-[1.1] leading-[1]': {},
                },
                '.text_16': {
                    '@apply lg:text-[16px] md:text-[15px] text-[14px]': {},
                },
                '.text_14': {
                    '@apply lg:text-[14px] md:text-[12px] sm:text-[11px] text-[10px]': {},
                },
                '.text_12': {
                    '@apply lg:text-[12px] md:text-[11px] sm:text-[10px] text-[9px]': {},
                },
                '.text_ld': {
                    '@apply text-[#383247] dark:text-[#fafafa]': {},
                },
                '.border_ld': {
                    '@apply border border-[#383247]/20 dark:border-[#fafafa]': {},
                },
                '.border_ld_dashed': {
                    '@apply border border-dashed border-[1px] border-[#383247]/20 dark:border-[#fafafa]': {},
                },
                '.text_invert': {
                    '@apply dark:text-[#383247] text-[#fafafa]': {},
                },
                '.bg_ld': {
                    '@apply bg-gray-200 dark:bg-gray-800': {},
                },
                '.bg_ld_contrast': {
                    '@apply bg-[#f7faff] dark:bg-[#303c4c]': {},
                },
                '.bg_ld_invert': {
                    '@apply dark:bg-gray-200 bg-gray-800': {},
                },
                '.ringed': {
                    '@apply ring-1 ring-black ring-opacity-5': {},
                },
                '.bg_secondary': {
                    '@apply bg-[#FAFAFA] dark:bg-[#1A2233]': {},
                },
                '.btn_main': {
                    '@apply inline-flex items-center px-4 py-2 font-semibold text-xs text-white uppercase tracking-widest transition rounded': {},
                },
                '.btn_ld': {
                    '@apply bg-[#334155] hover:bg-[#0f172a] dark:bg-[#333745] dark:hover:bg-[#444857] text-white duration-75': {},
                },
                '.btn_ld_border': {
                    '@apply inline-flex items-center px-4 py-2 font-semibold text-xs uppercase tracking-widest transition rounded border border-[#D2D9E1] hover:bg-[#0f172a] dark:border-[#fafafa] dark:hover:bg-[#444857] dark:text-[#fafafa] text-[#383247] hover:text-white duration-75': {},
                },
                '.ringed_10': {
                    '@apply ring-1 ring-black ring-opacity-10': {},
                },
                '.opacity_80': {
                    '@apply opacity-80 hover:opacity-100 duration-75': {},
                },
                '.upload_btn': {
                    '@apply cursor-pointer relative flex justify-center items-center py-1 w-[200px] rounded-[8px] bg-gray-200 dark:bg-gray-800 text-[#383247] dark:text-[#fafafa] font-semibold text-[36px] uppercase tracking-wide hover:opacity-90': {},
                },
                '.header_34': {
                    '@apply text_34 text_ld font-bold font-play opacity-80': {},
                },
                '.header_21': {
                    '@apply text_21 text_ld font-bold font-play opacity-80': {},
                },
                // ...
            });
        }
    ],
};
