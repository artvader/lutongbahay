/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        terracotta: {
          DEFAULT: '#C2582A',
          dark: '#8B3A1D',
          light: '#D4784E',
        },
        dahon: {
          DEFAULT: '#2D6A4F',
          light: '#74A67E',
        },
        calamansi: {
          DEFAULT: '#E8A838',
          light: '#F2C56B',
        },
        mango: '#F0734A',
        bigas: '#FAF7F2',
        harina: '#F2EDE4',
        uling: '#2B2118',
        kawayan: '#6B5E52',
        bayong: '#D9CDBF',
      },
      fontFamily: {
        heading: ['"DM Serif Display"', 'Georgia', 'serif'],
        body: ['Inter', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        hero: ['2.5rem', { lineHeight: '1.2', letterSpacing: '-0.02em' }],
        h1: ['2rem', { lineHeight: '1.25', letterSpacing: '-0.01em' }],
        h2: ['1.5rem', { lineHeight: '1.3' }],
        h3: ['1.25rem', { lineHeight: '1.4' }],
        body: ['1rem', { lineHeight: '1.6' }],
        small: ['0.875rem', { lineHeight: '1.5' }],
        caption: ['0.75rem', { lineHeight: '1.4', letterSpacing: '0.05em' }],
      },
      borderRadius: {
        card: '12px',
        btn: '8px',
        chip: '20px',
      },
      boxShadow: {
        card: '0 2px 8px rgba(43, 33, 24, 0.06)',
        'card-hover': '0 6px 16px rgba(43, 33, 24, 0.10)',
        'input-focus': '0 0 0 3px rgba(194, 88, 42, 0.12)',
      },
    },
  },
  plugins: [],
}
