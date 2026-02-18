<li class="py-12 first:pt-0">
    <article>
        <div class="space-y-8">
        <div class="space-y-4">
            <div class="flex flex-col gap-4 text-sm text-gray-500 dark:text-gray-400">
            <dl>
                <dt class="sr-only">{__('Published on', 'sage')}</dt>
                <dd class="text-base font-medium leading-6 text-gray-500 dark:text-gray-200">
                <time datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>

                @if($is_significantly_modified)
                <time class="updated" datetime="{{ get_the_modified_time('c') }}">
                    ({{__('Updated on:', 'sage')}} {{ get_the_modified_date() }})
                </time>
                @endif
                </dd>
            </dl>
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                <a href="{{ get_permalink() }}" class="break-words no-underline">
                    {!! get_the_title() !!}
                </a>
                
            </h3>
                @php($tags = get_the_tags())
                @if($tags)
                <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <a class="text-sm no-underline transition-all font-mono uppercase hover:underline block py-1 text-primary-500 font-bold mr-4" href="{{ get_tag_link($tag->term_id) }}">
                    {{ $tag->name }}
                    </a>
                @endforeach
                </div>
                @endif
            </div>
            @php(the_excerpt())

        </div>
    </article>
</li>