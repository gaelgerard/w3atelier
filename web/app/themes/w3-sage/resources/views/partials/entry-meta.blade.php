<time class="dt-published" datetime="{{ get_post_time('c', true) }}">
  {{ get_the_date() }}
</time>
@if($is_significantly_modified)
<time class="updated" datetime="{{ get_the_modified_time('c') }}">
    ({{__('Updated on:', 'sage')}} {{ get_the_modified_date() }})
</time>
@endif

