<button 
  id="theme-toggle" 
  type="button" 
  class="group cursor-pointer text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2.5 transition-all active:scale-95"
  aria-label="{{ __('Enable dark mode', 'sage') }}"
  data-label-light="{{ __('Enable light mode', 'sage') }}"
  data-label-dark="{{ __('Enable dark mode', 'sage') }}"
>
  <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
  <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 transition-transform group-hover:rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
</button>

<script>
  (function() {
    const btn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    /**
     * Détermine le thème à appliquer au chargement
     */
    function getInitialTheme() {
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme) return savedTheme;

      // Si pas de choix manuel, on suit la préférence système
      return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    /**
     * Met à jour l'UI (icônes et accessibilité i18n)
     */
    function updateInterface() {
      const isDark = document.documentElement.classList.contains('dark');

      // Bascule des icônes
      if (isDark) {
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
      } else {
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
      }

      // Mise à jour de l'aria-label avec les traductions du DOM
      const nextLabel = isDark 
        ? btn.getAttribute('data-label-light') 
        : btn.getAttribute('data-label-dark');
      
      btn.setAttribute('aria-label', nextLabel);
    }

    // 1. Initialisation immédiate pour éviter le flash blanc (FOUC)
    const initialTheme = getInitialTheme();
    if (initialTheme === 'dark') {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
    
    // On attend que le DOM soit prêt pour manipuler les icônes
    updateInterface();

    // 2. Écouteur de clic
    btn.addEventListener('click', function() {
      document.documentElement.classList.add('theme-toggling');

      const isDark = document.documentElement.classList.toggle('dark');
      localStorage.setItem('theme', isDark ? 'dark' : 'light');

      updateInterface();

      setTimeout(() => {
        document.documentElement.classList.remove('theme-toggling');
      }, 450);
    });

    // 3. Écouteur de changement système (si l'utilisateur change son OS de mode)
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
      // On ne change automatiquement que si l'utilisateur n'a pas fait de choix manuel
      if (!localStorage.getItem('theme')) {
        const newTheme = e.matches ? 'dark' : 'light';
        document.documentElement.classList.toggle('dark', e.matches);
        updateInterface();
      }
    });
  })();
</script>