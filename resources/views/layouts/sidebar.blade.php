<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bolder ms-2">Tdevs</span>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('admin.plans*') ? 'active' : '' }}">
      <a href="{{ route('admin.plans.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-data"></i>
        <div>Manage Plan</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('logout') }}" class="menu-link"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="menu-icon tf-icons bx bx-power-off"></i>
        <div>Logout</div>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </li>
  </ul>
</aside>
