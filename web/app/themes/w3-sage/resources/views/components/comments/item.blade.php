<li {{ comment_class('py-6', $comment) }} id="comment-{{ $comment->comment_ID }}">

  <article class="flex gap-4">

    {{-- Avatar --}}
    <div class="shrink-0">
      {!! get_avatar($comment, 40, '', '', [
        'class' => 'rounded-full',
      ]) !!}
    </div>

    {{-- Contenu --}}
    <div class="flex-1 space-y-2">

      <header class="flex items-center gap-2 text-sm">
        <span class="font-medium text-gray-900">
          {{ get_comment_author($comment) }}
        </span>

        <span class="text-gray-400">·</span>

        <time datetime="{{ get_comment_time('c') }}"
              class="text-gray-500">
          {{ get_comment_date('', $comment) }}
        </time>
      </header>

      @if ($comment->comment_approved == '0')
        <p class="text-sm text-amber-600">
          Votre commentaire est en attente de modération.
        </p>
      @endif

      <div class="prose prose-sm max-w-none">
        {!! get_comment_text($comment) !!}
      </div>

      <footer class="text-sm text-gray-500">
        @php
          comment_reply_link(array_merge($args, [
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'reply_text'=> 'Répondre',
          ]));
        @endphp
      </footer>

    </div>
  </article>

</li>
