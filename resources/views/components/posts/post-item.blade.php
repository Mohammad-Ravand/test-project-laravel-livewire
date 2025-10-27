@props(['post'])

<div class="relative h-full">
    <!-- Card with conditional background color -->
    <div
        class="rounded-2xl h-full flex flex-col p-6 shadow-sm border-0 {{ $post->status->value === 'done' ? 'bg-green-500' : 'bg-red-500' }} text-white">
        <!-- Header with icons -->
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold leading-tight">{{ $post->title }}</h3>
            <div class="flex gap-x-2 space-x-2 space-x-reverse">
                <button wire:click="delete({{ $post->id }})"
                    class="p-1.5 rounded-lg bg-white/20 hover:bg-white/30 transition-colors">

                    <svg w-5 h-5 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>

                </button>
                <button wire:click="edit({{ $post->id }})"
                    class="p-1.5 rounded-lg bg-white/20 hover:bg-white/30 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <p class="text-white/90 text-sm leading-relaxed mb-6 line-clamp-3">
            {{ Str::limit($post->description, 120) }}
        </p>

        <!-- Footer -->
        <div class="flex mt-auto justify-between items-center pt-4 border-t border-white/20">
            <div class="flex items-center space-x-2 space-x-reverse text-white/80">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs">
                    {{ $post->date ? \Carbon\Carbon::parse($post->date)->format('Y/m/d') : '' }}
                </span>
            </div>
            <div class="flex items-center space-x-3 space-x-reverse text-white/80">
                <span class="text-xs">
                    فایل پیوست ({{ $post->status->value === 'done' ? '۵' : '۸۱' }} دقیقه)
                </span>
                @if ($post->attachment)
                    <a href="{{ asset('storage/' . $post->attachment) }}" target="_blank"
                        class="p-1 rounded bg-white/20 hover:bg-white/30 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                @else
                    <div class="p-1 rounded bg-white/10">
                        <svg class="w-4 h-4 text-white/50" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
