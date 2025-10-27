@props([
    'users' => [],
])
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-6">
    <div class="flex  items-center">
        <div>
            <div class="relative inline-block w-full">
                <select wire:model="filterUser" wire:change="toggleFilterUser($event.target.value)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                    <option value="">انتخاب کاربر</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->fullName }}</option>
                    @endforeach
                </select>

                <!-- Custom arrow -->
                <div class="pointer-events-none absolute inset-y-0 left-2 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

        </div>
        <div class="flex mr-auto">
            <div class="flex ml-4 gap-1">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                    </svg>
                </div>
                <p>فیلتر براساس:‌</p>
            </div>
            <div class="flex gap-3">
                <button class="text-gray-900 font-medium pb-2" wire:click="toggleFilterStatus('all')">همه</button>
                <button class="text-gray-500 pb-2   hover:text-gray-700" wire:click="toggleFilterStatus('done')">انجام
                    شده</button>
                <button class="text-gray-500 pb-2   hover:text-gray-700" wire:click="toggleFilterStatus('undone')">انجام
                    نشده</button>
            </div>
        </div>
    </div>
</div>
