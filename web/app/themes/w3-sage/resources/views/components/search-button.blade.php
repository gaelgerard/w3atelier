<button
        id="search-form-button"  class="group flex" aria-label="{{ __('Open search', 'sage') }}">
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 512 512"
            style="width: 20px; height: 20px;"
            class="w-5 h-5 transition-transform group-hover:rotate-12 
                  fill-current ml-2 my-auto cursor-pointer
                  text-gray-700 dark:text-gray-200"
        >
            <path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
        </svg>
      </button>
      {{-- Search form Slide-over --}}
      <div id="search-form-wrapper" class="fixed inset-0 cursor-pointer z-100 bg-white/95 dark:bg-gray-950/95 backdrop-blur-sm transform translate-x-full transition-transform duration-300 ease-in-out flex items-center justify-center">
          
          <button id="close-search" class="absolute top-6 right-6 text-gray-500 hover:text-black dark:text-gray-400 dark:hover:text-white cursor-pointer" aria-label="{{ __('Close search', 'sage') }}">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </button>

          <div class="w-full max-w-3xl px-6">
              {!! get_search_form(false) !!}
              <p class="text-xs text-gray-700 dark:text-gray-100 mt-4 text-center">{{ __('Press "Enter" to start the search or "Escape" to close', 'sage') }}</p>
          </div>
      </div>