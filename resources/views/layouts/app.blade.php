<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: true }" class="bg-[#F8F9FA] text-gray-800 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="bg-white border-r border-gray-200 flex flex-col justify-between shrink-0 transition-all duration-300"
           :class="sidebarOpen ? 'w-64' : 'w-20'">
        
        <div>
            <div class="h-16 flex items-center border-b border-gray-100 transition-all duration-300"
                 :class="sidebarOpen ? 'justify-between px-6' : 'justify-center px-0'">
                
                <div class="flex items-center gap-3" x-show="sidebarOpen">
                    <div class="w-6 h-6 bg-slate-800 rounded-sm flex items-center justify-center shrink-0">
                        <div class="w-3 h-3 bg-white rounded-full"></div>
                    </div>
                    <span class="font-bold text-lg tracking-wide text-slate-800">ERP</span>
                </div>

                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="2"></rect>
                        <line x1="9" y1="3" x2="9" y2="21" stroke-width="2"></line>
                    </svg>
                </button>
            </div>
            <nav class="p-4 space-y-1 mt-2">
                
                <a href="/customers" class="flex items-center py-2.5 text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors"
                   :class="sidebarOpen ? 'px-3 gap-3' : 'justify-center'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="text-sm font-semibold whitespace-nowrap" x-show="sidebarOpen">Customers</span>
                </a>

                <a href="/services" class="flex items-center py-2.5 text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors"
                   :class="sidebarOpen ? 'px-3 gap-3' : 'justify-center'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Services</span>
                </a>

                <a href="/subscriptions" class="flex items-center py-2.5 text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors"
                   :class="sidebarOpen ? 'px-3 gap-3' : 'justify-center'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Subscription</span>
                </a>
            </nav>
        </div>

        <div class="p-4 mb-2">
            <a href="#" class="flex items-center py-2.5 text-gray-500 hover:bg-gray-50 hover:text-red-600 rounded-lg transition-colors"
               :class="sidebarOpen ? 'px-3 gap-3' : 'justify-center'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Sign Out</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-8 shrink-0">
            <h1 class="text-sm font-medium text-gray-600">@yield('header_title', 'Dashboard')</h1>
        </header>

        <div class="p-8">
            @yield('content')
        </div>
    </main>

</body>
</html>