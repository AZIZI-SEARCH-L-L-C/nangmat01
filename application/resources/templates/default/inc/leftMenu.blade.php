<div class="collection">
	<a href="{{ route('preferences') }}" class="collection-item">{{ trans('leftmenu.change_pref') }} @if($activeItem == 'preferences') <i class="material-icons right">navigate_next</i> @endif</a>
	<a href="{{ route('web.advanced') }}" class="collection-item">{{ trans('leftmenu.advanced_search') }} @if($activeItem == 'web_adv') <i class="material-icons right">navigate_next</i> @endif</a>
	@if($settings['enable_bookmarks'])
		<a href="{{ route('profile.bookmarks') }}" class="collection-item">{{ trans('leftmenu.bookmarks') }} @if($activeItem == 'bookmarks_adv') <i class="material-icons right">navigate_next</i> @endif</a>
	@endif
</div>
@if(Auth::check())
	<div class="collection">
		<a href="{{ route('profile.edit.info') }}" class="collection-item">{{ trans('leftmenu.change_account_info') }} @if($activeItem == 'info') <i class="material-icons right">navigate_next</i> @endif</a>
		<a href="{{ route('profile.edit.pass') }}" class="collection-item">{{ trans('leftmenu.change_password') }} @if($activeItem == 'pass') <i class="material-icons right">navigate_next</i> @endif</a>
		@if($settings['advertisements'])
			<a href="{{ route('profile.edit.billing') }}" class="collection-item">{{ trans('leftmenu.change_billing') }} @if($activeItem == 'billing') <i class="material-icons right">navigate_next</i> @endif</a>
		@endif
	</div>
	@if($settings['advertisements'])
		<div class="collection">
			<a href="{{ route('ads.compains') }}" class="collection-item">{{ trans('leftmenu.ads_campaigns') }} @if($activeItem == 'compains') <i class="material-icons right">navigate_next</i> @endif</a>
			<a href="{{ route('ads.payments') }}" class="collection-item">{{ trans('leftmenu.ads_payments') }} @if($activeItem == 'payments') <i class="material-icons right">navigate_next</i> @endif</a>
		</div>
	@endif

@endif