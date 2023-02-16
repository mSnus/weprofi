<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i> <span>Настройки</span></a></li>
<br>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-question'></i> Пользователи</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('city') }}"><i class="nav-icon la la-th-list"></i> Города</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('spec') }}"><i class="nav-icon la la-th-list"></i> Категории</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('subspec') }}"><i class="nav-icon la la-th-list"></i> Подкатегории</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('/admin/stats') }}"><i class="nav-icon la la-th-list"></i> Статистика</a></li>