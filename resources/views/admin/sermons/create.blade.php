<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Sermon - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/ckeditor.js"></script>
    <style>
        .form-section {
            transition: all 0.3s ease;
        }

        .form-section.collapsed {
            margin-bottom: 0;
        }

        .form-section.collapsed .section-content {
            display: none;
        }

        .section-header {
            cursor: pointer;
            user-select: none;
        }

        .section-header:hover {
            background-color: #f9fafb;
        }

        .required::after {
            content: " *";
            color: #e74c3c;
        }

        .file-upload-area {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }

        .file-upload-area.dragover {
            border-color: #2ecc71;
            background-color: #f0f9f0;
        }

        .preview-image {
            max-height: 200px;
            object-fit: cover;
        }

        .tag-input-container {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
            min-height: 42px;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            background-color: #e8f5e8;
            color: #2ecc71;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            margin: 0.125rem;
            font-size: 0.875rem;
        }

        .tag-remove {
            margin-left: 0.25rem;
            cursor: pointer;
            color: #27ae60;
        }

        .tag-input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 120px;
        }

        /* Custom color scheme */
        .bg-primary {
            background-color: #2ecc71;
        }

        .bg-secondary {
            background-color: #27ae60;
        }

        .text-primary {
            color: #2ecc71;
        }

        .text-secondary {
            color: #27ae60;
        }

        .border-primary {
            border-color: #2ecc71;
        }

        .focus\:ring-primary:focus {
            --tw-ring-color: rgb(46 204 113 / 0.5);
        }

        .hover\:bg-primary:hover {
            background-color: #2ecc71;
        }
    </style>
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
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center text-primary">
                    <div
                        class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-primary bg-primary text-white text-center">
                        <i class="fas fa-pen"></i>
                    </div>
                    <div class="hidden sm:block text-center ml-2 text-primary font-medium">Basic Info</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>
                <div class="flex items-center text-gray-500">
                    <div
                        class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-gray-300 text-center">
                        <i class="fas fa-photo-film"></i>
                    </div>
                    <div class="hidden sm:block text-center ml-2 text-gray-500 font-medium">Media</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>
                <div class="flex items-center text-gray-500">
                    <div
                        class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-gray-300 text-center">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="hidden sm:block text-center ml-2 text-gray-500 font-medium">Settings</div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <div id="form-messages" class="hidden mb-6 p-4 rounded-lg"></div>

        <!-- Sermon Creation Form -->
        <form id="sermon-form" class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Basic Information Section -->
            <div class="form-section border-b border-gray-200">
                <div class="section-header p-6 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
                        <p class="text-sm text-gray-600 mt-1">Provide the essential details about your sermon</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-500 text-lg"></i>
                </div>
                <div class="section-content p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sermon Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1 required">Sermon
                                Title</label>
                            <input type="text" id="title" name="title" required
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
                                <option value="1">Pastor John Smith</option>
                                <option value="2">Rev. Sarah Johnson</option>
                                <option value="3">Dr. Michael Brown</option>
                                <option value="4">Guest Speaker</option>
                                <option value="0">Other</option>
                            </select>
                        </div>

                        <!-- Date Preached -->
                        <div>
                            <label for="date_preached"
                                class="block text-sm font-medium text-gray-700 mb-1 required">Date Preached</label>
                            <input type="date" id="date_preached" name="date_preached" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>



                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Provide a brief description or summary of the sermon"></textarea>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="form-section border-b border-gray-200">
                <div class="section-header p-6 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Media Files</h2>
                        <p class="text-sm text-gray-600 mt-1">Upload video, audio, and thumbnail for your sermon</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-500 text-lg"></i>
                </div>
                <div class="section-content p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Thumbnail Image -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Image</label>
                            <div id="thumbnail-upload"
                                class="file-upload-area rounded-lg p-6 text-center cursor-pointer">
                                <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Drag & drop your thumbnail image here or <span
                                        class="text-primary font-medium">browse files</span></p>
                                <p class="text-xs text-gray-500 mt-1">Recommended: 16:9 ratio, at least 800x450 pixels
                                </p>
                                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="hidden">
                            </div>
                            <div id="thumbnail-preview" class="mt-4 hidden">
                                <img id="preview-image" src="" alt="Thumbnail preview"
                                    class="preview-image rounded-lg mx-auto">
                                <button type="button" id="remove-thumbnail"
                                    class="mt-2 text-red-600 hover:text-red-800 text-sm flex items-center mx-auto">
                                    <i class="fas fa-times mr-1"></i> Remove image
                                </button>
                            </div>
                        </div>

                        <!-- Video URL -->
                        <div>
                            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1">Video
                                URL</label>
                            <input type="url" id="video_url" name="video_url"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="https://youtube.com/watch?v=...">
                            <p class="text-xs text-gray-500 mt-1">Link to YouTube, Vimeo, or your video hosting service
                            </p>
                        </div>

                        <!-- Video File -->
                        <div class="md:col-span-2">
                            <label for="video_file" class="block text-sm font-medium text-gray-700 mb-1">Video File
                                (Alternative)</label>
                            <div class="flex">
                                <input type="file" id="video_file" name="video_file" accept="video/*" class="hidden">
                                <input type="text" id="video_file_name" readonly
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg border-r-0"
                                    placeholder="No file selected">
                                <button type="button" id="browse-video"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-r-lg border border-gray-300">
                                    Browse
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Upload MP4 or other video format if not using a URL
                                (max 500MB)</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Form Actions -->
            <div class="p-6 bg-gray-50 flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0">
                <div class="flex space-x-3">
                    <button type="button" id="save-draft"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 flex items-center">
                        <i class="far fa-save mr-2"></i> Save Draft
                    </button>
                    <button type="reset"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 flex items-center">
                        <i class="fas fa-undo mr-2"></i> Reset Form
                    </button>
                </div>
                <div class="flex space-x-3">
                    <a href="sermons.html"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 flex items-center">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-primary hover:bg-secondary text-white rounded-lg font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i> Create Sermon
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Form section collapse/expand functionality
        document.querySelectorAll('.section-header').forEach(header => {
            header.addEventListener('click', function () {
                const section = this.parentElement;
                const icon = this.querySelector('i');

                section.classList.toggle('collapsed');

                if (section.classList.contains('collapsed')) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                } else {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });

        // Thumbnail upload functionality
        const thumbnailUpload = document.getElementById('thumbnail-upload');
        const thumbnailInput = document.getElementById('thumbnail');
        const thumbnailPreview = document.getElementById('thumbnail-preview');
        const previewImage = document.getElementById('preview-image');
        const removeThumbnail = document.getElementById('remove-thumbnail');

        thumbnailUpload.addEventListener('click', () => {
            thumbnailInput.click();
        });

        thumbnailUpload.addEventListener('dragover', (e) => {
            e.preventDefault();
            thumbnailUpload.classList.add('dragover');
        });

        thumbnailUpload.addEventListener('dragleave', () => {
            thumbnailUpload.classList.remove('dragover');
        });

        thumbnailUpload.addEventListener('drop', (e) => {
            e.preventDefault();
            thumbnailUpload.classList.remove('dragover');

            if (e.dataTransfer.files.length) {
                thumbnailInput.files = e.dataTransfer.files;
                handleThumbnailSelection(e.dataTransfer.files[0]);
            }
        });

        thumbnailInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleThumbnailSelection(e.target.files[0]);
            }
        });

        function handleThumbnailSelection(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    thumbnailPreview.classList.remove('hidden');
                };

                reader.readAsDataURL(file);
            } else {
                showMessage('Please select a valid image file.', 'error');
            }
        }

        removeThumbnail.addEventListener('click', () => {
            thumbnailInput.value = '';
            thumbnailPreview.classList.add('hidden');
        });

        // File browse buttons
        document.getElementById('browse-audio').addEventListener('click', () => {
            document.getElementById('audio_file').click();
        });

        document.getElementById('browse-video').addEventListener('click', () => {
            document.getElementById('video_file').click();
        });

        document.getElementById('audio_file').addEventListener('change', (e) => {
            document.getElementById('audio_file_name').value = e.target.files[0]?.name || 'No file selected';
        });

        document.getElementById('video_file').addEventListener('change', (e) => {
            document.getElementById('video_file_name').value = e.target.files[0]?.name || 'No file selected';
        });

        // Tag functionality
        const tagInput = document.getElementById('tag-input');
        const tagContainer = document.querySelector('.tag-input-container');
        let tags = [];

        tagInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && tagInput.value.trim() !== '') {
                e.preventDefault();
                addTag(tagInput.value.trim());
                tagInput.value = '';
            }
        });

        // Suggested tags
        document.querySelectorAll('.tag-suggestion').forEach(suggestion => {
            suggestion.addEventListener('click', () => {
                addTag(suggestion.textContent);
            });
        });

        function addTag(tagText) {
            if (tags.includes(tagText)) return;

            tags.push(tagText);

            const tagElement = document.createElement('span');
            tagElement.className = 'tag';
            tagElement.innerHTML = `
                ${tagText}
                <span class="tag-remove" data-tag="${tagText}">
                    <i class="fas fa-times"></i>
                </span>
            `;

            tagContainer.insertBefore(tagElement, tagInput);

            // Add remove functionality
            tagElement.querySelector('.tag-remove').addEventListener('click', (e) => {
                e.stopPropagation();
                removeTag(tagText, tagElement);
            });
        }

        function removeTag(tagText, tagElement) {
            tags = tags.filter(tag => tag !== tagText);
            tagElement.remove();
        }

        // Form submission
        document.getElementById('sermon-form').addEventListener('submit', (e) => {
            e.preventDefault();

            // Basic validation
            const title = document.getElementById('title').value;
            const preacher = document.getElementById('preacher').value;
            const datePreached = document.getElementById('date_preached').value;

            if (!title || !preacher || !datePreached) {
                showMessage('Please fill in all required fields.', 'error');
                return;
            }

            // In a real application, you would submit the form data to the server here
            showMessage('Sermon created successfully!', 'success');

            // Simulate redirect after success
            setTimeout(() => {
                window.location.href = 'sermons.html';
            }, 2000);
        });

        // Save draft functionality
        document.getElementById('save-draft').addEventListener('click', () => {
            showMessage('Draft saved successfully.', 'info');
        });

        // Message display function
        function showMessage(message, type) {
            const messageDiv = document.getElementById('form-messages');
            messageDiv.className = `p-4 rounded-lg ${type === 'error' ? 'bg-red-100 text-red-700' :
                type === 'success' ? 'bg-green-100 text-green-700' :
                    'bg-blue-100 text-blue-700'}`;
            messageDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' :
                    type === 'success' ? 'check-circle' : 'info-circle'} mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            messageDiv.classList.remove('hidden');

            // Auto-hide success messages after 5 seconds
            if (type === 'success') {
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 5000);
            }
        }

        // Set today's date as default for date preached
        document.getElementById('date_preached').valueAsDate = new Date();
    </script>
</body>

</html>