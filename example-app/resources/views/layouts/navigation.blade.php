<nav x-data="{ open: false, tasksOpen: false }" class="bg-white border-b border-gray-100">
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
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- My Tasks Dropdown and Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:gap-4">
                <!-- My Tasks Dropdown -->
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

                <!-- Settings Dropdown -->
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
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('customer.tasks.all')" :active="request()->routeIs('customer.tasks.all')">
                {{ __('My Tasks') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
