@props([
    'users'=>[],
    'showModal' => false,
    'attachment' => null,
    'message' => null,
    'postAttachement'=>null
])
@if ($showModal)
    <div class="fixed inset-0 bg-gray-200 bg-opacity-75 flex items-center justify-center z-50 p-4"
        wire:click="closeModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-7xl max-h-[95vh] overflow-y-auto" @click.stop>
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-8 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900">+ ایجاد نوشته جدید</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors p-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="mx-8 mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif


            <!-- Modal Body -->
            <form wire:submit.prevent="save" class="p-8 space-y-8">
                <!-- First Row: Title and Date/Time -->
                <div class="flex gap-8">
                    <!-- Title -->
                    <div class="">
                        <label class="block text-sm font-bold text-gray-700 mb-3">عنوان *</label>
                        <input type="text" wire:model.live="title"
                            class="w-sm px-4  py-1 text-lg border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="عنوان نوشته را وارد کنید">
                        @error('title')
                            <div class="mt-2 text-red-600 text-sm font-medium">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div class="">
                        <div class="flex gap-4">
                            <!-- Persian Date -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">تاریخ شمسی *</label>
                                <div class="relative">
                                    <input type="text" wire:model.live="persianDate" data-jdp
                                        class="w-full pl-12 px-4 py-1 text-lg border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="۱۴۰۳/۰۸/۰۶" dir="ltr">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('persianDate')
                                    <div class="mt-2 text-red-600 text-sm font-medium">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- User Selection -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3"> کاربر</label>
                                <div class="flex  gap-x-3 border-gray-300 ">

                                    @foreach ($users as $user )
                                    <label class="flex items-center p-0 space-x-3 space-x-reverse  hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="radio" wire:model="selectedUser" value="{{ $user->id }}"
                                            class="w-6 h-6 text-blue-600 ml-1 m-0 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="text-lg whitespace-nowrap">{{$user->full_name}}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('selectedUser')
                                    <div class="mt-2 text-red-600 text-sm font-medium">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">توضیحات *</label>
                    <textarea wire:model.live="description" rows="6"
                        class="w-full px-4 py-1 text-lg border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-all"
                        placeholder="توضیحات تفصیلی نوشته را وارد کنید..."></textarea>
                    <div class="flex justify-between items-center mt-2">
                        @error('description')
                            <div class="text-red-600 text-sm font-medium">{{ $message }}</div>
                        @else
                            <div></div>
                        @enderror
                        <div class="text-sm text-gray-500 character-counter">
                            {{ \App\Helpers\PersianHelper::toPersianNumbers(strlen($description ?? '')) }}/۱۰۰۰ کاراکتر
                        </div>
                    </div>
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">فایل پیوست</label>
                    <div class="relative">
                        <label for="file-upload" class="cursor-pointer inline-flex items-center px-6 py-3 text-lg border-2 border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                            <svg class="w-6 h-6 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                            </svg>

                            <span class="font-medium text-gray-700">فایل خود را اینجا آپلود کنید (ویدیو یا تصویر) </span>
                        </label>
                        <input id="file-upload" type="file" wire:model="attachment" class="hidden"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </div>
                    @if ($attachment)
                        <p class="mt-2 text-sm text-gray-600">
                            فایل انتخاب شده: <span class="font-medium">{{ $attachment->getClientOriginalName() }}</span>
                        </p>
                    @endif

                    @error('attachment')
                        <div class="mt-3 text-red-600 text-sm font-medium">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <img class="w-32 rounded-md" src="{{ asset('storage/'.$postAttachement) }}" alt="">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-8 border-t-2 border-gray-200">
                    <div class="flex space-x-4 space-x-reverse">
                        <button type="submit"
                            class="px-6 py-2 text-lg font-bold bg-black text-white rounded-xl hover:bg-gray-800 transition duration-200 shadow-lg">
                            ثبت و تایید
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
