<div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
              <img
                src="{{ asset('template/assets/img/kaiadmin/merchant.png') }}"
                alt="navbar brand"
                class="navbar-brand"
                height="50"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('dashboard') }}">
                        <span class="sub-item">Dashboard Utama</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

              @auth
                @if (auth()->user()->role === 'developer')
                  <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#developerMenu">
                      <i class="fas fa-user-cog"></i>
                      <p>Developer</p>
                      <span class="caret"></span>
                    </a>
                    <div class="collapse" id="developerMenu">
                      <ul class="nav nav-collapse">
                        <li>
                          <a href="{{ route('developer.users.index') }}">
                            <span class="sub-item">Manage User</span>
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('developer.menus.index') }}">
                            <span class="sub-item">Manage Menu</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </li>
                @endif
              @endauth

              @php
                  // Mengambil menu khusus untuk role merchant yang aktif
                  $merchantMenus = \App\Models\Menu::where('role', 'merchant')
                                      ->where('is_active', true)
                                      ->whereNull('parent_id')
                                      ->orderBy('order')
                                      ->with(['children' => function($query) {
                                          $query->where('is_active', true)->orderBy('order');
                                      }])
                                      ->get();
              @endphp

              @foreach($merchantMenus as $menu)
                  <li class="nav-item">
                      @if($menu->children->count() > 0)
                          <a data-bs-toggle="collapse" href="#dynamicMenu{{ $menu->id }}">
                              <i class="{{ $menu->icon }}"></i>
                              <p>{{ $menu->name }}</p>
                              <span class="caret"></span>
                          </a>
                          <div class="collapse" id="dynamicMenu{{ $menu->id }}">
                              <ul class="nav nav-collapse">
                                  @foreach($menu->children as $child)
                                      <li class="nav-item">
                                          <a href="{{ Route::has($child->route) ? route($child->route) : '#' }}">
                                              <span class="sub-item">{{ $child->name }}</span>
                                          </a>
                                      </li>
                                  @endforeach
                              </ul>
                          </div>
                      @else
                          <a href="{{ Route::has($menu->route) ? route($menu->route) : '#' }}">
                              <i class="{{ $menu->icon }}"></i>
                              <p>{{ $menu->name }}</p>
                          </a>
                      @endif
                  </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>