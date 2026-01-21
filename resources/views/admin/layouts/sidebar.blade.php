<aside class="sidebar" id="sidebar">
    <div class="sidebar-nav">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer2"></i>
            <span class="nav-label">Dashboard</span>
        </a>

        <!-- Master Data -->
        <ul>
            <li class="sidebar-item has-submenu
                {{ request()->routeIs('admin.asset.class.*')
                || request()->routeIs('admin.type.*')
                || request()->routeIs('admin.strategie.*')
                || request()->routeIs('admin.category.*')
                || request()->routeIs('admin.risk.rating.*')
                || request()->routeIs('admin.firms.*')
                ? 'open active' : '' }}">

                <a href="javascript:void(0);" class="nav-item sidebar-link">
                    <i class="nav-icon bi bi-tree-fill"></i>
                    <span class="nav-label">Master Data</span>
                    <i class="bi bi-chevron-down ms-auto arrow"></i>
                </a>

                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.firms.list') }}"
                            class="{{ request()->routeIs('admin.firms.*') ? 'active' : '' }}">
                            <i class="bi bi-building"></i>
                            <span>Firm</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.asset.class.list') }}"
                            class="{{ request()->routeIs('admin.asset.class.*') ? 'active' : '' }}">
                            <i class="bi bi-boxes"></i>
                            <span>Asset Class</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.type.list') }}"
                            class="{{ request()->routeIs('admin.type.*') ? 'active' : '' }}">
                            <i class="bi bi-tags"></i>
                            <span>Types</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.strategie.list') }}"
                            class="{{ request()->routeIs('admin.strategie.*') ? 'active' : '' }}">
                            <i class="bi bi-lightning-fill"></i>
                            <span>Strategies</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.category.list') }}"
                            class="{{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                            <i class="bi bi-collection"></i>
                            <span>Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.risk.rating.list') }}"
                            class="{{ request()->routeIs('admin.risk.rating.*') ? 'active' : '' }}">
                            <i class="bi bi-exclamation-triangle"></i>
                            <span>Risk Rating</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Fund -->
        <a href="{{ route('admin.funds.list') }}"
            class="nav-item {{ request()->routeIs('admin.funds.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-wallet2"></i>
            <span class="nav-label">Fund</span>
        </a>

        <!-- Import Jobs -->
        <a href="{{ route('admin.import-jobs.list') }}"
            class="nav-item {{ request()->routeIs('admin.import-jobs.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-upload"></i>
            <span class="nav-label">Import Jobs</span>
        </a>

        <a href="{{ route('admin.import-job-rows.list') }}"
            class="nav-item {{ request()->routeIs('admin.import-job-rows.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-check2-square"></i>
            <span class="nav-label">Import Rows</span>
        </a>

        <a href="{{ route('admin.validated-import-row.list') }}"
            class="nav-item {{ request()->routeIs('admin.validated-import-row.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-file-check"></i>
            <span class="nav-label">Montly Returns</span>
        </a>
        
        <a href="{{ route('admin.fund.performance.list') }}"
            class="nav-item {{ request()->routeIs('admin.fund.performance.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-bar-chart-line"></i>
            <span class="nav-label">Fund Snapshots</span>
        </a>
        
        <!-- Subscriptions -->
        <a href="{{ route('admin.subscriptions.list') }}"
            class="nav-item {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-card-list"></i>
            <span class="nav-label">Subscriptions</span>
        </a>

        <a href="{{ route('admin.users.list') }}"
            class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people"></i>
            <span class="nav-label">User Management</span>
        </a>

        <!-- Freemium Gating -->
        <ul>
            <li
                class="sidebar-item has-submenu
        {{ request()->routeIs('admin.access.rule.*') || request()->routeIs('admin.plan.access.*') ? 'open active' : '' }}">

                <a href="javascript:void(0);" class="nav-item sidebar-link">
                    <i class="nav-icon bi bi-shield-lock"></i>
                    <span class="nav-label">Freemium</span>
                    <i class="bi bi-chevron-down ms-auto arrow"></i>
                </a>

                <ul class="submenu">
                    <!-- Access Rule -->
                    <li>
                        <a href="{{ route('admin.access.rule.list') }}"
                            class="{{ request()->routeIs('admin.access.rule.*') ? 'active' : '' }}">
                            <i class="bi bi-card-checklist"></i>
                            <span>Access Rule</span>
                        </a>
                    </li>

                    <!-- Plan Access -->
                    <li>
                        <a href="{{ route('admin.plan.access.list') }}"
                            class="{{ request()->routeIs('admin.plan.access.*') ? 'active' : '' }}">
                            <i class="bi bi-key-fill"></i>
                            <span>Plan Access</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>


        <!-- Website Management -->
        <ul>
            <li class="sidebar-item has-submenu
                {{ request()->routeIs('admin.pages.*')
                || request()->routeIs('admin.banner.*')
                || request()->routeIs('admin.blog.*')
                || request()->routeIs('admin.contact.*')
                || request()->routeIs('admin.newsletter-subscribe.*')
                || request()->routeIs('admin.auth.user.*')
                || request()->routeIs('admin.value.*')
                || request()->routeIs('admin.settings.*')
                || request()->routeIs('admin.web.page.*')
                ? 'open active' : '' }}">

                <a href="javascript:void(0);" class="nav-item sidebar-link">
                    <i class="nav-icon bi bi-globe"></i>
                    <span class="nav-label">CMS</span>
                    <i class="bi bi-chevron-down ms-auto arrow"></i>
                </a>

                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.pages.list') }}"
                            class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                            <i class="bi bi-file-text"></i>
                            <span>Page</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.web.page.list') }}"
                            class="{{ request()->routeIs('admin.web.page.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i>
                            <span>Web Pages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.banner.list') }}"
                            class="{{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
                            <i class="bi bi-image"></i>
                            <span>Banner</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog.list') }}"
                            class="{{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                            <i class="bi bi-newspaper"></i>
                            <span>Blogs</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.contact.list') }}"
                            class="{{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                            <i class="bi bi-envelope"></i>
                            <span>Contact</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.newsletter-subscribe.list') }}"
                            class="{{ request()->routeIs('admin.newsletter-subscribe.*') ? 'active' : '' }}">
                            <i class="bi bi-newspaper"></i>
                            <span>Subscribe</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.auth.user.list') }}"
                            class="{{ request()->routeIs('admin.auth.user.*') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock"></i>
                            <span>Auth Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.value.list') }}"
                            class="{{ request()->routeIs('admin.value.*') ? 'active' : '' }}">
                            <i class="bi bi-award"></i>
                            <span>Our Values</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.edit') }}"
                            class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Account -->
        <div class="nav-section">Account</div>

        <a href="{{ route('admin.profile') }}"
            class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <i class="nav-icon bi bi-person"></i>
            <span class="nav-label">Profile</span>
        </a>

        <a href="{{ route('admin.password.change') }}" class="nav-item">
            <i class="nav-icon bi bi-key"></i>
            <span class="nav-label">Change Password</span>
        </a>

        <form method="POST" action="{{ route('admin.logout') }}" class="nav-item">
            @csrf
            <button type="submit" class="btn btn-link nav-link p-0 m-0 text-start">
                <i class="nav-icon bi bi-box-arrow-right"></i>
                <span class="nav-label">Logout</span>
            </button>
        </form>

    </div>
</aside>