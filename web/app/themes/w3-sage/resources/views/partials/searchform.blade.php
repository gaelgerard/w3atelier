<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes pulse-gentle {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }

    .float {
        animation: float 3s ease-in-out infinite;
    }

    .pulse-gentle {
        animation: pulse-gentle 2s ease-in-out infinite;
    }
</style>
<form role="search" method="get" id="search-form" class="flex" action="{{ home_url('/') }}">
    <div class="flex-1 relative">
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-primary-400">
            <i class="fas fa-search"></i>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
        </div>

        <input 
            type="text" 
            name="s" 
            value="{{ get_search_query() }}"
            placeholder= "{{__('Search blog posts, pages...', 'sage')}}" 
            class="search-input-field w-full pl-12 pr-4 py-4 rounded-2xl border-0 focus:ring-2 focus:ring-[var(--accent-500)] focus:outline-none dark:bg-gray-600"
            autocomplete="off"
        >
    </div>
    <button 
        type="submit"
        class="cursor-pointer ml-2 px-6 py-4 bg-gradient-to-r from-[var(--accent-500)] to-[var(--accent-600)] text-white font-semibold rounded-2xl hover:from-[var(--accent-600)] hover:to-[var(--accent-700)] transition-all duration-300 transform hover:-translate-y-0.5"
    >
        {!! __('Search','sage') !!}
    </button>
</form>