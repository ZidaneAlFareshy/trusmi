<aside id="app-sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-200/70 transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out flex flex-col">
    
    {{-- Logo --}}
    <div class="h-16 px-5 flex items-center justify-center border-b border-slate-100">
        <img
            src="trusmi.png"
            alt="Trusmi Group"
            style="width: 120px; height: auto; object-fit: contain;"
        />
    </div>

    {{-- Menu --}}
    <nav class="flex-1 px-4 py-5 space-y-6 overflow-y-auto">
        <div>
            <a href="#overview" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-primary/10 text-primary font-semibold text-sm transition-colors">
                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        {{-- Menu Lainnya --}}
        <div>
            <p class="px-3.5 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                Menu Lainnya
            </p>
        </div>
    </nav>
</aside>