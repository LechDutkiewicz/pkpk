@php
if (post_password_required()) {
return;
}
@endphp

<section id="comments" class="comments">
  @if (have_comments())
  <h2>
    {!! sprintf(_nx('Jeden komentarz', 'Komentarze (%1$s)', get_comments_number(), 'comments title', 'sage'), number_format_i18n(get_comments_number())) !!}
  </h2>

  <ol class="comment-list">
    @php
    $args = array(
      'post_status' => 'publish',
      'orderby' => array(
        'has_likes' => 'DESC',
        'comment_date_gmt' => 'ASC'
      ),
      'post_id' => $post->ID,
      'meta_query' => array(
        'relation' => 'OR',
        'has_likes' => array(
          'key' => '_commentliked',
          'compare' => '>=',
          'value' => 1
        ),
        array(
          'relation' => 'OR',
          array(
            'relation' => 'AND',
            array(
              'key' => '_commentliked',
              'compare' => 'EXISTS'
            ),
            array(
              'key' => '_commentliked',
              'compare' => '=',
              'value' => 0
            )
          ),
          array(
            'key' => '_commentliked',
            'compare' => 'NOT EXISTS'
          )
        ),
      )
    );

    $comments = get_comments($args);
    //var_dump($comments);


    //global $wp_query;
    //$comment_arr = $wp_query->comments;
    // posortuj komentarze według likeów dodanych wtyczką WP ULike
    // usort($comment_arr, 'comment_comparator');
    // $comment_arr = sort_likes( $comment_arr );

    @endphp
    {!! wp_list_comments(['style' => 'ul', 'short_ping' => true, 'callback' => 'App\comment' ], $comments) !!}
  </ol>

  @if (get_comment_pages_count() > 1 && get_option('page_comments'))
  <nav>
    <ul class="pager">
      @if (get_previous_comments_link())
      <li class="previous">@php(previous_comments_link(__('&larr; Older comments', 'sage')))</li>
      @endif
      @if (get_next_comments_link())
      <li class="next">@php(next_comments_link(__('Newer comments &rarr;', 'sage')))</li>
      @endif
    </ul>
  </nav>
  @endif
  @else
  <h2>{{ __('Brak komentarzy', 'pkpk') }}</h2>
  @endif

  @if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments'))
  {{-- <div class="alert alert-warning">
    {{ __('Comments are closed.', 'sage') }}
  </div> --}}
  @endif

  @php(comment_form())
</section>
