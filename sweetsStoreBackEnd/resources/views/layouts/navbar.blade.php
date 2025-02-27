<nav class="navbar navbar-expand navbar-light  topbar mb-4 static-top shadow" style="background-color: #B1A05A;">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>
  
    <!-- Topbar Search -->
  
  
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
  
      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-search fa-fw"></i>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
          <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
  
  
  
      <!-- Nav Item - Messages -->
      @php($Contact = DB::table('contact_us')->count('id'))
  
      <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="{{ route('Contact') }}" id="messagesDropdown" >
          <i class="fas fa-envelope fa-fw"></i>
          {{$Contact}} 
      </a>
  
  </li>
  
  
      <div class="topbar-divider d-none d-sm-block"></div>
  
      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#"  id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="ml-2 d-none d-lg-inline small" style="color: #fff; margin-right: 8px">
                {{ auth()->user()->name }}
            <br>
            <small>{{ auth()->user()->level }}</small>
          </span>
          <img class="img-profile rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="/profile">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
  
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>
  
    </ul>
  
  </nav>