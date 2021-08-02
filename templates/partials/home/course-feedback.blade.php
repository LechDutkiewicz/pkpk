@component('components.skewy-container', ['variant' => 'gray', 'id' => 'opinie'])
@if (have_rows('opinie_filmiki'))
<div class="container container--flex flex--wrap container--padding container--cennik">
	<div class="row justify-content-center">
		<div class="col-sm-12 col-lg-9">
			<h2 class="std-heading std-heading--full-width std-heading--center std-heading--opinie">
				{{ the_field('opinie_header_thin') }}
				<span class="std-heading--bold">{{ the_field('opinie_header_bold') }}</span>
			</h2>
		</div>
		@while(have_rows('opinie_filmiki')) @php(the_row())
		<div class="col-sm-12 col-md-6 col-lg-5 col-xl-4">
			<a href="https://api.vadoo.tv/iframe_test?id={{ the_sub_field('kafelek_video') }}" class="opinia" data-lity>
				@php
				echo wp_get_attachment_image( get_sub_field('kafelek_img'), 'full', '', ['class' => 'opinia__img'] )
				@endphp
				<h3 class="opinia__title">{{ the_sub_field('kafelek_title') }}</h3>
				<p class="opinia__desc">{{ the_sub_field('kafelek_desc') }}</p>
				<div class="play-button">
					<img src="{{ App\asset_path('images/playbutton-small.png') }}" alt="Kliknij żeby włączyć video">
				</div>
			</a>
		</div>
		@endwhile
	</div>
</div>
@endif
@endcomponent
