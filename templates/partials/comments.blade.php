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
      {!! wp_list_comments(['style' => 'ul', 'short_ping' => true, 'callback' => 'App\comment' ]) !!}
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
