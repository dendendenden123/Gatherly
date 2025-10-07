<div class="sermon-list grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <!-- Sermon Cards (repeat as needed) -->
    @forelse ($sermons as $sermon)
        <div class="bg-white rounded-xl shadow sermon-card overflow-hidden flex flex-col">
            <div class="relative">
                @php
                    $videoUrl = $sermon->video_url;
                    $thumbnail = 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80';
                    if ($videoUrl) {
                        if (preg_match('/(?:youtube\\.com\\/watch\\?v=|youtu\\.be\\/)([\\w-]+)/', $videoUrl, $ytMatch)) {
                            $thumbnail = 'https://img.youtube.com/vi/' . $ytMatch[1] . '/hqdefault.jpg';
                        } elseif (preg_match('/vimeo\\.com\\/(\\d+)/', $videoUrl, $vimeoMatch)) {
                            $thumbnail = 'https://vumbnail.com/' . $vimeoMatch[1] . '.jpg';
                        } elseif (
                            strpos($videoUrl, '/storage') === 0 ||
                            strpos($videoUrl, 'storage') === 0 ||
                            strpos($videoUrl, '/uploads') === 0 ||
                            (strpos($videoUrl, 'http') === 0 && !preg_match('/(youtube|vimeo)/i', $videoUrl))
                        ) {
                            // For uploaded videos, fallback to a public video icon
                            $thumbnail = 'https://cdn-icons-png.flaticon.com/512/727/727245.png';
                        }
                    }
                @endphp
                <img src="{{ $thumbnail }}" alt="Sermon thumbnail" class="w-full h-48 object-cover">
                <div
                    class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                    <button
                        class="play-button bg-primary hover:bg-secondary text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg"
                        data-video-url="{{ $sermon->video_url }}" data-title="{{ $sermon->title }}"
                        data-description="{{ $sermon->description }}">
                        <i class="fas fa-play text-2xl pl-1"></i>
                    </button>
                </div>
                <div class="absolute top-4 right-4 bg-primary text-white px-2 py-1 rounded-md text-xs font-semibold shadow">
                    New</div>
            </div>
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-gray-800 mb-1"> {{ $sermon->title }}</h3>
                <p class="text-gray-600 mb-3 flex-1"> {{ $sermon->description }}</p>
                <div class="flex justify-between items-center text-xs text-gray-500 mb-3">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-user"></i>
                        <span> {{ $sermon->preacher?->first_name }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="far fa-calendar"></i>
                        <span>{{ $sermon->created_at->format('M d Y') }}</span>
                    </div>
                </div>
                <div class="flex justify-between mt-auto">
                    <button class="text-primary hover:text-secondary flex items-center font-semibold">
                        <i class="fas fa-play-circle mr-1"></i> Watch
                    </button>
                    <button class="text-gray-600 hover:text-gray-800 flex items-center font-semibold">
                        <i class="fas fa-download mr-1"></i> Download
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div>No More Sermon Videos</div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-10 flex justify-center">
    @php
        $containerClass = "sermon-list";
    @endphp
    <x-pagination :containerClass="$containerClass" :data="$sermons" />
</div>

<!-- Video Modal -->
<div id="video-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl mx-4">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Sermon Video</h3>
            <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-4">
            <div class="aspect-w-16 aspect-h-9">
                <iframe id="video-player" class="w-full h-96" src="" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
            <div class="mt-4">
                <h4 id="modal-title" class="text-xl font-bold text-gray-800"></h4>
                <p id="modal-description" class="text-gray-600 mt-2"></p>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('video-modal');
        const videoPlayer = document.getElementById('video-player');
        const modalTitle = document.getElementById('modal-title');
        const modalDescription = document.getElementById('modal-description');
        const closeModalBtn = document.getElementById('close-modal');
        document.querySelectorAll('.play-button').forEach(btn => {
            btn.addEventListener('click', function () {
                const videoUrl = btn.getAttribute('data-video-url');
                const title = btn.getAttribute('data-title');
                const description = btn.getAttribute('data-description');
                if (videoUrl) {
                    // If YouTube or Vimeo, embed, else direct video
                    let embedUrl = videoUrl;
                    if (/youtube\.com|youtu\.be/.test(videoUrl)) {
                        const match = videoUrl.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/);
                        if (match && match[1]) {
                            embedUrl = `https://www.youtube.com/embed/${match[1]}`;
                        }
                    } else if (/vimeo\.com/.test(videoUrl)) {
                        const match = videoUrl.match(/vimeo\.com\/(\d+)/);
                        if (match && match[1]) {
                            embedUrl = `https://player.vimeo.com/video/${match[1]}`;
                        }
                    }
                    videoPlayer.src = embedUrl;
                } else {
                    videoPlayer.src = '';
                }
                modalTitle.textContent = title || '';
                modalDescription.textContent = description || '';
                modal.classList.remove('hidden');
            });
        });
        closeModalBtn.addEventListener('click', function () {
            modal.classList.add('hidden');
            videoPlayer.src = '';
        });
        // Optional: close modal on outside click
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                videoPlayer.src = '';
            }
        });
    });
</script>