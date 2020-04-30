@php
pkpk_setup_featured_course();
$frontpage_id = get_option( 'page_on_front' );
$cta_anchor = get_field('course_cta_anchor', $frontpage_id);
$cta_full_anchor = get_field('course_cta_anchor_limit_full', $frontpage_id);
$cta_full_anchor_sub = get_field('course_cta_anchor_limit_full_sub', $frontpage_id);

@endphp
@component('components.skewy-container', ['variant' => 'white', 'id' => 'cennik'])
<div class="container flex--wrap  container--padding container--cennik">
	<h2 class="std-heading std-heading--full-width std-heading--center">Weź udział w programie</h2>

	<div class="spin-loader" v-if="!coursesFetched">
		<div class="spin">
			<i class="icon ion-load-d"></i>
		</div>
	</div>

	<div class="select-course container" v-if="coursesFetched">
		<h3 class="select-course__heading">Termin kursu:</h3>
		<ul class="select-course__dates">
			<li v-for="(course, index) in courses" @click="return function() {selectedCourse = index, highlightDate = true; bsTooltipReflow();}()" :class="{selected: selectedCourse == index}">
				@{{ course.start }}
			</li>
		</ul>
	</div>
	<div class="price-table" v-if="coursesFetched">

		<div class="text-center" v-if="courses[selectedCourse].download_limit > 0 && courses[selectedCourse].download_limit - courses[selectedCourse].course_sales > 0">
			<div class="select-course__limit d-none d-md-inline-block">
				<span>@{{ courses[selectedCourse].limit_message_1 }}</span><span class="select-course__limit--number">@{{ courses[selectedCourse].limit_message_2 }}</span><span>@{{ courses[selectedCourse].limit_message_3 }}</span>
			</div>
		</div>

		<div class="text-center" v-if="courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0)">
			<div class="select-course__limit d-none d-md-inline-block">
				<span>@{{ courses[selectedCourse].sold_out_message_1 }}</span><span class="select-course__limit--sub">@{{ courses[selectedCourse].sold_out_message_2 }}</span>
			</div>
		</div>

		<div class="row justify-content-center">

			@if (get_field('course_basic_name', $frontpage_id))
			<div class="col-sm-8 col-md-6 col-lg-4 price-table__column" v-if="courses[selectedCourse].variants.basic.price">

				<div class="text-center">
					<div class="select-course__limit d-md-none" v-if="courses[selectedCourse].download_limit > 0 && courses[selectedCourse].download_limit - courses[selectedCourse].course_sales > 0">
						<span>@{{ courses[selectedCourse].limit_message_1 }}</span><span class="select-course__limit--number">@{{ courses[selectedCourse].limit_message_2 }}</span><span>@{{ courses[selectedCourse].limit_message_3 }}</span>
					</div>
				</div>

				<div class="price-table__item price-table__item--basic d-sm-flex flex-wrap">
					<div class="price-table__item-head">
						<div class="price-table__item-meta">
							<p class="price-table__item-variant">{{ the_field('course_basic_name', $frontpage_id) }}</p>
							<p class="price-table__item-price">@{{ courses[selectedCourse].variants.basic.price | toFixed }}zł</p>
							@if (get_field('course_basic_subheader', $frontpage_id))
							<p class="price-table__item-desc">{{ the_field('course_basic_subheader', $frontpage_id) }}</p>
							@endif
						</div>

						@if (have_rows('course_basic_features', $frontpage_id))
						<div class="price-table__item-content">
							<ul class="price-table__item-details col">
								@while(have_rows('course_basic_features', $frontpage_id)) @php(the_row())
								<li>{{ the_sub_field('feature') }}</li>
								@endwhile
							</ul>
						</div>
						@endif
					</div>

					<div class="price-table__item-footer align-self-end">
						<!-- Wyświetlane, jeśli jest jeszcze możliwe zapisanie się na kurs -->
						<a :href="'{{ home_url('/zamowienie?edd_action=add_to_cart&download_id=') }}' + courses[selectedCourse].downloadID + '&amp;edd_options&#91;price_id&#93;=1'" class="btn btn--large btn--course-basic btn--price" v-if="!(courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0))">{{ $cta_anchor }}</a>

						<!-- Wyświetlane w przypadku gdy włączone jest ograniczenie liczby uczestników i brakuje już wolnych miejsc -->
						<div class="btn btn--large btn--course-basic btn--thin btn--withsub" @click="return function() {selectedCourse = 1, highlightDate = true; bsTooltipReflow();}()" :class="{selected: selectedCourse == 1}" v-if="courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0)"><span>{{ $cta_full_anchor }}</span><span class="btn__sub">{{ $cta_full_anchor_sub }}</span></div>

						<div v-if="!(courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0))">
							{{ App\cta_warranty_msg('dark', 'center') }}
						</div>

						<p class="price-table__selected-date">Wybrany termin: <span :class="{ 'highlight' : highlightDate }">@{{ courses[selectedCourse].start }}</span></p>
					</div>
				</div>
			</div>
			@endif

			@if (get_field('course_pro_name', $frontpage_id))
			<div class="col-sm-8 col-md-6 col-lg-4 price-table__column" v-if="courses[selectedCourse].variants.plus.price">

				<div class="text-center">
					<div class="select-course__limit d-md-none" v-if="courses[selectedCourse].download_limit > 0 && courses[selectedCourse].download_limit - courses[selectedCourse].course_sales > 0">
						<span>@{{ courses[selectedCourse].limit_message_1 }}</span><span class="select-course__limit--number">@{{ courses[selectedCourse].limit_message_2 }}</span><span>@{{ courses[selectedCourse].limit_message_3 }}</span>
					</div>
				</div>

				<div class="price-table__item price-table__item--plus d-sm-flex flex-wrap">
					<div class="price-table__item-head">
						<div class="price-table__item-meta">
							<p class="price-table__item-variant">{{ the_field('course_pro_name', $frontpage_id) }}</p>
							<p class="price-table__item-price">@{{ courses[selectedCourse].variants.plus.price | toFixed }}zł</p>
							@if (get_field('course_pro_subheader', $frontpage_id))
							<p class="price-table__item-desc">{{ the_field('course_pro_subheader', $frontpage_id) }}</p>
							@endif
						</div>

						@if (have_rows('course_basic_features', $frontpage_id))
						@if (have_rows('course_pro_features', $frontpage_id))
						<div class="price-table__item-content">
							<ul class="price-table__item-details col">
								@while(have_rows('course_basic_features', $frontpage_id)) @php(the_row())
								<li>{{ the_sub_field('feature') }}</li>
								@endwhile
								@while(have_rows('course_pro_features', $frontpage_id)) @php(the_row())
								<li>{{ the_sub_field('feature') }}</li>
								@endwhile
							</ul>
						</div>
						@endif
						@endif
					</div>

					<div class="price-table__item-footer align-self-end">
						<!-- Wyświetlane, jeśli jest jeszcze możliwe zapisanie się na kurs -->
						<a :href="'{{ home_url('/zamowienie?edd_action=add_to_cart&download_id=') }}' + courses[selectedCourse].downloadID + '&amp;edd_options&#91;price_id&#93;=2'" class="btn btn--large btn--course-plus btn--price" v-if="!(courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0))">{{ $cta_anchor }}</a>

						<!-- Wyświetlane w przypadku gdy włączone jest ograniczenie liczby uczestników i brakuje już wolnych miejsc -->
						<div class="btn btn--large btn--course-plus btn--thin btn--withsub" @click="return function() {selectedCourse = 1, highlightDate = true; bsTooltipReflow();}()" :class="{selected: selectedCourse == 1}" v-if="courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0)"><span>{{ $cta_full_anchor }}</span><span class="btn__sub">{{ $cta_full_anchor_sub }}</span></div>

						<div v-if="!(courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0))">
							{{ App\cta_warranty_msg('dark', 'center') }}
						</div>

						<p class="price-table__selected-date">Wybrany termin: <span :class="{ 'highlight' : highlightDate }">@{{ courses[selectedCourse].start }}</span></p>
					</div>
				</div>
			</div>
			@endif

			@if (get_field('course_enterprise_name', $frontpage_id))
			<div class="col-sm-8 col-md-6 col-lg-4 price-table__column" v-if="courses[selectedCourse].variants.pro.price">

				<div class="text-center">
					<div class="select-course__limit d-md-none" v-if="courses[selectedCourse].download_limit > 0 && courses[selectedCourse].download_limit - courses[selectedCourse].course_sales > 0">
						<span>@{{ courses[selectedCourse].limit_message_1 }}</span><span class="select-course__limit--number">@{{ courses[selectedCourse].limit_message_2 }}</span><span>@{{ courses[selectedCourse].limit_message_3 }}</span>
					</div>
				</div>
				
				<div class="price-table__item price-table__item--pro d-sm-flex flex-wrap">
					<div class="price-table__item-head">
						<div class="price-table__item-meta">
							<p class="price-table__item-variant">{{ the_field('course_enterprise_name', $frontpage_id) }}</p>
							<p class="price-table__item-price">@{{ courses[selectedCourse].variants.pro.price | toFixed }}zł</p>
							@if (get_field('course_enterprise_subheader', $frontpage_id))
							<p class="price-table__item-desc">{{ the_field('course_enterprise_subheader', $frontpage_id) }}</p>
							@endif
						</div>

						@if (have_rows('course_basic_features', $frontpage_id))
						@if (have_rows('course_pro_features', $frontpage_id))
						@if (have_rows('course_enterprise_features', $frontpage_id))
						<div class="price-table__item-content">
							<ul class="price-table__item-details col">
								@while(have_rows('course_basic_features', $frontpage_id)) @php(the_row())
								<li>{{ the_sub_field('feature') }}</li>
								@endwhile
								@while(have_rows('course_pro_features', $frontpage_id)) @php(the_row())
								<li>{{ the_sub_field('feature') }}</li>
								@endwhile
								@while(have_rows('course_enterprise_features', $frontpage_id)) @php(the_row())
								<li>{{ the_sub_field('feature') }}</li>
								@endwhile
							</ul>
						</div>
						@endif
						@endif
						@endif
					</div>

					<div class="price-table__item-footer align-self-end">
						<!-- Wyświetlane, jeśli jest jeszcze możliwe zapisanie się na kurs -->
						<a :href="'{{ home_url('/zamowienie?edd_action=add_to_cart&download_id=') }}' + courses[selectedCourse].downloadID + '&amp;edd_options&#91;price_id&#93;=3'" class="btn btn--large btn--course-pro btn--price" v-if="!(courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0))">{{ $cta_anchor }}</a>

						<!-- Wyświetlane w przypadku gdy włączone jest ograniczenie liczby uczestników i brakuje już wolnych miejsc -->
						<div class="btn btn--large btn--course-pro btn--thin btn--withsub" @click="return function() {selectedCourse = 1, highlightDate = true; bsTooltipReflow();}()" :class="{selected: selectedCourse == 1}" v-if="courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0)"><span>{{ $cta_full_anchor }}</span><span class="btn__sub">{{ $cta_full_anchor_sub }}</span></div>

						<div v-if="!(courses[selectedCourse].download_limit > 0 && (courses[selectedCourse].download_limit - courses[selectedCourse].course_sales == 0))">
							{{ App\cta_warranty_msg('dark', 'center') }}
						</div>

						<p class="price-table__selected-date">Wybrany termin: <span :class="{ 'highlight' : highlightDate }">@{{ courses[selectedCourse].start }}</span></p>
					</div>
				</div>
			</div>
			@endif

		</div>
	</div>
</div>
@endcomponent
@php(wp_reset_postdata())
