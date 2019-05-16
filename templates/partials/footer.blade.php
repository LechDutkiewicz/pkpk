<footer class="content-info">
  @if(!is_front_page())
  <div class="footer-newsletter">
    <div class="container container--padding">
      <div class="row align-items-end">
        <div class="col-md-6">
          <h2>Produktywna lista</h2>
          <p>Chcesz dowiedzieć się więcej o byciu produktywnym, zarządzaniu własnym czasem? <br>Zapisz się do mojego newlettera.</p>
        </div>
        <div class="col-md-6">
          <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" style="position: relative;" class="d-flex" validate>
          	<!-- Pole email (wymagane) -->
          	<input type="email" name="email" class="email" placeholder="Twój adres email" style="width: 100%;" required/>
          	<!-- Token kampanii -->
          	<!-- Pobierz token na: https://app.getresponse.com/campaign_list.html -->
          	<input type="hidden" name="campaign_token" value="T3XJo" />
            <!-- Thank you page (optional) -->
            <input type="hidden" name="thankyou_url" value="<?php echo get_permalink( get_page_by_title( 'Sprawdź swój email!' ) ); ?>"/>
          	<!-- Przycisk zapisu -->
          	<input type="submit" value="Zapisz się do Produktywnej Listy" class="btn btn--large btn--green btn--subscribe" style="top: 0"/>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endif
  <div class="container container--footer container--padding">
    <div class="row">
      <div class="col-sm-6 content-info__copyright">
        <p>Copyright by <strong><a href="http://produktywni.pl/">Produktywni.pl</a></strong></p>
      </div>
      <div class="col-sm-6 content-info__authors">
        <p>Design by <strong><a href="http://projectpeople.pl/">Joanna Ostafin @ProjectPeople.pl</a></strong></p>
      </div>
    </div>
  </div>
</footer>
