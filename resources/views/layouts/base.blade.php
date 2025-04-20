<!--
Product: Metronic is a toolkit of UI components built with Tailwind CSS for developing scalable web applications quickly and efficiently
Version: v9.0.6
Author: Keenthemes
Contact: support@keenthemes.com
Website: https://www.keenthemes.com
Support: https://devs.keenthemes.com
Follow: https://www.twitter.com/keenthemes
License: https://keenthemes.com/metronic/tailwind/docs/getting-started/license
-->
<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" lang="en">
 <head><base href="../../">
  <title>
   Metronic - Tailwind CSS
  </title>
  <meta charset="utf-8"/>
  <meta content="follow, index" name="robots"/>
  <link href="https://keenthemes.com/metronic" rel="canonical"/>
  <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
  <meta content="" name="description"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta content="@keenthemes" name="twitter:site"/>
  <meta content="@keenthemes" name="twitter:creator"/>
  <meta content="summary_large_image" name="twitter:card"/>
  <meta content="Metronic - Tailwind CSS " name="twitter:title"/>
  <meta content="" name="twitter:description"/>
  <meta content="assets/media/app/og-image.png" name="twitter:image"/>
  <meta content="https://keenthemes.com/metronic" property="og:url"/>
  <meta content="en_US" property="og:locale"/>
  <meta content="website" property="og:type"/>
  <meta content="@keenthemes" property="og:site_name"/>
  <meta content="Metronic - Tailwind CSS " property="og:title"/>
  <meta content="" property="og:description"/>
  <meta content="assets/media/app/og-image.png" property="og:image"/>
  <link href="assets/media/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180"/>
  <link href="assets/media/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png"/>
  <link href="assets/media/app/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png"/>
  <link href="assets/media/app/favicon.ico" rel="shortcut icon"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="assets/vendors/apexcharts/apexcharts.css" rel="stylesheet"/>
  <link href="assets/vendors/keenicons/styles.bundle.css" rel="stylesheet"/>
  <link href="assets/css/styles.css" rel="stylesheet"/>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @vite(['resources/css/app.scss', 'resources/js/app.js'])
 </head>
 <body class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:#f6f6f6] [--tw-page-bg-dark:var(--tw-coal-200)] [--tw-content-bg:var(--tw-light)] [--tw-content-bg-dark:var(--tw-coal-500)] [--tw-content-scrollbar-color:#e8e8e8] [--tw-header-height:58px] [--tw-sidebar-width:58px] [--tw-navbar-height:56px] bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark] lg:overflow-hidden">
  <!-- Theme Mode -->
  <script>
   const defaultThemeMode = 'light'; // light|dark|system
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
  <!-- Page -->
  <!-- Base -->
  <div class="flex flex-col grow">
   <!-- Header -->
   <header class="flex items-center fixed z-10 top-0 left-0 right-0 shrink-0 h-[--tw-header-height] bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]" id="header">
    <!-- Container -->
    <div class="container-fluid flex justify-between items-stretch px-5 lg:ps-0 lg:gap-4" id="header_container">
     <div class="flex items-center">
      <div class="flex items-center justify-center lg:w-[--tw-sidebar-width] gap-2 shrink-0">
       <button class="btn btn-icon btn-light btn-clear btn-sm -ms-2 lg:hidden" data-drawer-toggle="#sidebar">
        <i class="ki-filled ki-menu">
        </i>
       </button>
       <a href="html/demo3.html">
        <img class="dark:hidden min-h-[24px]" src="assets/media/app/mini-logo-primary.svg"/>
        <img class="hidden dark:block min-h-[24px]" src="assets/media/app/mini-logo-primary-dark.svg"/>
       </a>
      </div>
      <div class="flex items-center">
       <h3 class="text-gray-700 text-base hidden md:block">
        Condominio Campestre El Peñón    
            <span class="text-sm text-gray-400 font-medium px-2.5 hidden md:inline">
            /
           </span>
           Maps
       </h3>
 
      </div>
     </div>
     <!-- End of Logo -->
     <!-- Topbar -->
     <div class="flex items-center gap-1.5 lg:gap-3.5">
   
      <div class="menu" data-menu="true">
       <div class="menu-item" data-menu-item-offset="0px, 9px" data-menu-item-placement="bottom-end" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
        <div class="menu-toggle btn btn-icon rounded-full">
         <img alt="" class="size-8 rounded-full justify-center border border-gray-500 shrink-0" src="assets/media/avatars/gray/5.png">
         </img>
        </div>
        <div class="menu-dropdown menu-default light:border-gray-300 w-screen max-w-[250px]">
         <div class="flex items-center justify-between px-5 py-1.5 gap-1.5">
          <div class="flex items-center gap-2">
           <img alt="" class="size-9 rounded-full border-2 border-success" src="assets/media/avatars/300-2.png">
            <div class="flex flex-col gap-1.5">
             <span class="text-sm text-gray-800 font-semibold leading-none">
              Cody Fisher
             </span>
             <a class="text-xs text-gray-600 hover:text-primary font-medium leading-none" href="html/demo3/account/home/get-started.html">
              c.fisher@gmail.com
             </a>
            </div>
           </img>
          </div>
          <span class="badge badge-xs badge-primary badge-outline">
           Pro
          </span>
         </div>
         <div class="menu-separator">
         </div>
         <div class="flex flex-col">
          <div class="menu-item">
           <a class="menu-link" href="https://devs.keenthemes.com">
            <span class="menu-icon">
             <i class="ki-filled ki-message-programming">
             </i>
            </span>
            <span class="menu-title">
             Dev Forum
            </span>
           </a>
          </div>
          <div class="menu-item" data-menu-item-offset="-10px, 0" data-menu-item-placement="left-start" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:hover">
           <div class="menu-dropdown menu-default light:border-gray-300 w-full max-w-[170px]">
            <div class="menu-item active">
             <a class="menu-link h-10" href="#">
              <span class="menu-icon">
               <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/united-states.svg"/>
              </span>
              <span class="menu-title">
               English
              </span>
              <span class="menu-badge">
               <i class="ki-solid ki-check-circle text-success text-base">
               </i>
              </span>
             </a>
            </div>
            <div class="menu-item">
             <a class="menu-link h-10" href="#">
              <span class="menu-icon">
               <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/spain.svg"/>
              </span>
              <span class="menu-title">
               Spanish
              </span>
             </a>
            </div>
            <div class="menu-item">
             <a class="menu-link h-10" href="#">
              <span class="menu-icon">
               <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/germany.svg"/>
              </span>
              <span class="menu-title">
               German
              </span>
             </a>
            </div>
            <div class="menu-item">
             <a class="menu-link h-10" href="#">
              <span class="menu-icon">
               <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/japan.svg"/>
              </span>
              <span class="menu-title">
               Japanese
              </span>
             </a>
            </div>
            <div class="menu-item">
             <a class="menu-link h-10" href="#">
              <span class="menu-icon">
               <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/france.svg"/>
              </span>
              <span class="menu-title">
               French
              </span>
             </a>
            </div>
           </div>
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
           <a class="btn btn-sm btn-light justify-center" href="html/demo3/authentication/classic/sign-in.html">
             Cerrar Sesión
           </a>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
     <!-- End of Topbar -->
    </div>
    <!-- End of Container -->
   </header>
   <!-- End of Header -->
   <!-- Wrapper -->
   <div class="wrapper flex grow flex-col pt-[--tw-header-height]">
    <!-- Sidebar -->
    <div class="fixed w-[--tw-sidebar-width] lg:top-[--tw-header-height] top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 group py-3 lg:py-0" data-drawer="true" data-drawer-class="drawer drawer-start top-0 bottom-0" data-drawer-enable="true|lg:false" id="sidebar">
     <div class="flex grow shrink-0" id="sidebar_content">
      <div class="scrollable-y-auto grow gap-2.5 shrink-0 flex items-center flex-col" data-scrollable="true" data-scrollable-height="auto" data-scrollable-offset="0px" data-scrollable-wrappers="#sidebar_content">
       <a class="btn btn-icon btn-icon-lg rounded-full size-10 border border-transparent text-gray-600 hover:bg-light hover:text-primary hover:border-gray-300 [.active&]:bg-light [.active&]:text-primary [.active&]:border-gray-300" data-tooltip="" data-tooltip-placement="right" href="html/demo3.html">
        <span class="menu-icon">
         <i class="ki-filled ki-chart-line-star">
         </i>
        </span>
        <span class="tooltip">
         Dashboard
        </span>
       </a>
       <a class="btn btn-icon btn-icon-lg rounded-full size-10 border border-transparent text-gray-600 hover:bg-light hover:text-primary hover:border-gray-300 [.active&]:bg-light [.active&]:text-primary [.active&]:border-gray-300" data-tooltip="" data-tooltip-placement="right" href="html/demo3/public-profile/profiles/default.html">
        <span class="menu-icon">
         <i class="ki-filled ki-profile-circle">
         </i>
        </span>
        <span class="tooltip">
         Profile
        </span>
       </a>
       <a class="btn btn-icon btn-icon-lg rounded-full size-10 border border-transparent text-gray-600 hover:bg-light hover:text-primary hover:border-gray-300 [.active&]:bg-light [.active&]:text-primary [.active&]:border-gray-300 active" data-tooltip="" data-tooltip-placement="right" href="html/demo3/account/home/get-started.html">
        <span class="menu-icon">
         <i class="ki-filled ki-setting-2">
         </i>
        </span>
        <span class="tooltip">
         Account
        </span>
       </a>
       <a class="btn btn-icon btn-icon-lg rounded-full size-10 border border-transparent text-gray-600 hover:bg-light hover:text-primary hover:border-gray-300 [.active&]:bg-light [.active&]:text-primary [.active&]:border-gray-300" data-tooltip="" data-tooltip-placement="right" href="https://keenthemes.com/metronic/tailwind/docs/">
        <span class="menu-icon">
         <i class="ki-filled ki-question">
         </i>
        </span>
        <span class="tooltip">
         Docs
        </span>
       </a>
      </div>
     </div>
    </div>
    <!-- End of Sidebar -->
    <!-- Main -->
    <!-- Navbar -->
    <div class="flex items-stretch lg:fixed z-5 top-[--tw-header-height] start-[--tw-sidebar-width] end-5 h-[--tw-navbar-height] mx-5 lg:mx-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]" id="navbar">
     <div class="rounded-t-xl border border-gray-400 dark:border-gray-200 border-b-gray-300 dark:border-b-gray-200 bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] flex items-stretch grow">
      <!-- Container -->
      <div class="container-fluid flex justify-between items-stretch gap-5">
       <div class="grid items-stretch">
        <div class="scrollable-x-auto flex items-stretch">
         <div class="menu gap-5 lg:gap-7.5" data-menu="true">
          <div class="menu-item border-b-2 border-b-transparent menu-item-active:border-b-gray-900 menu-item-here:border-b-gray-900" data-menu-item-placement="bottom-start" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:hover">
           <div class="menu-link gap-1.5" tabindex="0">
            <span class="menu-title text-nowrap text-sm text-gray-800 menu-item-active:text-gray-900 menu-item-active:font-medium menu-item-here:text-gray-900 menu-item-here:font-medium menu-item-show:text-gray-900 menu-link-hover:text-gray-900">
             Account Home
            </span>
    
           </div>
       
          </div>
        
     
         </div>
        </div>
       </div>
      </div>
      <!-- End of Container -->
     </div>
    </div>
    <!-- End of Navbar -->
    <main class="scrollable-y-auto [scrollbar-width:auto] light:[--tw-scrollbar-thumb-color:var(--tw-content-scrollbar-color)] flex flex-col grow rounded-b-xl bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] border-x border-b border-gray-400 dark:border-gray-200 lg:mt-[--tw-navbar-height] mx-5 lg:ms-[--tw-sidebar-width] lg:me-5 pt-7 mb-5" data-scrollable="true" data-scrollable-dependencies="#header,#navbar" data-scrollable-height="false|lg:auto" data-scrollable-offset="20px" role="content">
     <!-- Container -->
     <div class="container-fluid">
        @yield('content')
     </div>
     <!-- End of Container -->
     <!-- Footer -->
     <footer class="py-3">
      <!-- Container -->
      <div class="container-fluid">
       <div class="flex flex-col md:flex-row justify-center md:justify-between items-center gap-3 py-2">
        <div class="flex order-2 md:order-1 gap-2 font-normal text-2sm">
         <span class="text-gray-500">
          2024©
         </span>
         <a class="text-gray-600 hover:text-primary" href="https://keenthemes.com">
          Keenthemes Inc.
         </a>
        </div>
        <nav class="flex order-1 md:order-2 gap-4 font-normal text-2sm text-gray-600">
         <a class="hover:text-primary" href="https://keenthemes.com/metronic/tailwind/docs">
          Docs
         </a>
         <a class="hover:text-primary" href="https://1.envato.market/Vm7VRE">
          Purchase
         </a>
         <a class="hover:text-primary" href="https://keenthemes.com/metronic/tailwind/docs/getting-started/license">
          FAQ
         </a>
         <a class="hover:text-primary" href="https://devs.keenthemes.com">
          Support
         </a>
         <a class="hover:text-primary" href="https://keenthemes.com/metronic/tailwind/docs/getting-started/license">
          License
         </a>
        </nav>
       </div>
      </div>
      <!-- End of Container -->
     </footer>
     <!-- End of Footer -->
    </main>
    <!-- End of Main -->
   </div>
   <!-- End of Wrapper -->
  </div>
  <!-- End of Base -->

  <!-- Scripts -->
  <script src="assets/js/core.bundle.js">
  </script>
  <script src="assets/vendors/apexcharts/apexcharts.min.js">
  </script>
  <script src="assets/js/widgets/general.js">
  </script>
  <!-- End of Scripts -->
  @stack('scripts')
 </body>
</html>
