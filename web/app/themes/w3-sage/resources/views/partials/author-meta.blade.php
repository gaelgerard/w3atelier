
<dl class="pt-6 pb-10 xl:border-b xl:border-gray-200 xl:pt-11 xl:dark:border-gray-700">
    <dt class="sr-only">Authors</dt>
    <dd>
        <ul class="flex flex-wrap justify-center gap-4 sm:space-x-12 xl:block xl:space-y-8 xl:space-x-0">
            <li class="flex items-center space-x-2">
                {!! $author_avatar !!}
                <dl class="text-sm leading-5 font-medium whitespace-nowrap">
                    <dt class="sr-only">{{ __('Name', 'sage') }}</dt>
                    <dd class="text-gray-900 dark:text-gray-100 p-author h-card">{{ get_the_author() }}</dd>
                    <dt class="sr-only">{{ __('Website', 'sage') }}</dt>
                    <dd>
                        <a class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        href="{{ $author_url }}">{!! $author_domain !!}</a>
                    </dd>
                </dl>
            </li>
        </ul>
    </dd>
</dl>