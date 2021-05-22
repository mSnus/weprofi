<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/masters') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.master.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/offers') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.offer.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/clients') }}"><i class="nav-icon icon-graduation"></i> {{ trans('admin.client.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i class="nav-icon icon-magnet"></i> {{ trans('admin.user.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/moderators') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.moderator.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/feedback') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.feedback.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
