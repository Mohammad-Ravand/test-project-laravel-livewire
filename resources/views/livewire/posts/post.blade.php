<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header -->
    <x-posts.header :search="$search" />

    <!-- Filter Section -->
    <x-posts.post-filter-section :users="$users" :filterStatus="$filterStatus" />

    <!-- Posts Grid -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <x-posts.post-item :post="$post" />
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-gray-500 text-lg">هیچ نوشته‌ای موجود نیست.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <x-posts.create-new-post :showModal="$showModal" :users="$users"  :postAttachement="$postAttachement"/>
</div>
