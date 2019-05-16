<section id="popup--not-yet" class="c-popup" :class="{ 'is-open' : notYetPopup }">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="c-popup__content col-12 col-md-10 col-lg-8">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-10">
            <div class="alert-box__icon c-popup__icon">
              <i class="zmdi zmdi-email"></i>
            </div>
            <h2>{{ __('Sprzedaż jest teraz zamknięta...', 'pkpk') }}</h2>
            <p>i będzie aktywna przez miesiąc przed kursem. <br><strong>{{ __('Zostaw swój e-mail', 'pkpk') }}</strong> {{ __('by nie przegapić startu zapisów oraz promocji.', 'pkpk') }}</p>
            <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" style="position: relative;" class="d-flex flex-wrap productive-newsletter" validate>
              <!-- Pole email (wymagane) -->
              <input type="email" name="email" class="email" placeholder="Twój adres email" style="width: 100%;" required/>
              <!-- Token kampanii -->
              <!-- Pobierz token na: https://app.getresponse.com/campaign_list.html -->
              <input type="hidden" name="campaign_token" value="T3XJo" />
              <!-- Thank you page (optional) -->
              <input type="hidden" name="thankyou_url" value="<?php echo get_permalink( get_page_by_title( 'Sprawdź swój email!' ) ); ?>"/>
              <!-- Przycisk zapisu -->
              <input type="submit" value="Zapisz się do Produktywnej Listy" class="btn btn--large btn--green btn--subscribe btn--full-width" style="top: 0"/>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="c-popup__overlay" @click="closeNotYetPopup"></div>
</section>