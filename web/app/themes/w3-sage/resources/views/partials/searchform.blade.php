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
        <input 
            type="text" 
            name="s" 
            value="{{ get_search_query() }}"
            placeholder= "{{__('Search blog posts, pages...', 'sage')}}" 
            class="search-input-field w-full pl-12 pr-4 py-4 rounded-2xl border-1 dark:border-0 border-gray-200 focus:border-0 focus:ring-2 focus:ring-[var(--accent-500)] focus:outline-none dark:bg-gray-600"
            autocomplete="off"
            required
        >
    </div>
    <button 
        type="submit"
        class="cursor-pointer ml-2 px-6 py-4 bg-gradient-to-r from-[var(--accent-500)] to-[var(--accent-600)] text-white font-semibold rounded-2xl hover:from-[var(--accent-600)] hover:to-[var(--accent-700)] transition-all duration-300 transform hover:-translate-y-0.5"
    >
        {!! __('Search','sage') !!}
    </button>
</form>