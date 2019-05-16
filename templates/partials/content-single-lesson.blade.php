@php
$course = new App\Course();
$is_over = $course->isOver();
$lesson = new App\Lesson();
$lesson_number = $lesson->currentNumber(get_the_ID());
@endphp

<div class="container container--padding">
  <div class="row">
    <div class="col-md-9 content--app__main">
      @component('components.shadow-box', ['variant' => 'white', 'row' => false])
        <article class="c-lesson d-flex justify-content-center">
          <div class="col-sm-11 col-lg-10">
            <header class="c-lesson__header">
              <div class="c-lesson__header-inner">
                <p class="c-lesson__header__date">{{ the_date('j F Y') }}</p>
                <h2 class="c-lesson__header__heading">{{ the_title() }}</h2>
              </div>
              <p class="c-lesson__header__current">
                {{ __('Dzień', 'pkpk') }}
                <span>{{ $lesson_number + 1 }}</span>
              </p>
            </header>
            <main class="c-lesson__content">
              @if ($is_over)
                {{ the_excerpt() }}
              @else
                {{ the_content() }}
              @endif
            </main>
            <footer class="c-lesson__footer">
              @if ($is_over)
                @include('partials/course/social-sharers')
                @include('partials/course/banner', ['title' => 'To tylko zajawka jednej z lekcji.'])
              @endif
              <div class="c-lesson__report d-flex justify-content-center">
                <div class="col-sm-11 col-lg-10">
                  <?php echo do_shortcode('[userreporting]'); ?>
                </div>
              </div>
            </footer>
          </div>
        </article>
      @endcomponent
      @if( get_field('comment') )
      <div class="c-featured-comment c-comments">
        <h2>
          {{ __('Komentarz autora', 'pkpk') }}
        </h2>
        <div class="c-featured-comment__item bypostauthor">
          <footer class="comment-meta">
            <div class="comment-author vcard">
              <b class="fn">{{ get_the_author_meta('user_nicename') }}</b> <span class="says">napisał:</span>
            </div>
          </footer>
          <div class="comment-content">
            {{ the_field('comment') }}
          </div>
        </div>
      </div>
      @endif
      <div class="c-comments">
        @php(comments_template('/templates/partials/comments.blade.php'))
      </div>
    </div>
    <div class="col-md-3 content--app__sidebar">
      @include('partials/course/progress')
      @include('partials/course/lessons-list')
    </div>
  </div>
</div>
