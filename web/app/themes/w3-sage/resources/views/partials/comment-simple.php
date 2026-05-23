<<?php echo $tag ?? 'li'; ?> <?php comment_class('group', $comment); ?> id="comment-<?php comment_ID(); ?>">
  <article class="flex gap-4 py-6">
    <div class="flex-1">
      <header class="flex flex-wrap items-center gap-x-2 text-sm text-gray-700">
        <div class="shrink-0">
          <?php echo get_avatar($comment, 40, '', '', ['class' => 'rounded-full']); ?>
        </div>
        <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
          <?php echo get_comment_author(); ?>
        </span>
        <span class="text-gray-400">·</span>
        <time datetime="<?php echo get_comment_time('c'); ?>" class="text-gray-500">
          <?php echo get_comment_date(); ?>
        </time>
      </header>

      <?php if ($comment->comment_approved == '0') : ?>
        <p class="mt-2 text-sm text-amber-600">
          Votre commentaire est en attente de modération.
        </p>
      <?php endif; ?>

      <div class="prose prose-sm mt-3 max-w-none text-gray-700 dark:text-gray-300">
        <?php comment_text(); ?>
      </div>

      <footer class="mt-3 text-sm text-gray-500">
        <?php
          comment_reply_link(array_merge($args, [
            'depth' => $depth,
            'max_depth' => $args['max_depth'],
            'reply_text' => 'Répondre',
          ]));
        ?>
      </footer>
    </div>
  </article>
