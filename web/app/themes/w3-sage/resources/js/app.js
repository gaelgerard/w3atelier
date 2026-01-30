import.meta.glob([
  '../images/**',
  '../fonts/**',
]);
document.addEventListener('DOMContentLoaded', () => {
  const button = document.getElementById('mobile-menu-button');
  const menu = document.getElementById('mobile-menu');
  const iconOpen = document.getElementById('icon-open');
  const iconClose = document.getElementById('icon-close');
  const body = document.body;

  if (button && menu) {
    button.addEventListener('click', () => {
      const isOpen = menu.classList.contains('translate-x-0');

      if (isOpen) {
        // Fermeture
        menu.classList.replace('translate-x-0', 'translate-x-full');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
        body.style.overflow = ''; // Réactive le scroll
      } else {
        // Ouverture
        menu.classList.replace('translate-x-full', 'translate-x-0');
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
        body.style.overflow = 'hidden'; // Bloque le scroll
      }
    });
  }
});