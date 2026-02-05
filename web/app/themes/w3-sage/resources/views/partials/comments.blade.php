@if (! post_password_required())
  <section id="comments" class="comments xl:mt-4">
    @if ($responses())
      <h2>
        {!! $title !!}
      </h2>

      <ol class="comment-list">
        {!! $responses !!}
      </ol>

      @if ($paginated())
        <nav aria-label="Comment">
          <ul class="pager">
            @if ($previous())
              <li class="previous">
                {!! $previous !!}
              </li>
            @endif

            @if ($next())
              <li class="next">
                {!! $next !!}
              </li>
            @endif
          </ul>
        </nav>
      @endif
    @endif

    @if ($closed())
      <x-alert type="warning">
        {!! __('Comments are closed.', 'sage') !!}
      </x-alert>
    @endif

    @php
      $commenter = wp_get_current_commenter();
      $req = get_option('require_name_email');
      $aria_req = $req ? "aria-required='true' required" : '';
    @endphp

    @php(comment_form([
        'class_form' => 'space-y-6',
        'class_submit' => 'inline-flex items-center rounded-md bg-gray-900 dark:bg-gray-100 px-5 py-2.5 text-sm font-medium text-white dark:text-gray-900 hover:bg-gray-800 dark:hover:text-gray-100 cursor-pointer focus:outline-none',
        'title_reply' => 'Laisser un commentaire',
        'title_reply_before' => '<h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-4">',
        'title_reply_after' => '</h3>',
        'comment_notes_before' => '',
        'comment_notes_after' => '
            <p class="text-sm text-gray-500">
                Votre adresse email ne sera pas publiée. Les champs marqués d’un * sont obligatoires
            </p>',
        'comment_field' => '
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-100">
                    Commentaire
                </label>
                <textarea
                    id="comment"
                    name="comment"
                    rows="5"
                    class="w-full border-b border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:outline-none focus:ring-0"
                    placeholder="Votre commentaire…"
                    required
                ></textarea>
            </div>',
        'fields' => [
            'author' => '
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-100">
                        Nom' . ($req ? ' *' : '') . '
                    </label>
                    <input
                        id="author"
                        name="author"
                        type="text"
                        value="' . esc_attr($commenter['comment_author']) . '"
                        class="w-full border-b border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:outline-none focus:ring-0"
                        ' . $aria_req . '
                    />
                </div>',
            'email' => '
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-100">
                        Email' . ($req ? ' *' : '') . '
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="' . esc_attr($commenter['comment_author_email']) . '"
                        class="w-full border-b border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:outline-none focus:ring-0"
                        ' . $aria_req . '
                    />
                </div>',
            'url' => '
                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-100">
                        Site web
                    </label>
                    <input
                        id="url"
                        name="url"
                        type="url"
                        value="' . esc_attr($commenter['comment_author_url']) . '"
                        class="w-full border-b border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:outline-none focus:ring-0"
                    />
                </div>',
        ],
    ]))
  </section>
@endif
