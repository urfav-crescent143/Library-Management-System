
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ravenclaw Library</title>

    <style>
        /* ===== RESET ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #EFE6D6;
            /* color: #3F4438; no backgrounnd-color needed because when you apply color to main page it is invisble so why put.*/
            min-height: 100vh;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* ===== SIDEBAR ===== */
        aside {
            width: 300px;
            display: flex;
            flex-direction: column;
            background-color: #6F8060;
            position: fixed;
            inset: 0 auto 0 0;
            height: 100vh;
            z-index: 1000;
            box-shadow: 5px 0 25px rgba(63, 68, 56, 0.12);
            transition: width 0.3s ease, transform 0.3s ease;
            overflow: hidden;
        }

        .sidebar-brand {
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 80px;
            font-weight: bold;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
            background-color: #D99AA8;
            color: #F3EBDD;
            border-bottom: 3px solid #B87586;
            overflow: hidden;
        }

        .brand-text {
            transition: opacity 0.2s ease;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            padding: 24px 14px;
            gap: 8px;
            flex-grow: 1;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .nav-menu::-webkit-scrollbar {
            display: none;
        }

        .nav-menu li {
            width: 100%;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 48px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #F3EBDD;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            white-space: nowrap;
            transition: background-color 0.25s ease,
                        color 0.25s ease,
                        padding 0.25s ease;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background-color: #D99AA8;
            color: #FFFDF8;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(63, 68, 56, 0.12);
        }

        .nav-icon {
            width: 21px;
            height: 21px;
            flex-shrink: 0;
            display: block;
        }

        .nav-label {
            opacity: 1;
            transition: opacity 0.15s ease;
        }

        .sidebar-footer {
            font-size: 0.8rem;
            color: #E4E8D9;
            padding: 24px 12px;
            text-align: center;
            font-weight: 500;
            border-top: 2px dashed rgba(243, 235, 221, 0.3);
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }

        /* ===== COLLAPSED SIDEBAR ===== */
        body.sidebar-collapsed aside {
            width: 84px;
        }

        body.sidebar-collapsed .sidebar-brand {
            padding: 12px;
            font-size: 1.5rem;
        }

        body.sidebar-collapsed .brand-text,
        body.sidebar-collapsed .nav-label,
        body.sidebar-collapsed .sidebar-footer {
            display: none;
        }

        body.sidebar-collapsed .nav-menu {
            padding: 24px 12px;
        }

        body.sidebar-collapsed .nav-menu a {
            justify-content: center;
            padding: 13px 0;
        }

        body.sidebar-collapsed .nav-icon {
            width: 23px;
            height: 23px;
        }

        /* ===== MAIN CONTENT ===== */
        main {
            margin-left: 300px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #EFE6D6;
            transition: margin-left 0.3s ease;
        }

        body.sidebar-collapsed main {
            margin-left: 84px;
        }

        /* ===== HEADER ===== */
        header {
            display: flex;
            align-items: center;
            gap: 20px;
            min-height: 80px;
            padding: 0 32px;
            background: linear-gradient(
                135deg,
                #F8E6E9,
                #F3EBDD,
                #DDE4D0
            );
            border-bottom: 3px solid #E8C1C8;
            box-shadow: 0 4px 20px rgba(63, 68, 56, 0.04);
            flex-shrink: 0;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
            flex: 1;
        }

        header h1 {
            font-size: 1.5rem;
            color: #5F7053;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        /* ===== HAMBURGER BUTTON ===== */
        .sidebar-toggle {
            background: none;
            border: none;
            box-shadow: none;
            color: #3F4438;
            font-size: 28px;
            cursor: pointer;
            padding: 0;
            outline: none;
        }

        
        .sidebar-toggle,
        .sidebar-toggle:hover,
        .sidebar-toggle:focus,
        .sidebar-toggle:active {
            background: transparent;
            border: none;
            box-shadow: none;
            outline: none;
        }

        .sidebar-toggle:hover {
            color: #B87586;
        }



        .sidebar-toggle svg {
            width: 23px;
            height: 23px;
        }

        /* ===== PROFILE ===== */
        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 14px;
            border-radius: 30px;
            background-color: #FFFDF8;
            transition: background-color 0.2s ease;
            flex-shrink: 0;
        }

        .profile:hover {
            background-color: #F5E1E4;
        }

        .profile span {
            font-weight: 600;
            color: #5F7053;
            font-size: 0.9rem;
        }

        .profile img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #D99AA8;
            box-shadow: 0 2px 8px rgba(184, 117, 134, 0.2);
        }

        /* ===== PAGE CONTENT ===== */
        .content-body {
            padding: 36px 40px;
            flex-grow: 1;
            min-width: 0;
        }

        /* ===== MOBILE OVERLAY ===== */
        .sidebar-overlay {
            display: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            aside {
                width: 280px;
                transform: translateX(-100%);
            }

            main,
            body.sidebar-collapsed main {
                margin-left: 0;
            }

            body.sidebar-open aside {
                transform: translateX(0);
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 900;
                background: rgba(44, 48, 39, 0.4);
            }

            body.sidebar-collapsed aside {
                width: 280px;
            }

            body.sidebar-collapsed .brand-text,
            body.sidebar-collapsed .nav-label,
            body.sidebar-collapsed .sidebar-footer {
                display: initial;
            }

            body.sidebar-collapsed .sidebar-brand {
                font-size: 1.3rem;
            }

            body.sidebar-collapsed .nav-menu a {
                justify-content: flex-start;
                padding: 12px 16px;
            }

            header {
                padding: 0 18px;
                gap: 12px;
            }

            header h1 {
                font-size: 1.2rem;
            }

            .header-left {
                gap: 12px;
            }

            .profile {
                gap: 8px;
                padding: 4px;
                background: transparent;
            }

            .profile span {
                display: none;
            }

            .profile img {
                width: 35px;
                height: 35px;
            }

            .content-body {
                padding: 24px 18px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                transition-duration: 0.01ms !important;
            }
        }
        .logout-button {
            background-color: #6F8060;
            color: #FFFDF8;
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .logout-button:hover {
            background-color: #526548;
        }
    </style>
</head>

<body>

    <!-- ICON LIBRARY -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
        <symbol id="icon-dashboard" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="9" rx="1"/>
            <rect x="14" y="3" width="7" height="5" rx="1"/>
            <rect x="14" y="12" width="7" height="9" rx="1"/>
            <rect x="3" y="16" width="7" height="5" rx="1"/>
        </symbol>

        <symbol id="icon-books" viewBox="0 0 24 24">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
            <path d="M8 7h8M8 11h6"/>
        </symbol>

        <symbol id="icon-categories" viewBox="0 0 24 24">
            <path d="m20.59 13.41-7.17 7.17a2 2 0 0 1-2.83 0L3.4 13.4a2 2 0 0 1-.59-1.41V4a1 1 0 0 1 1-1h8a2 2 0 0 1 1.41.59l7.37 7.37a2 2 0 0 1 0 2.83Z"/>
            <circle cx="7.5" cy="7.5" r=".5"/>
        </symbol>

        <symbol id="icon-authors" viewBox="0 0 24 24">
            <path d="M12 20h9"/>
            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
            <path d="M15 5l4 4"/>
        </symbol>

        <symbol id="icon-members" viewBox="0 0 24 24">
            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="10" cy="7" r="4"/>
            <path d="M20 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </symbol>

        <symbol id="icon-borrowings" viewBox="0 0 24 24">
            <path d="M17 3h4v4"/>
            <path d="M21 3 14 10"/>
            <path d="M7 21H3v-4"/>
            <path d="m3 21 7-7"/>
            <path d="M14 14h7v7"/>
            <path d="m21 14-7 7"/>
            <path d="M3 3l7 7"/>
        </symbol>

        <symbol id="icon-returns" viewBox="0 0 24 24">
            <path d="M9 14 4 9l5-5"/>
            <path d="M4 9h10a6 6 0 0 1 0 12h-2"/>
        </symbol>

        <symbol id="icon-reservations" viewBox="0 0 24 24">
            <path d="M6 3h12a2 2 0 0 1 2 2v16l-8-4-8 4V5a2 2 0 0 1 2-2Z"/>
            <path d="M9 8h6M9 12h6"/>
        </symbol>

        <symbol id="icon-fines" viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="14" rx="2"/>
            <path d="M3 10h18"/>
            <path d="M7 15h3"/>
            <path d="M16 14v2"/>
            <path d="M16 12h.01"/>
        </symbol>

        <symbol id="icon-reports" viewBox="0 0 24 24">
            <path d="M3 3v18h18"/>
            <path d="m19 9-5 5-4-4-5 5"/>
            <path d="M15 9h4v4"/>
        </symbol>

        <symbol id="icon-menu" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16"/>
        </symbol>
    </svg>

    <!-- SIDEBAR -->
    <aside id="sidebar">

        <div class="sidebar-brand">
            <span class="brand-text">Wingardium Leviosa</span>
        </div>

        <ul class="nav-menu">

            <li>
                <a href="{{ route('dashboards.index') }}"
                   class="{{ request()->routeIs('dashboards.*') ? 'active' : '' }}"
                   title="Dashboard">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-dashboard"/>
                    </svg>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('books.index') }}"
                   class="{{ request()->routeIs('books.*') ? 'active' : '' }}"
                   title="Books">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-books"/>
                    </svg>
                    <span class="nav-label">Books</span>
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}"
                   class="{{ request()->routeIs('categories.*') ? 'active' : '' }}"
                   title="Categories">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-categories"/>
                    </svg>
                    <span class="nav-label">Categories</span>
                </a>
            </li>

            <li>
                <a href="{{ route('authors.index') }}"
                   class="{{ request()->routeIs('authors.*') ? 'active' : '' }}"
                   title="Authors">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-authors"/>
                    </svg>
                    <span class="nav-label">Authors</span>
                </a>
            </li>

            <li>
                <a href="{{ route('members.index') }}"
                   class="{{ request()->routeIs('members.*') ? 'active' : '' }}"
                   title="Members">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-members"/>
                    </svg>
                    <span class="nav-label">Members</span>
                </a>
            </li>

            <li>
                <a href="{{ route('borrowings.index') }}"
                   class="{{ request()->routeIs('borrowings.*') ? 'active' : '' }}"
                   title="Borrowings">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-borrowings"/>
                    </svg>
                    <span class="nav-label">Borrowings</span>
                </a>
            </li>

            <li>
                <a href="{{ route('returns.index') }}"
                   class="{{ request()->routeIs('returns.*') ? 'active' : '' }}"
                   title="Returns">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-returns"/>
                    </svg>
                    <span class="nav-label">Returns</span>
                </a>
            </li>

            <li>
                <a href="{{ route('reservations.index') }}"
                   class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}"
                   title="Reservations">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-reservations"/>
                    </svg>
                    <span class="nav-label">Reservations</span>
                </a>
            </li>

            <li>
                <a href="{{ route('fines.index') }}"
                   class="{{ request()->routeIs('fines.*') ? 'active' : '' }}"
                   title="Fines">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-fines"/>
                    </svg>
                    <span class="nav-label">Fines</span>
                </a>
            </li>

            <li>
                <a href="{{ route('reports.index') }}"
                   class="{{ request()->routeIs('reports.*') ? 'active' : '' }}"
                   title="Reports">
                    <svg class="nav-icon" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-reports"/>
                    </svg>
                    <span class="nav-label">Reports</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-footer">
            Matcha Core Flavor
        </div>

    </aside>

    <!-- MOBILE OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- MAIN CONTENT -->
    <main>

        <header>

            <div class="header-left">

                <button type="button"
                        class="sidebar-toggle"
                        id="sidebarToggle"
                        aria-label="Toggle sidebar"
                        aria-controls="sidebar"
                        aria-expanded="true"
                        title="Open or close sidebar">

                    <svg fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <use href="#icon-menu"/>
                    </svg>

                </button>

                <h1>@yield('page-title')</h1>

            </div>

            <div class="profile">
                <span>Librarian</span>
                <img
                    src="https://i.pinimg.com/1200x/87/cf/66/87cf669e32e45d2bdf0e50b39564f7cd.jpg"
                    alt="Profile Icon"
                >
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">
                    Log Out
                </button>
            </form>


        </header>

        <div class="content-body">
            @yield('content')
        </div>

    </main>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function isMobile() {
            return window.innerWidth <= 768;
        }

        sidebarToggle.addEventListener('click', function () {
            if (isMobile()) {
                document.body.classList.toggle('sidebar-open');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
            }

            updateToggleState();
        });

        sidebarOverlay.addEventListener('click', function () {
            document.body.classList.remove('sidebar-open');
            updateToggleState();
        });

        function updateToggleState() {
            const expanded = isMobile()
                ? document.body.classList.contains('sidebar-open')
                : !document.body.classList.contains('sidebar-collapsed');

            sidebarToggle.setAttribute('aria-expanded', String(expanded));
        }

        window.addEventListener('resize', function () {
            if (!isMobile()) {
                document.body.classList.remove('sidebar-open');
            }

            updateToggleState();
        });

        updateToggleState();
    </script>

</body>
</html>

