<div class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
    
<div class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <img src={{ asset('img/logo/logo.png') }} alt="logo" class="w-auto h-8 md:h-12">
        </div>
    </div>
    <nav class="mt-10">
        <a class="flex items-center px-6 py-2 mt-4 
        {{ request()->routeIs('admin.dashboard') ? 'text-gray-100 bg-gray-700 bg-opacity-25' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}
         " 
        href="{{ route('admin.dashboard') }}"
        >
            <i class="fi fi-br-dashboard"></i>
            <span class="mx-3">Dashboard</span>
        </a>
        <a class="flex items-center px-6 py-2 mt-4 
        {{ request()->routeIs('admin.product') ? 'text-gray-100 bg-gray-700 bg-opacity-25' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}
         " 
        href="{{ route('admin.product.index') }}"
        >
            <i class="fi fi-br-boxes"></i>
            <span class="mx-3">Product</span>
        </a>
    </nav>
</div>