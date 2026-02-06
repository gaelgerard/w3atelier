<aside class="hidden md:block md:w-64">
    <div class="sticky top-24 space-y-8">
        <div class="space-y-4">
            <h2 class="font-mono text-sm tracking-wider text-gray-500 uppercase dark:text-gray-300">{!! __('Filter by tag', 'sage') !!}</h2>
            <nav class="flex flex-col space-y-3">
                {{ do_action('custom_tag_list') }}
            </nav>
            <h2 class="font-mono text-sm tracking-wider text-gray-500 uppercase dark:text-gray-300">{!! __('Filter by category', 'sage') !!}</h2>
            <nav class="flex flex-col space-y-3">
                <ul>
                    {{ 
                        wp_list_categories(
                        array(
                        'title_li' => '',
                        'hide_title_if_empty' => true,
                        'show_count' => 1,                        
                        'walker' => new App\Custom_Walker_Category(),
                        ) );
                    }}
                </ul>
            </nav>
        </div>
    </div>
</aside>
