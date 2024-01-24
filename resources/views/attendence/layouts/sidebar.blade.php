<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-text fs-1 menu-text fw-bolder ms-2">AMS</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <ul class="menu-inner py-2">
        <!-- Dashboard -->
        <li class="menu-item nav-item {{ request()->routeIs('home*') ? 'active' : '' }} ">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @if (Auth::user()->role->name == 'super admin')
            <li class="menu-item nav-item {{ request()->routeIs('company*') ? 'active' : '' }} ">
                <a href="{{ route('company.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-building-o" aria-hidden="true"></i>
                    <div data-i18n="Analytics">Company</div>
                </a>
            </li>
            <li class="menu-item nav-item {{ request()->routeIs('user*') ? 'active' : '' }} ">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Analytics">User</div>
                </a>
            </li>
            <li class="menu-item nav-item {{ request()->routeIs('role*') ? 'active' : '' }} ">
                <a href="{{ route('role.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons  fa-brands fa-critical-role"></i>
                    <div data-i18n="Analytics">Role</div>
                </a>
            </li>
            <li class="menu-item nav-item {{ request()->routeIs('manage*') ? 'active' : '' }} ">
                <a href="{{ route('manage.index') }}" class="menu-link">
                    <i class=" menu-icon tf-icons fa-solid fa-user-secret"></i>
                    <div data-i18n="Analytics">Manage Permission</div>
                </a>
            </li>
        @else
            @if (Auth::user()->user_company_relations->count() > 0)
                <li
                    class="menu-item {{ request()->routeIs('company*') || request()->routeIs('user*') || request()->routeIs('role*') || request()->routeIs('manage*') || Request::is('attendance*') ? 'active' : '' }}">
                    <a href="#" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa fa-building-o" aria-hidden="true"></i>
                        <div data-i18n="Company">Company</div>
                    </a>
                    <ul class="menu-sub ps-1">
                        @foreach (Auth::user()->user_company_relations as $company)
                            <li class="menu-item {{ request('id') == $company->company->id ? 'active' : '' }}">
                                <a href="{{ route('company.index', ['id' => $company->company->id]) }}"
                                    class="menu-link menu-toggle">
                                    <i class="menu-icon tf-icons bx bx-buildings"></i>
                                    <div data-i18n="User">{{ $company->company->name }}</div>
                                </a>
                                <ul class="menu-sub ps-4">
                                    <li id="menu1"
                                        class="menu-item {{ request()->routeIs('user*') && request('id') == $company->company->id ? 'active' : '' }}">
                                        <a href="{{ route('user.index', ['id' => $company->company->id]) }}"
                                            class="menu-link">
                                            <i class="menu-icon tf-icons bx bx-user-circle"></i>
                                            <div data-i18n="User">User</div>
                                        </a>
                                    </li>
                                    @if (Auth::user()->role->name == 'super admin' || Auth::user()->role->name == 'admin')
                                        <li id="menu1"
                                            class="menu-item {{ request()->routeIs('role*') && request('id') == $company->company->id ? 'active' : '' }}">
                                            <a href="{{ route('role.index', ['id' => $company->company->id]) }}"
                                                class="menu-link">
                                                <i class="menu-icon tf-icons  fa-brands fa-critical-role"></i>
                                                <div data-i18n="Role">Role</div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->role->name == 'super admin' || Auth::user()->role->name == 'admin')
                                        <li id="menu1"
                                            class="menu-item {{ request()->routeIs('manage*') && request('id') == $company->company->id ? 'active' : '' }}">
                                            <a href="{{ route('manage.index', ['id' => $company->company->id]) }}"
                                                class="menu-link">
                                                <i class=" menu-icon tf-icons fa-solid fa-user-secret"></i>
                                                <div data-i18n="Manage Permission">Manage Permission</div>
                                            </a>
                                        </li>
                                    @endif
                                    @php
                                        if (session()->has('cnt')) {
                                            $cnt = session()->get('cnt');
                                        } else {
                                            $cnt = 0;
                                        }
                                    @endphp
                                    {{-- @if (Auth::user()->role->name == 'admin' || Auth::user()->role->name == 'user' || Auth::user()->role->name == 'manager') --}}
                                    @if ($cnt > 0 || Auth::user()->role->name == 'user' || Auth::user()->role->name == 'admin')
                                        <li id="menu1"
                                            class="menu-item {{ request()->routeIs('attendance*') && request('id') == $company->company->id ? 'active' : '' }}">
                                            <a href="{{ route('attendance.index', ['id' => $company->company->id]) }}"
                                                class="menu-link">
                                                <i class="menu-icon tf-icons fa fa-calendar-o" aria-hidden="true"></i>
                                                <div data-i18n="Attendance">Attendance</div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                    {{--
                        <div id="currentURLContainer">
                        </div> --}}
                </li>
            @else
                <li class="menu-item {{ Request::is('company*') ? 'active' : ' ' }}">
                    <a href="{{ route('company.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa fa-building-o" aria-hidden="true"></i>
                        <div data-i18n="Attendance">Company</div>
                    </a>
                </li>
            @endif
        @endif
    </ul>
</aside>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all menu items and their associated submenus
        const menuItems = document.querySelectorAll(".menu-item");
        const menuSubs = document.querySelectorAll(".menu-sub");
        // Add click event listeners to each menu item
        menuItems.forEach(function(menuItem, index) {
            menuItem.addEventListener("click", function() {
                // Toggle the display of the associated submenu
                if (menuItem.classList.contains("active")) {
                    menuSubs[index].style.display = "none"; //hide menu subs
                    menuItem.classList.remove("active"); // remove active request

                } else {
                    menuSubs[index].style.display = "none"; //hide menu subs

                    menuItem.classList.add("active"); // add active request
                }

                menuItems.forEach(function(menuItem, index) {
                    menuItem.addEventListener("click", function(event) {
                        event
                            .stopPropagation(); // Prevent click event from bubbling up

                        // Check if the clicked menu item has a submenu
                        if (menuSubs[index]) {
                            toggleActiveAndSubmenu(index);
                        } else {
                            // If there's no submenu, find the closest parent with a submenu
                            let parentItem = menuItem.closest(".menu-item");
                            while (parentItem) {
                                let parentIndex = Array.from(menuItems).indexOf(
                                    parentItem);
                                toggleActiveAndSubmenu(parentIndex);
                                parentItem = parentItem.closest(".menu-item");
                            }
                        }
                    });
                });
            });
        });
    });
</script>
