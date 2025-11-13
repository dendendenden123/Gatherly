<div class="sermon-list grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <!-- Sermon Cards (repeat as needed) -->
    @forelse ($sermons as $sermon)
    <div class="bg-white rounded-xl shadow sermon-card overflow-hidden flex flex-col">
        <div class="relative">
            @php
                $videoUrl = $sermon->video_url;
                $isYouTube = preg_match('/youtube\.com|youtu\.be/', $videoUrl);
                $isVimeo = preg_match('/vimeo\.com/', $videoUrl);
                $isLocalVideo = !$isYouTube && !$isVimeo && $videoUrl;

                // Extract YouTube thumbnail
                $youtubeId = null;
                if ($isYouTube) {
                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $videoUrl, $matches);
                    $youtubeId = $matches[1] ?? null;
                }

                // Extract Vimeo thumbnail (requires API call in production, using placeholder for now)
                $vimeoId = null;
                if ($isVimeo) {
                    preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches);
                    $vimeoId = $matches[1] ?? null;
                }
            @endphp

            <div class="sermon-thumbnail">
                @if ($isYouTube && $youtubeId)
                    <!-- YouTube Thumbnail -->
                    <img src="https://img.youtube.com/vi/{{ $youtubeId }}/maxresdefault.jpg" alt="{{ $sermon->title }}"
                        onerror="this.src='https://img.youtube.com/vi/{{ $youtubeId }}/hqdefault.jpg'">
                @elseif ($isVimeo && $vimeoId)
                    <!-- Vimeo Thumbnail -->
                    <img src="https://vumbnail.com/{{ $vimeoId }}.jpg" alt="{{ $sermon->title }}"
                        onerror="this.src='https://cdn-icons-png.flaticon.com/512/727/727245.png'">
                @elseif ($isLocalVideo)
                    <!-- Local Video with Video.js -->
                    <video id="sermon-video-{{ $sermon->id }}" class="video-js vjs-default-skin" preload="metadata"
                        data-setup='{"controls": false, "preload": "metadata"}'>
                        <source src="{{ $videoUrl }}#t=0.1" type="video/mp4">
                    </video>
                @else
                    <!-- Fallback placeholder -->
                    <img src="https://cdn-icons-png.flaticon.com/512/727/727245.png" alt="Sermon thumbnail">
                @endif
            </div>

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
            @admin
                <div class="mt-auto">
                    <form class="delete-form" action="{{ route('admin.sermons.destroy', $sermon->id) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md text-sm transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            @endadmin

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

    // Handle delete confirmation
    // Handle delete confirmation
    $(document).on('submit', '.delete-form', async function (e) {
        e.preventDefault();

        const deleteConfirmation = await Swal.fire({
            title: "Are you sure you want to delete this sermon? This action cannot be undone.",
            text: "This video will be deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        });

        if (deleteConfirmation.isConfirmed) {
            const form = $(this);
            const url = form.attr('action');

            try {
                // Use fetch instead of $.ajax for easier async/await support
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Content-Type": "application/json",
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // Remove card smoothly
                form.closest('.sermon-card').fadeOut(300, function () {
                    $(this).remove();
                    if ($('.sermon-card').length === 0) {
                        $('.sermon-list').html('<div class="col-span-3 text-center py-10">No sermons found.</div>');
                    }
                });

                // SweetAlert after successful delete
                await Swal.fire({
                    icon: "success",
                    title: "Video Deleted",
                    text: "Sermon deleted successfully.",
                    timer: 1500,
                    showConfirmButton: false,
                });

            } catch (error) {
                console.error('Error deleting sermon:', error);
                await Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred while deleting the sermon. Please try again.",
                });
            }
        }
    });



    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Video.js for all local video thumbnails
        document.querySelectorAll('.video-js').forEach(function (videoElement) {
            if (window.videojs) {
                const player = videojs(videoElement.id, {
                    controls: false,
                    preload: 'metadata',
                    fluid: false,
                    aspectRatio: '16:9'
                });

                // Seek to first frame to show thumbnail
                player.on('loadedmetadata', function () {
                    player.currentTime(0.1);
                });

                // Pause immediately to show as thumbnail
                player.on('play', function () {
                    player.pause();
                });
            }
        });

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