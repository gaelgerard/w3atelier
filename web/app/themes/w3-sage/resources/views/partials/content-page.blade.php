<div class="mx-auto max-w-4xl px-4 sm:px-6 xl:px-0">
  <div class="space-y-8 pt-16 pb-12">
    <div class="grid gap-12 pt-4 md:grid-cols-7">
      <div class="flex flex-row items-start gap-8 md:col-span-2 md:flex-col">
        <div class="w-[150px] overflow-hidden rounded-lg bg-gray-100 lg:w-[200px] dark:bg-gray-800">
          {{ the_post_thumbnail() }}
        </div>
        <div class="space-y-4">
        <x-author-card />
        </div>
      </div>
      <div class="prose prose-gray dark:prose-invert max-w-none md:col-span-5">
      @php(the_content())
      @if(is_page('tags'))
      @php( do_action('custom_tag_list', 'cloud') )
      @endif
      
      </div>
    </div>
  </div>
</div>