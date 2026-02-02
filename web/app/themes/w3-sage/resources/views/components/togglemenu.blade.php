@if (has_nav_menu('primary_navigation'))
<nav class="nav-primary" x-data="{ open: false }">
  {{-- Bouton Toggle --}}
  <button
    id="mobile-menu-button"
    class="relative z-50 p-2 text-gray-900 dark:text-gray-100 cursor-pointer md:hidden"
    aria-label="Menu"
  >
    <svg id="icon-open" class="size-8 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
    <svg id="icon-close" class="size-8 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>
  {{-- Menu Slide-over --}}
  <div
    id="mobile-menu"
    class="fixed inset-0 z-40 bg-white dark:bg-gray-950 md:dark:bg-transparent transform translate-x-full transition-transform duration-300 ease-in-out md:relative md:inset-auto md:translate-x-0 md:flex md:items-center"
  >
    <div class="flex flex-col items-center justify-center h-full space-y-8 md:h-auto md:space-y-0 md:flex-row">
      {!! wp_nav_menu([
        'theme_location' => 'primary_navigation',
        'menu_class' => 'nav flex flex-col items-center space-y-6 md:flex-row md:space-y-0 md:space-x-8 text-2xl md:text-base font-sans text-gray-900 dark:text-gray-100',
        'echo' => false
      ]) !!}
    </div>
  </div>
</nav>
@endif