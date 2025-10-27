@props(['post'])

<div class="relative h-full">
    <!-- Card with conditional background color -->
    <div
        class="rounded-2xl h-full flex flex-col p-6 shadow-sm border-0 {{ $post->status->value === 'done' ? 'bg-green-500' : 'bg-red-500' }} text-white">
        <!-- Header with icons -->
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold leading-tight">{{ $post->title }}</h3>
            <div class="flex space-x-2 space-x-reverse">
                <button wire:click="delete({{ $post->id }})"
                    class="p-1.5 rounded-lg bg-white/20 hover:bg-white/30 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 102 0v3a1 1 0 11-2 0V9zm4 0a1 1 0 10-2 0v3a1 1 0 102 0V9z"
                            clip-rule="evenodd"></path>
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
