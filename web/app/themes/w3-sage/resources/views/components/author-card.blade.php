@props(['titleTag' => 'h2'])

<div class="space-y-4">
    <div class="space-y-2">
        <{!! $titleTag !!} class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
            Gaël GÉRARD
        </{!! $titleTag !!}>
        
        <div class="space-y-1 font-mono text-xs uppercase tracking-wider text-gray-600 dark:text-gray-400">
            <p class="font-semibold text-primary-600 dark:text-primary-400">Consultant web senior</p>
            <p>Expertise depuis 2001</p>
            
            <div class="pt-1 space-y-1 opacity-80">
                <p class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    Nantes, France
                </p>
                <p class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <a href="tel:+33285523866" class="hover:text-primary-500 transition-colors">+33 (0)2 85 52 38 66</a>
                </p>
            </div>
        </div>
    </div>

    <div class="flex gap-4">
        {{-- Lien Mail --}}
        <a class="group text-gray-700 dark:text-gray-200 transition-colors" href="/contact" title="Me contacter">
            <span class="sr-only">Email</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="h-6 w-6 fill-current group-hover:text-primary-500 transition-colors">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
            </svg>
        </a>

        {{-- Lien GitHub --}}
        <a class="group text-gray-700 dark:text-gray-200 transition-colors" target="_blank" rel="noopener noreferrer" href="https://github.com/gaelgerard" title="Mon GitHub">
            <span class="sr-only">GitHub</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-current group-hover:text-primary-500 transition-colors">
                <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path>
            </svg>
        </a>

        {{-- Lien LinkedIn --}}
        <a class="group text-gray-700 dark:text-gray-200 transition-colors" target="_blank" rel="noopener noreferrer" href="https://www.linkedin.com/in/gael-gerard" title="Mon profil LinkedIn">
            <span class="sr-only">LinkedIn</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-current group-hover:text-primary-500 transition-colors">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path>
            </svg>
        </a>
    </div>
</div>