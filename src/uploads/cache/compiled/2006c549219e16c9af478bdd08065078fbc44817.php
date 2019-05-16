<?php (pkpk_setup_featured_course()); ?>
<?php $__env->startComponent('components.skewy-container', ['variant' => 'white', 'id' => 'cennik']); ?>
  <div class="container container--flex flex--wrap  container--padding container--cennik">
    <h2 class="std-heading std-heading--full-width std-heading--center">Weź udział w programie</h2>

    <div class="spin-loader" v-if="!coursesFetched">
      <div class="spin">
        <i class="icon ion-load-d"></i>
      </div>
    </div>

    <div class="select-course container" v-if="coursesFetched">
      <h3 class="select-course__heading">Termin kursu:</h3>
      <ul class="select-course__dates">
        <li v-for="(course, index) in courses" @click="selectedCourse = index" :class="{selected: selectedCourse == index}">
          {{ course.start }}
        </li>
			</ul>
    </div>
    <div class="price-table container" v-if="coursesFetched">
      <div class="row justify-content-center">
        <?php $__env->startComponent('components.shadow-box', ['variant' => 'white', 'col' => 'md-9 col-lg-7']); ?>

            <div class="col-sm-6 price-table__item price-table__item--color-secondary">
              <div class="price-table__item-head">
                <p class="price-table__item-variant">Program podstawowy</p>
                <p class="price-table__item-price">{{ courses[selectedCourse].variants.basic.price | toFixed }}zł</p>
                <p class="price-table__item-desc">Program "produktywność krok po kroku"</p>
              </div>
              <div class="price-table__item-content">
                <?php
                ?>
                <a :href="'<?php echo e(home_url('/zamowienie?edd_action=add_to_cart&download_id=')); ?>' + courses[selectedCourse].downloadID + '&amp;edd_options&#91;price_id&#93;=1'" class="btn btn--large btn--secondary"> Zapisz się na kurs</a>
                <p class="price-table__selected-date">Wybrany termin: <span>{{ courses[selectedCourse].start }}</span>
                <ul class="price-table__item-details">
                  <li>31 lekcji i zadań</li>
                  <li>Prywatna platforma internetowa</li>
                  <li>Wsparcie społeczności</li>
                  <li>Ponad 20 narzędzi i metod</li>
                </ul>
              </div>
            </div>

            <div class="col-sm-6 price-table__item price-table__item--color-green">
              <div class="price-table__item-head">
                <p class="price-table__item-variant">Program rozszerzony</p>
                <p class="price-table__item-price">{{ courses[selectedCourse].variants.pro.price | toFixed }}zł</p>
                <p class="price-table__item-desc">Program "produktywność krok po kroku" oraz materiały dodatkowe</p>
              </div>
              <div class="price-table__item-content">
                <a :href="'<?php echo e(home_url('/zamowienie?edd_action=add_to_cart&download_id=')); ?>' + courses[selectedCourse].downloadID + '&amp;edd_options&#91;price_id&#93;=2'" class="btn btn--large btn--green"> Zapisz się na kurs</a>
                <p class="price-table__selected-date">Wybrany termin: <span>{{ courses[selectedCourse].start }}</span>
                <ul class="price-table__item-details">
                  <li>31 lekcji i zadań</li>
                  <li>Prywatna platforma internetowa</li>
                  <li>Wsparcie społeczności</li>
                  <li>Ponad 20 narzędzi i metod</li>
                  <li>Ebook "Effective Multitasking"​​​​​​​</li>
                  <li>4 prywatne webinary z Q&A</li>
                  <li>Dodatkowe materiały</li>
                </ul>
              </div>
            </div>

        <?php echo $__env->renderComponent(); ?>
      </div>
    </div>
  </div>
<?php echo $__env->renderComponent(); ?>
<?php (wp_reset_postdata()); ?>
