import.meta.glob([
  '../images/**',
  '../fonts/**',
]);
import 'fslightbox';
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
  // 1. On cible tous tes blocs de code
  const codeBlocks = document.querySelectorAll('pre.editor');

  codeBlocks.forEach((block) => {
    // 2. On crée le bouton
    const button = document.createElement('button');
    const btnIcon = '<span class="mr-2"><svg aria-hidden="true" class="svg-icon iconCopy mr4" width="17" height="18" viewBox="0 0 17 18"><path d="M5 6c0-1.09.91-2 2-2h4.5L15 7.5V15c0 1.09-.91 2-2 2H7c-1.09 0-2-.91-2-2zm6-1.25V8h3.25z"></path><path d="M10 1a2 2 0 0 1 2 2H6a2 2 0 0 0-2 2v9a2 2 0 0 1-2-2V4a3 3 0 0 1 3-3z" opacity=".4"></path></svg></span>';
    const checkMark = '<span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg></span>';
    button.innerHTML = btnIcon + ' Copier';
    button.className = 'copy-code-button'; // Pour le styliser en CSS

    // On s'assure que le parent est en position relative pour placer le bouton
    block.style.position = 'relative';
    block.appendChild(button);

    // 3. Logique de copie au clic
    button.addEventListener('click', () => {
      const code = block.innerText.replace('Copier', '').trim();
      
      navigator.clipboard.writeText(code).then(() => {
        // Petit feedback visuel
        button.innerHTML = checkMark + 'Copié !';
        button.classList.add('copied');

        setTimeout(() => {
          button.innerHTML = btnIcon + 'Copier';
          button.classList.remove('copied');
        }, 2000);
      }).catch(err => {
        console.error('Erreur lors de la copie : ', err);
      });
    });
  });
});