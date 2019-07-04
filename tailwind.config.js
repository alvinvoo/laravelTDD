module.exports = {
  theme: {
    extend: {
      colors: {
        grey: 'rgba(0,0,0,0.4)',
        'grey-light': '#F5F6F9',
        'bb-blue': '#47cdff',
        'bb-blue-light': '#8ae2fe'
      }
    },
    boxShadow: {
      default: '0 0 5px 0 rgba(0,0,0,0.08)'
    }
  },
  variants: {},
  plugins: [
    function({ addComponents }) {
      const buttons = {
        '.btn': {
          padding: '.5rem 1rem',
          borderRadius: '.25rem',
          fontWeight: '600',
        },
        '.btn-blue': {
          backgroundColor: '#3490dc',
          color: '#fff',
          '&:hover': {
            backgroundColor: '#2779bd'
          },
        },
        '.btn-red': {
          backgroundColor: '#e3342f',
          color: '#fff',
          '&:hover': {
            backgroundColor: '#cc1f1a'
          },
        },
      }

      addComponents(buttons)
    }
  ]
}
