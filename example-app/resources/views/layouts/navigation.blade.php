<nav x-data="{ open: false, tasksOpen: false }" class="{{ Auth::user()->isAdmin() ? 'bg-[#001f3f] border-b border-[#003366]' : 'bg-white border-b border-gray-100' }}">
    <style>
        .tasks-dropdown-container {
            position: relative;
        }
        
        .tasks-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 1200px;
            max-height: 600px;
            overflow-y: auto;
            padding: 1rem;
            z-index: 50;
        }
        
        .tasks-dropdown-menu.hidden {
            display: none;
        }
        
        .tasks-columns-wrapper {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        
        .task-column {
            background-color: #f9fafb;
            border-radius: 0.375rem;
            padding: 1rem;
            min-height: 400px;
            max-height: 500px;
            overflow-y: auto;
            border-top: 4px solid;
        }
        
        .task-column.to-do {
            border-top-color: #9ca3af;
        }
        
        .task-column.in-progress {
            border-top-color: #f59e0b;
        }
        
        .task-column.done {
            border-top-color: #10b981;
        }
        
        .task-column.review {
            border-top-color: #7b1fa2;
        }
        
        .task-column-header {
            font-weight: 600;
            font-size: 0.875rem;
            color: #1f2937;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .task-count-badge {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .task-item {
            background-color: white;
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
            border-left: 3px solid #001f3f;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        
        .task-item:hover {
            background-color: #f3f4f6;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .task-title {
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 0.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .task-project {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }
        
        .task-category {
            display: inline-block;
            font-size: 0.625rem;
            padding: 0.25rem 0.5rem;
            background-color: #e0e7ff;
            color: #4338ca;
            border-radius: 0.25rem;
        }
    </style>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        @if(Auth::user()->isAdmin())
                            <span class="text-xl font-bold text-white tracking-tight">ManageX</span>
                        @else
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        @endif
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex sm:items-center">
                    @if(Auth::user()->isAdmin())
                        {{-- Admin Navigation Links --}}
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.register-user.form') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.register-user.*') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Register User
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Manage Profiles
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.projects.*') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Manage Project
                        </a>
                        <a href="{{ route('admin.tasks.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.tasks.*') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            Manage Task
                        </a>
                        <a href="{{ route('admin.notifications') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition relative {{ request()->routeIs('admin.notifications') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            Notification
                        </a>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- My Tasks Dropdown and Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:gap-4">
                <!-- My Tasks Dropdown (hidden for admin users) -->
                @if(!Auth::user()->isAdmin())
                <div class="tasks-dropdown-container" @click.away="tasksOpen = false">
                    <button @click="tasksOpen = !tasksOpen" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="ms-2">My Tasks</span>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" :class="{'rotate-180': tasksOpen}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div class="tasks-dropdown-menu" :class="{ 'hidden': !tasksOpen }">
                        @php
                            $userTasks = Auth::user()->createdTasks()->with('project')->get();
                            $tasksByStatus = $userTasks->groupBy('status');
                        @endphp

                        <div class="tasks-columns-wrapper">
                            <!-- To Do Column -->
                            <div class="task-column to-do">
                                <div class="task-column-header">
                                    <span>To Do</span>
                                    <span class="task-count-badge">{{ $tasksByStatus->get('to_do', collect())->count() }}</span>
                                </div>
                                @forelse ($tasksByStatus->get('to_do', collect()) as $task)
                                    <a href="{{ route('customer.tasks.show', $task) }}" class="task-item" style="text-decoration: none;">
                                        <div class="task-title">{{ $task->title }}</div>
                                        <div class="task-project">{{ $task->project->name ?? 'No Project' }}</div>
                                        @if($task->category)
                                            <span class="task-category">{{ $task->category->value }}</span>
                                        @endif
                                    </a>
                                @empty
                                    <p class="text-gray-400 text-sm">No tasks</p>
                                @endforelse
                            </div>

                            <!-- In Progress Column -->
                            <div class="task-column in-progress">
                                <div class="task-column-header">
                                    <span>In Progress</span>
                                    <span class="task-count-badge">{{ $tasksByStatus->get('in_progress', collect())->count() }}</span>
                                </div>
                                @forelse ($tasksByStatus->get('in_progress', collect()) as $task)
                                    <a href="{{ route('customer.tasks.show', $task) }}" class="task-item" style="text-decoration: none;">
                                        <div class="task-title">{{ $task->title }}</div>
                                        <div class="task-project">{{ $task->project->name ?? 'No Project' }}</div>
                                        @if($task->category)
                                            <span class="task-category">{{ $task->category->value }}</span>
                                        @endif
                                    </a>
                                @empty
                                    <p class="text-gray-400 text-sm">No tasks</p>
                                @endforelse
                            </div>

                            <!-- Done Column -->
                            <div class="task-column done">
                                <div class="task-column-header">
                                    <span>Done</span>
                                    <span class="task-count-badge">{{ $tasksByStatus->get('done', collect())->count() }}</span>
                                </div>
                                @forelse ($tasksByStatus->get('done', collect()) as $task)
                                    <a href="{{ route('customer.tasks.show', $task) }}" class="task-item" style="text-decoration: none;">
                                        <div class="task-title">{{ $task->title }}</div>
                                        <div class="task-project">{{ $task->project->name ?? 'No Project' }}</div>
                                        @if($task->category)
                                            <span class="task-category">{{ $task->category->value }}</span>
                                        @endif
                                    </a>
                                @empty
                                    <p class="text-gray-400 text-sm">No tasks</p>
                                @endforelse
                            </div>

                            <!-- Review Column -->
                            <div class="task-column review">
                                <div class="task-column-header">
                                    <span>Review</span>
                                    <span class="task-count-badge">{{ $tasksByStatus->get('review', collect())->count() }}</span>
                                </div>
                                @forelse ($tasksByStatus->get('review', collect()) as $task)
                                    <a href="{{ route('customer.tasks.show', $task) }}" class="task-item" style="text-decoration: none;">
                                        <div class="task-title">{{ $task->title }}</div>
                                        <div class="task-project">{{ $task->project->name ?? 'No Project' }}</div>
                                        @if($task->category)
                                            <span class="task-category">{{ $task->category->value }}</span>
                                        @endif
                                    </a>
                                @empty
                                    <p class="text-gray-400 text-sm">No tasks</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Settings Dropdown -->
                @if(Auth::user()->isAdmin())
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-white/20 text-sm leading-4 font-medium rounded-lg text-white bg-white/10 hover:bg-white/20 focus:outline-none transition ease-in-out duration-150">
                            <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center mr-2 text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Admin Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md {{ Auth::user()->isAdmin() ? 'text-gray-300 hover:text-white hover:bg-white/10' : 'text-gray-400 hover:text-gray-500 hover:bg-gray-100' }} focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden {{ Auth::user()->isAdmin() ? 'bg-[#001f3f]' : '' }}">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-white bg-white/15' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">Dashboard</a>
                <a href="{{ route('admin.register-user.form') }}" class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.register-user.*') ? 'text-white bg-white/15' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">Register User</a>
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'text-white bg-white/15' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">Manage Profiles</a>
                <a href="{{ route('admin.projects.index') }}" class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.projects.*') ? 'text-white bg-white/15' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">Manage Project</a>
                <a href="{{ route('admin.tasks.index') }}" class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.tasks.*') ? 'text-white bg-white/15' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">Manage Task</a>
                <a href="{{ route('admin.notifications') }}" class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.notifications') ? 'text-white bg-white/15' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">Notification</a>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customer.tasks.all')" :active="request()->routeIs('customer.tasks.all')">
                    {{ __('My Tasks') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 {{ Auth::user()->isAdmin() ? 'border-t border-white/20' : 'border-t border-gray-200' }}">
            <div class="px-4">
                <div class="font-medium text-base {{ Auth::user()->isAdmin() ? 'text-white' : 'text-gray-800' }}">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm {{ Auth::user()->isAdmin() ? 'text-gray-400' : 'text-gray-500' }}">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-white/10">Admin Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-white/10">Log Out</button>
                    </form>
                @else
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @endif
            </div>
        </div>
    </div>
</nav>
