<dl class="w-full sm:w-50 sm:float-left sm:mr-6 sm:mb-4 p-4 rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-100/50 dark:bg-gray-900/30 backdrop-blur-sm">
    <dt class="sr-only">Authors</dt>
    <dd>
        <ul class="flex flex-wrap justify-start gap-4">
            <li class="flex items-center space-x-3">
                <!-- Avatar avec taille forcée si besoin pour éviter les sauts de layout -->
                <div class="shrink-0 rounded-full overflow-hidden ring-2 ring-gray-100 dark:ring-gray-800">
                    {!! $author_avatar !!}
                </div>

                <dl class="text-xs leading-tight font-medium" itemscope itemtype="https://schema.org/Person">
                    <!-- Mention explicite du rôle -->
                    <dt class="text-[10px] uppercase tracking-wider text-gray-400 dark:text-gray-500 font-bold mb-0.5">
                        {{ __('Rédigé par', 'sage') }}
                    </dt>
                    
                    <dt class="sr-only">{{ __('Name', 'sage') }}</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-gray-200 p-author h-card mb-1.5" itemprop="name">
                        {{ get_the_author() }}
                    </dd>

                    @if(!empty($author_url))
                        <dt class="sr-only">{{ __('Website', 'sage') }}</dt>
                        <dd class="flex items-center text-gray-500 dark:text-gray-400 mb-1 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe mr-1.5 opacity-70">
                                <circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>
                            </svg>
                            <a class="truncate max-w-[140px]" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               href="{{ $author_url }}"
                               itemprop="url">
                                {!! $author_domain !!}
                            </a>
                        </dd>
                    @endif
                    
                    @if(!empty($author_phone['display']))
                        <dt class="sr-only">{{ __('Phone', 'sage') }}</dt>
                        <dd class="flex items-center text-gray-500 dark:text-gray-400 hover:text-primary-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone mr-1.5 opacity-70">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <a href="tel:{{ $author_phone['link'] }}" itemprop="telephone">
                                {{ $author_phone['display'] }}
                            </a>
                        </dd>
                    @endif
                </dl>
            </li>
        </ul>
    </dd>
</dl>