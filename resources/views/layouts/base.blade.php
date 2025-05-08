<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" lang="en">
 <head><base href="../../">
  <title>
    CAGUZ
  </title>
  <meta charset="utf-8"/>
  <meta content="follow, index" name="robots"/>

  <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
  <meta content="" name="description"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta content="" property="og:description"/>
  <link href="{{ asset('favicon.jpg') }}" rel="apple-touch-icon" sizes="180x180"/>
  <link href="{{ asset('favicon.jpg') }}" rel="icon" sizes="32x32" type="image/png"/>
  <link href="{{ asset('favicon.jpg') }}" rel="icon" sizes="16x16" type="image/png"/>
  <link href="{{ asset('favicon.jpg') }}" rel="shortcut icon"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

  <link href=" {{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet"/>
  <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"/>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @vite(['resources/css/app.scss', 'resources/js/app.js'])
 </head>
 <body class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:#f6f6f6] [--tw-page-bg-dark:var(--tw-coal-200)] [--tw-content-bg:var(--tw-light)] [--tw-content-bg-dark:var(--tw-coal-500)] [--tw-content-scrollbar-color:#e8e8e8] [--tw-header-height:58px] [--tw-sidebar-width:58px] [--tw-navbar-height:56px] bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark] lg:overflow-hidden">
  <script>
   const defaultThemeMode = 'light';
		let themeMode;

		if ( document.documentElement ) {
			if ( localStorage.getItem('theme')) {
					themeMode = localStorage.getItem('theme');
			} else if ( document.documentElement.hasAttribute('data-theme-mode')) {
				themeMode = document.documentElement.getAttribute('data-theme-mode');
			} else {
				themeMode = defaultThemeMode;
			}

			if (themeMode === 'system') {
				themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
			}

			document.documentElement.classList.add(themeMode);
		}
  </script>
  <!-- End of Theme Mode -->

  <div class="flex flex-col grow">
   <header class="flex items-center fixed z-10 top-0 left-0 right-0 shrink-0 h-[--tw-header-height] bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]" id="header">
    <div class="container-fluid flex justify-between items-stretch px-5 lg:ps-0 lg:gap-4" id="header_container">
     <div class="flex items-center">
      <div class="flex items-center justify-center lg:w-[--tw-sidebar-width] gap-2 shrink-0">
       <button class="btn btn-icon btn-light btn-clear btn-sm -ms-2 lg:hidden" data-drawer-toggle="#sidebar">
        <i class="ki-filled ki-menu">
        </i>
       </button>
       <a>
        <img class="dark:hidden min-h-[24px]" src="assets/media/app/mini-logo-primary.svg"/>
        <img class="hidden dark:block min-h-[24px]" src="assets/media/app/mini-logo-primary-dark.svg"/>
       </a>
      </div>
      <div class="flex items-center">
       <h3 class="text-gray-700 text-base hidden md:block">
          Condominio Campestre El Peñón    
            <span class="text-sm text-gray-400 font-medium px-2.5 hidden md:inline">
            -
           </span>
           CAGUZ
       </h3>
      </div>
     </div>

     <div class="flex items-center gap-1.5 lg:gap-3.5">
   
      <div class="menu" data-menu="true">
       <div class="menu-item" data-menu-item-offset="0px, 9px" data-menu-item-placement="bottom-end" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
        <div class="menu-toggle btn btn-icon rounded-full">
         <img alt="" class="size-8 rounded-full justify-center border border-gray-500 shrink-0" src="{{ asset('user.png') }}">
 
         </img>
        </div>
        <div class="menu-dropdown menu-default light:border-gray-300 w-screen max-w-[250px]">
         <div class="flex items-center justify-between px-5 py-1.5 gap-1.5">
          <div class="flex items-center gap-2">
           <img alt="" class="size-9 rounded-full border-2 border-success" src="{{ asset('user.png') }}">
            <div class="flex flex-col gap-1.5">
             <span class="text-sm text-gray-800 font-semibold leading-none">
              {{ auth()->user()->name }}
             </span>
             <a class="text-xs text-gray-600 hover:text-primary font-medium leading-none">
              {{ auth()->user()->email }}
             </a>
            </div>
           </img>
          </div>
         </div>
         <div class="menu-separator">
         </div>
         <div class="flex flex-col">
          <div class="menu-item mb-0.5">
           <div class="menu-link">
            <span class="menu-icon">
             <i class="ki-filled ki-moon">
             </i>
            </span>
            <span class="menu-title">
             Modo Oscuro
            </span>
            <label class="switch switch-sm">
             <input data-theme-state="dark" data-theme-toggle="true" name="check" type="checkbox" value="1">
             </input>
            </label>
           </div>
          </div>
          <div class="menu-item px-4 py-1.5">
            <form method="POST" action="{{ route('logout') }}" x-data="">
                @csrf 
                
                <button type="submit"
                  class="btn btn-sm btn-light justify-center w-full" 
                  role="button">
                    Cerrar Sesión 
                </button>
            </form>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </header>


   <div class="wrapper flex grow flex-col pt-[--tw-header-height]">
    <div class="fixed w-[--tw-sidebar-width] lg:top-[--tw-header-height] top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 group py-3 lg:py-0" data-drawer="true" data-drawer-class="drawer drawer-start top-0 bottom-0" data-drawer-enable="true|lg:false" id="sidebar">
     <div class="flex grow shrink-0" id="sidebar_content">
      <div class="scrollable-y-auto grow gap-2.5 shrink-0 flex items-center flex-col" data-scrollable="true" data-scrollable-height="auto" data-scrollable-offset="0px" data-scrollable-wrappers="#sidebar_content">
       <a class="btn btn-icon btn-icon-lg rounded-full size-10 border border-transparent text-gray-600 hover:bg-light hover:text-primary hover:border-gray-300 [.active&]:bg-light [.active&]:text-primary [.active&]:border-gray-300 active" data-tooltip="" data-tooltip-placement="right" href="/ubicaciones">
        <span class="menu-icon">
         <i class="ki-filled ki-setting-2">
         </i>
        </span>
        <span class="tooltip">
         Administración
        </span>
       </a>
      </div>
     </div>
    </div>

    <div class="flex items-stretch lg:fixed z-5 top-[--tw-header-height] start-[--tw-sidebar-width] end-5 h-[--tw-navbar-height] mx-5 lg:mx-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]" id="navbar">
     <div class="rounded-t-xl border border-gray-400 dark:border-gray-200 border-b-gray-300 dark:border-b-gray-200 bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] flex items-stretch grow">
  
      <div class="container-fluid flex justify-between items-stretch gap-5">
       <div class="grid items-stretch">
        <div class="scrollable-x-auto flex items-stretch">
         <div class="menu gap-5 lg:gap-7.5" data-menu="true">
          <div class="menu-item border-b-2 border-b-transparent menu-item-active:border-b-gray-900 menu-item-here:border-b-gray-900" data-menu-item-placement="bottom-start" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:hover">
           <div class="menu-link gap-1.5" tabindex="0">
            <span class="menu-title text-nowrap text-sm text-gray-800 menu-item-active:text-gray-900 menu-item-active:font-medium menu-item-here:text-gray-900 menu-item-here:font-medium menu-item-show:text-gray-900 menu-link-hover:text-gray-900">
              Administración de ubicaciones
            </span>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
    <main class="scrollable-y-auto [scrollbar-width:auto] light:[--tw-scrollbar-thumb-color:var(--tw-content-scrollbar-color)] flex flex-col grow rounded-b-xl bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] border-x border-b border-gray-400 dark:border-gray-200 lg:mt-[--tw-navbar-height] mx-5 lg:ms-[--tw-sidebar-width] lg:me-5 pt-7 mb-5" data-scrollable="true" data-scrollable-dependencies="#header,#navbar" data-scrollable-height="false|lg:auto" data-scrollable-offset="20px" role="content">
     <div class="container-fluid">
        @yield('content')
     </div>
     <footer class="py-3">
      <div class="container-fluid">
       <div class="flex flex-col md:flex-row justify-center md:justify-between items-center gap-3 py-2">
        <div class="flex order-2 md:order-1 gap-2 font-normal text-2sm">
         <span class="text-gray-500">
          {{ date("Y"); }} ©
         </span>
         <a class="text-gray-600 hover:text-primary" >
          Condominio Campestre El Peñón
         </a>
        </div>
       </div>
      </div>
     </footer>
    </main>
   </div>
  </div>

  <script src="assets/js/core.bundle.js">
  </script>
  <script src="assets/vendors/apexcharts/apexcharts.min.js">
  </script>
  <script src="assets/js/widgets/general.js">
  </script>

  @stack('scripts')
 </body>
</html>
