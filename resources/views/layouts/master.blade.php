<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
    integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
    crossorigin="anonymous" />

  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/themify-icons/themify-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/perfect-scrollbar/css/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-override.min.css') }}" />
  <link rel="stylesheet" id="theme-color" href="{{ asset('assets/css/dark.min.css') }}" />
</head>

<body>
  <div id="app">
    <div class="shadow-header"></div>
    <header class="header-navbar fixed">
      <div class="header-wrapper">
        <div class="header-left">
          <div class="sidebar-toggle action-toggle"><i class="fas fa-bars"></i></div>
        </div>
        <div class="header-content">
          <div class="notification dropdown me-2">
            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="far fa-bell"></i>
              <span class="badge">12</span>
            </a>
            <ul class="dropdown-menu medium">
              <li class="menu-header">
                <a class="dropdown-item" href="#">Notification</a>
              </li>
              <li class="menu-content ps-menu">
                <a href="#">
                  <div class="message-icon text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                  </div>
                  <div class="message-content read">
                    <div class="body">There's incoming event, don't miss it!!</div>
                    <div class="time">Just now</div>
                  </div>
                </a>
                <a href="#">
                  <div class="message-icon text-info">
                    <i class="fas fa-info"></i>
                  </div>
                  <div class="message-content read">
                    <div class="body">Your licence will expired soon</div>
                    <div class="time">3 hours ago</div>
                  </div>
                </a>
                <a href="#">
                  <div class="message-icon text-success">
                    <i class="fas fa-check"></i>
                  </div>
                  <div class="message-content">
                    <div class="body">Successfully register new user</div>
                    <div class="time">8 hours ago</div>
                  </div>
                </a>
              </li>
            </ul>
          </div>
          <div class="dropdown dropdown-menu-end">
            <a href="#" class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="label">
                <span></span>
                <div>Admin</div>
              </div>
              <img class="img-user" src="../assets/images/avatar1.png" alt="user" srcset="" />
            </a>
            <ul class="dropdown-menu small">
              <li class="menu-content ps-menu">
                <a href="#">
                  <div class="description"><i class="ti-user"></i> Profile</div>
                </a>
                <a href="#">
                  <div class="description"><i class="ti-settings"></i> Setting</div>
                </a>
                <a href="#">
                  <div class="description"><i class="ti-power-off"></i> Logout</div>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <nav class="main-sidebar ps-menu">
      <div class="sidebar-header">
        <div class="text">CodeEasy</div>
        <div class="close-sidebar action-toggle">
          <i class="ti-close"></i>
        </div>
      </div>
      @include('layouts.sidebar.admin')
    </nav>
    <main class="main-content">
      @yield('main')
    </main>

    <footer>
      Copyright © 2022 &nbsp
      <a href="https://www.youtube.com/c/mulaidarinull" target="_blank" class="ml-1">
        Mulai Dari Null
      </a>
      <span> . All rights Reserved</span>
    </footer>
    <div class="overlay action-toggle"></div>
  </div>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
  <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.min.js') }}"></script>
  <script>
    Main.init();
  </script>
</body>

</html>
