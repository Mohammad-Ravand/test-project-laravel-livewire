@props([
    'search'
])
<div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
            <h1 class="text-2xl font-bold text-gray-900">نوشته های من</h1>
            <div class="flex gap-3 items-center space-x-4 space-x-reverse">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="جستجو کنید..."
                        class="w-80 px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <button wire:click="openModal"
                    class="bg-black text-white px-6 py-2.5 rounded-lg hover:bg-gray-800 transition duration-200 text-sm font-medium">
                    + ایجاد نوشته جدید
                </button>
            </div>
        </div>
    </div>
</div>
