<ul class="divide-y divide-gray-200">

  @php
    wp_list_comments([
      'style'    => 'ul',
      'callback' => 'App\\render_comment',
    ]);
  @endphp

</ul>
