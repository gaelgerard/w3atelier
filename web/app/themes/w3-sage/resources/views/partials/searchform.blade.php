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
<form id="search-form" class="flex">
    <div class="flex-1 relative">
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-primary-400">
            <i class="fas fa-search"></i>
        </div>

        <input 
            type="text" 
            id="search-input"
            placeholder= "{{__('Search blog posts, pages...', 'sage')}}" 
            class="w-full pl-12 pr-4 py-4 rounded-2xl border-0 focus:ring-2 focus:ring-[var(--accent-500)] focus:outline-none dark:bg-gray-600"
            autocomplete="off"
        >
    </div>
    <button 
        type="submit"
        class="ml-2 px-6 py-4 bg-gradient-to-r from-[var(--accent-500)] to-[var(--accent-600)] text-white font-semibold rounded-2xl hover:from-[var(--accent-600)] hover:to-[var(--accent-700)] transition-all duration-300 transform hover:-translate-y-0.5"
    >
        Search
    </button>
</form>