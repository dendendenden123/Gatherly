<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Sermon - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href={{ asset('css/admin/sermons/create.css') }}>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Add New Sermon</h1>
                <p class="text-gray-600 mt-1">Create and publish a new sermon to your library</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.sermons.index') }}"
                    class="text-gray-600 hover:text-gray-800 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Sermons
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        <div id="form-messages" class="hidden mb-6 p-4 rounded-lg"></div>

        <!-- Sermon Creation Form -->
        <form id="sermon-form" method="POST" action="{{ route('admin.sermons.store') }}" enctype="multipart/form-data"
            class="bg-white rounded-xl shadow-sm overflow-hidden">

            @csrf
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6',
                    });
                </script>
            @endif
            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'Failed',
                        title: 'Failed!',
                        text: '{{ $errors->first() }}',
                        confirmButtonColor: '#d63030ff',
                    });
                </script>
            @endif

            <!-- Basic Information Section -->
            <div class="form-section border-b border-gray-200">
                <div class="section-content p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sermon Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1 required">Sermon
                                Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Enter a compelling title for your sermon">
                            <p class="text-xs text-gray-500 mt-1">Make it descriptive and engaging to attract listeners
                            </p>
                        </div>

                        <!-- Preacher -->
                        <div>
                            <label for="preacher"
                                class="block text-sm font-medium text-gray-700 mb-1 required">Preacher</label>
                            <select id="preacher" name="preacher_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="">Select a preacher</option>
                                @forelse ($preachers as $preacher)
                                    <option value="{{ $preacher->id }}">
                                        {{ $preacher->first_name . ' ' . $preacher->last_name}}
                                    </option>
                                @empty
                                    <option value="" diabled>
                                        No Minister assigned
                                    </option>
                                @endforelse

                            </select>
                        </div>

                        <!-- Date Preached -->
                        <div>
                            <label for="date_preached"
                                class="block text-sm font-medium text-gray-700 mb-1 required">Date Preached</label>
                            <input type="date" id="date_preached" name="date_preached"
                                value="{{ old('date_preached') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>



                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Provide a brief description or summary of the sermon">{{ old('description') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="form-section border-b border-gray-200">
                <div class="section-content p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Video File Upload -->
                        <div class="md:col-span-2">
                            <label for="video_file" class="block text-sm font-medium text-gray-700 mb-1">Video
                                file</label>
                            <div class="flex">
                                <input type="file" id="video_file" name="video_file" value="{{ old('video_file') }}"
                                    accept="video/*" class="hidden" required>
                                <input type="text" id="video_file_name" readonly
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg border-r-0 bg-gray-100 cursor-not-allowed"
                                    placeholder="No file selected">
                                <button type="button" id="browse-video"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-r-lg border border-gray-300">
                                    Browse
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Upload MP4 or other video format if not using a URL
                                (max 500MB)</p>
                            <div id="video-upload-progress" class="hidden mt-2 w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Form Actions -->
            <div class="p-6 bg-gray-50 flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0">
                <div class="flex space-x-3">
                    <a href="{{ route('admin.sermons.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 flex items-center">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-primary hover:bg-secondary text-white rounded-lg font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i> Upload Sermon
                    </button>
                </div>
            </div>
        </form>
        <!-- Loading Overlay -->
        <div id="loading-overlay"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-12 w-12 text-white mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span class="text-white text-lg font-semibold">Submitting...</span>
            </div>
        </div>
    </div>
    @vite('resources/js/admin-sermon-create.js')
    <script>
        // Video file browse button logic
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('video_file');
            const fileNameInput = document.getElementById('video_file_name');
            const browseBtn = document.getElementById('browse-video');

            if (browseBtn && fileInput && fileNameInput) {
                browseBtn.addEventListener('click', function () {
                    fileInput.click();
                });
                fileInput.addEventListener('change', function () {
                    if (fileInput.files.length > 0) {
                        fileNameInput.value = fileInput.files[0].name;
                    } else {
                        fileNameInput.value = '';
                    }
                });
            }

            // Form loading overlay logic
            const sermonForm = document.getElementById('sermon-form');
            const loadingOverlay = document.getElementById('loading-overlay');
            if (sermonForm && loadingOverlay) {
                sermonForm.addEventListener('submit', function () {
                    loadingOverlay.classList.remove('hidden');
                });
            }
        });
    </script>
</body>

</html>