<div class="sidebar" data-color="orange">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="home" class="simple-text logo-mini">
      {{ __('DS') }}
    </a>
    <a href="home" class="simple-text logo-normal">
      {{ __('Data Sekolah') }}
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <li class="@if ($activePage == 'home') active @endif">
        <a href="{{ route('home.index') }}">
          <i class="now-ui-icons design_app"></i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="@if ($activePage == 'datasiswa') active @endif">
        <a href="{{ route('siswa.index') }}">
          <i class="now-ui-icons users_single-02"></i>
          <p>{{ __('Data Siswa') }}</p>
        </a>
      </li>
      <li class="@if ($activePage == 'dataguru') active @endif">
        <a href="{{ route('guru.index') }}">
          <i class="now-ui-icons education_hat"></i>
          <p>{{ __('Data Guru') }}</p>
        </a>
      </li>
      <li class="@if ($activePage == 'datakelas') active @endif">
        <a href="{{ route('kelas.index') }}">
          <i class="now-ui-icons education_agenda-bookmark"></i>
          <p>{{ __('Data Kelas') }}</p>
        </a>
      </li>
      <li class = "@if ($activePage == 'Log Out') active @endif">
        <a href="actionlogout">
          <i class="now-ui-icons media-1_button-power"></i>
          <p>{{ __('Log Out') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
