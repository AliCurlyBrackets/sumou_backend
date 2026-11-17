/* Sumou – Tailwind CDN config (shared by all pages).
   Must be loaded right after the Tailwind CDN script. */
tailwind.config = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: {
          /* core palette (home page) */
          navy: '#070C18',
          navyLight: '#0D162B',
          navyCard: 'rgba(13, 22, 43, 0.75)',
          gold: '#D4A537',
          goldLight: '#F5D77A',
          goldDark: '#B8860B',
          blue: '#1E6FD9',
          cyan: '#38BDF8',
          azure: '#0284C7',
          /* extra tokens used by about page */
          dark: '#070C18',
          surface: '#111B33',
          goldBright: '#FFE599',
          blueLight: '#4FA3FF',
          blueCyan: '#38BDF8',
          /* extra tokens used by blog page */
          midnight: '#050914',
          navyDark: '#080E1E',
          navySurface: '#0D162B',
          cyanAccent: '#00D2FF',
          blueAccent: '#38BDF8'
        }
      },
      fontFamily: {
        cairo: ['Cairo', 'sans-serif'],
        tajawal: ['Tajawal', 'sans-serif'],
        cinzel: ['Cinzel', 'serif'],
        inter: ['Inter', 'sans-serif'],
        grotesk: ['"Space Grotesk"', 'sans-serif']
      },
      boxShadow: {
        'gold-glow': '0 0 25px -4px rgba(212, 175, 55, 0.35)',
        'gold-glow-sm': '0 0 15px -2px rgba(212, 175, 55, 0.25)',
        'cyan-glow': '0 0 25px -5px rgba(0, 210, 255, 0.35)',
        'luxury-card': '0 20px 45px -12px rgba(0, 0, 0, 0.65)',
        'luxury-hover': '0 20px 40px -15px rgba(0, 0, 0, 0.8), 0 0 30px 2px rgba(212, 175, 55, 0.2)'
      },
      backgroundImage: {
        'gold-gradient': 'linear-gradient(135deg, #ECC880 0%, #D4AF37 50%, #9B7829 100%)',
        'gold-subtle': 'linear-gradient(135deg, rgba(236,200,128,0.12) 0%, rgba(212,175,55,0.04) 100%)',
        'radial-luxury': 'radial-gradient(circle at 50% 10%, rgba(212,175,55,0.08) 0%, rgba(5,9,20,0) 70%)'
      },
      animation: {
        'spin-slow': 'spin 35s linear infinite',
        'spin-reverse': 'spin-reverse 45s linear infinite',
        'float-slow': 'float 6s ease-in-out infinite',
        'float-reverse': 'floatRev 7s ease-in-out infinite',
        'pulse-glow': 'pulse-glow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        'pulse-blur': 'pulseBlur 3s ease-in-out infinite',
        'circuit-flow': 'circuitFlow 4s linear infinite',
        'radar': 'radar 8s linear infinite',
        'shimmer': 'shimmer 2.5s infinite linear',
        'marquee': 'marquee 35s linear infinite'
      },
      keyframes: {
        'spin-reverse': {
          '0%': { transform: 'rotate(360deg)' },
          '100%': { transform: 'rotate(0deg)' }
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-12px)' }
        },
        floatRev: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(12px)' }
        },
        'pulse-glow': {
          '0%, 100%': { opacity: '0.4', filter: 'drop-shadow(0 0 15px rgba(212, 165, 55, 0.3))' },
          '50%': { opacity: '0.9', filter: 'drop-shadow(0 0 30px rgba(56, 189, 248, 0.6))' }
        },
        pulseBlur: {
          '0%, 100%': { opacity: '0.4', filter: 'blur(24px)' },
          '50%': { opacity: '0.8', filter: 'blur(36px)' }
        },
        circuitFlow: {
          '0%': { backgroundPosition: '0% 0%' },
          '100%': { backgroundPosition: '200% 200%' }
        },
        radar: {
          '0%': { transform: 'rotate(0deg)' },
          '100%': { transform: 'rotate(360deg)' }
        },
        shimmer: {
          '0%': { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' }
        },
        marquee: {
          '0%': { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(-50%)' }
        }
      }
    }
  }
};
