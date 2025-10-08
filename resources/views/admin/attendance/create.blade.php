<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Church Attendance | Check-In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2ecc71',
                        secondary: '#27ae60',
                        accent: '#e74c3c',
                        'light-gray': '#f5f5f5',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-light-gray min-h-screen font-sans">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Enroll Face Form -->
        <form id="enrollForm" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.attendance.enroll') }}" class="mb-4">
            @csrf
            <div class="flex flex-col md:flex-row gap-2 items-center">
                <input type="email" name="email" placeholder="Enter Email" required class="border px-2 py-1 rounded">
                <input type="file" name="photo" required class="border px-2 py-1 rounded">
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Enroll Face</button>
            </div>
        </form>
        <!-- Scan Attendance Form with Camera Modal -->
        <form id="scanForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.attendance.scan') }}"
            class="mb-8">
            @csrf
            <!-- Removed hidden input. Photo will be appended as a real file via JS. -->
            <div class="flex flex-col md:flex-row gap-2 items-center">
                <button type="button" id="openCameraBtn"
                    class="bg-secondary text-white px-4 py-2 rounded flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h2l2-3h6l2 3h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                    </svg>
                    Scan with Camera
                </button>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Submit Attendance</button>
            </div>
        </form>

        <!-- Camera Modal -->
        <div id="cameraModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative flex flex-col items-center">
                <button id="closeCameraModal"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">&times;</button>
                <h3 class="text-lg font-semibold mb-2 text-secondary">Scan Attendance - Take Photo</h3>
                <video id="cameraPreview" autoplay playsinline
                    class="rounded border mb-4 w-full h-64 object-cover bg-black"></video>
                <canvas id="cameraCanvas" class="hidden"></canvas>
                <button id="capturePhotoBtn" class="bg-primary text-white px-4 py-2 rounded">Capture Photo</button>
                <div id="cameraError" class="text-red-500 mt-2 hidden"></div>
            </div>
        </div>
        <!-- Header -->
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-secondary mb-2">Attendance Check-In</h1>
            <p class="text-gray-600">Record member attendance for services and events</p>
        </header>

        <!-- Main Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
            <!-- Card Header with Event Selector -->
            <div class="bg-primary px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-white">Record Attendance</h2>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <!-- Search Section -->

                <form method="GET" action="{{ route('admin.attendance.create') }}"
                    class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Member From</label>
                        <div class="relative w-64">
                            <select id="locale-select" name='locale' action="{{ route('admin.attendance.create') }}"
                                class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">

                                <option value="">-- Select Locale --</option>
                                <option> Local ng Alcantara</option>
                                <option> Local ng Argao</option>
                                <option> Local ng Asturias</option>
                                <option> Local ng Badian</option>
                                <option> Local ng Balamban</option>
                                <option> Local ng Barili</option>
                                <option> Local ng Bato</option>
                                <option> Local ng Binlod</option>
                                <option> Local ng Bulasa</option>
                                <option> Local ng Bulongan</option>
                                <option> Local ng Cantao-an</option>
                                <option> Local ng Carcar City</option>
                                <option> Local ng Colon</option>
                                <option> Local ng Dalaguete</option>
                                <option> Local ng Don Juan Climaco Sr.</option>
                                <option> Local ng Dumanjug</option>
                                <option> Local ng Gen. Climaco</option>
                                <option> Local ng Langtad</option>
                                <option> Local ng Langub</option>
                                <option> Local ng Lutopan</option>
                                <option> Local ng Mainggit</option>
                                <option> Local ng Malabuyoc</option>
                                <option> Local ng Manguiao</option>
                                <option> Local ng Mantalongon</option>
                                <option> Local ng Naga</option>
                                <option> Local ng Panadtaran</option>
                                <option> Local ng Pinamungajan</option>
                                <option> Local ng Ronda</option>
                                <option> Local ng San Isidro</option>
                                <option> Local ng Sangat</option>
                                <option> Local ng Sibonga</option>
                                <option> Local ng Sta Lucia</option>
                                <option> Local ng Tag-Amakan</option>
                                <option> Local ng Talaga</option>
                                <option> Local ng Talavera</option>
                                <option> Local ng Tiguib</option>
                                <option> Local ng Toledo City</option>
                            </select>

                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="member-search" class="block text-sm font-medium text-gray-700 mb-1">Search
                            Members</label>
                        <div class="relative">

                            <input type="text" id="member-search" name="member-search"
                                placeholder="Enter name or member ID"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                oninput="()=>{showResults(this.value)}" autocomplete="off">
                            <label id="responeMessage"></label>


                            <!-- Autocomplete Dropdown -->
                            <div id="autocomplete-results"
                                class="hidden absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200 max-h-60 overflow-auto">
                                <!-- Sample results - these would be dynamically generated in a real app -->
                                <div
                                    class="px-4 py-2 hover:bg-light-gray cursor-pointer border-b border-gray-100 flex justify-between">
                                    <span><i>No Found</i></span>
                                    <span class="text-gray-500 font-mono"><i>NA</i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event</label>
                        <div class="relative w-64">
                            <select id="eventNameSelection"
                                class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">

                                @if($todaysScheduleEvent->isEmpty())
                                    <option value="">No schedule event for today</option>
                                @else
                                    <option value="">Select Event</option>
                                    @foreach ($todaysScheduleEvent as $eventOccurrence)
                                        <option value="{{ $eventOccurrence->id }}">
                                            {{ $eventOccurrence->event->event_name }}
                                            ({{$eventOccurrence->StartTimeFormatted}})
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            @if($todaysScheduleEvent->isEmpty())
                                <a href="{{ route('admin.events.create') }}" class="text-blue-500 hover:underline">
                                    Create New One
                                </a>
                            @endif


                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </form>


                <!-- Member Display -->
                <div class="bg-light-gray rounded-lg p-4 mb-6">
                    <div class="flex items-center space-x-4">
                        <!-- Member Photo -->
                        <div class="flex-shrink-0">
                            <div
                                class="h-16 w-16 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow-sm">
                                <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&auto=format&fit=crop&w=128&h=128&q=80"
                                    alt="Member photo" class="h-full w-full object-cover">
                            </div>
                        </div>

                        <!-- Member Info -->
                        <div id="selected-member" class="flex-grow">
                            <h3 id='name-selected' class="text-lg font-semibold text-gray-800">Michael Johnson</h3>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mt-1">
                                <div>Member ID: <span id='id-selected' class="font-medium">0</span></div>
                                <div>Birthdate: <span id='birthdate-selected' class="font-medium">January 1, 1999</span>
                                </div>
                                <div>Email: <span id='email-selected' class="font-medium">user@gmail.com</span></div>
                                <div>Phone: <span id='phone-selected' class="font-medium text-primary">09*****</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3">
                    <button id="event-done-btn"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">
                        Event Done
                    </button>
                    <button id="absent-attendnace-btn" action="{{ route('admin.attendance.store') }}"
                        class="px-4 py-2 rounded-lg bg-red-500 text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Absent
                    </button>

                    <button id="present-attendnace-btn" action="{{ route('admin.attendance.store') }}"
                        class=" px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-secondary hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Present
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Check-Ins Section -->
        <div class="create-recent-attendance-list mt-8">
            @include('admin.attendance.create-recent-attendance-list')
        </div>
    </div>
    <!-- SweetAlert2 Pop-up for Session Messages -->
    @if(session('success'))
        <script>
            $(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session('success')),
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            $(function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: @json(session('error')),
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    <script>
        // Camera modal logic
        let cameraStream = null;
        const cameraModal = document.getElementById('cameraModal');
        const openCameraBtn = document.getElementById('openCameraBtn');
        const closeCameraModal = document.getElementById('closeCameraModal');
        const cameraPreview = document.getElementById('cameraPreview');
        const cameraCanvas = document.getElementById('cameraCanvas');
        const capturePhotoBtn = document.getElementById('capturePhotoBtn');
        let scanPhotoDataUrl = null;
        const cameraError = document.getElementById('cameraError');

        if (openCameraBtn) {
            openCameraBtn.addEventListener('click', async function () {
                cameraError.classList.add('hidden');
                cameraError.textContent = '';
                cameraModal.classList.remove('hidden');
                try {
                    cameraStream = await navigator.mediaDevices.getUserMedia({ video: true });
                    cameraPreview.srcObject = cameraStream;
                } catch (err) {
                    cameraError.textContent = 'Unable to access camera: ' + err.message;
                    cameraError.classList.remove('hidden');
                }
            });
        }
        if (closeCameraModal) {
            closeCameraModal.addEventListener('click', function () {
                cameraModal.classList.add('hidden');
                if (cameraStream) {
                    cameraStream.getTracks().forEach(track => track.stop());
                    cameraPreview.srcObject = null;
                }
            });
        }
        if (capturePhotoBtn) {
            capturePhotoBtn.addEventListener('click', function () {
                if (!cameraStream) return;
                const width = cameraPreview.videoWidth;
                const height = cameraPreview.videoHeight;
                cameraCanvas.width = width;
                cameraCanvas.height = height;
                cameraCanvas.getContext('2d').drawImage(cameraPreview, 0, 0, width, height);
                scanPhotoDataUrl = cameraCanvas.toDataURL('image/jpeg');
                // Hide modal and stop camera
                cameraModal.classList.add('hidden');
                cameraStream.getTracks().forEach(track => track.stop());
                cameraPreview.srcObject = null;
                Swal.fire({
                    icon: 'success',
                    title: 'Photo Captured',
                    text: 'Photo ready for submission.',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        }

        // AJAX submit for forms to show pop-up without reload
        $(function () {
            $('#enrollForm').on('submit', function (e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);
                var action = $(form).attr('action');
                $.ajax({
                    url: action,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Operation successful!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        form.reset();
                    },
                    error: function (xhr) {
                        let msg = 'An error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                });
            });
            $('#scanForm').on('submit', function (e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData();
                var action = $(form).attr('action');
                // If no photo, show error
                if (!scanPhotoDataUrl) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No Photo',
                        text: 'Please scan and capture a photo first.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }
                // Convert base64 to Blob and append as file
                function dataURLtoFile(dataurl, filename) {
                    var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
                        bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
                    while (n--) {
                        u8arr[n] = bstr.charCodeAt(n);
                    }
                    return new File([u8arr], filename, { type: mime });
                }
                var photoFile = dataURLtoFile(scanPhotoDataUrl, 'photo.jpg');
                formData.append('photo', photoFile);
                // Add CSRF token
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    url: action,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Attendance scanned!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        form.reset();
                        scanPhotoDataUrl = null;
                    },
                    error: function (xhr) {
                        let msg = 'An error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    </script>
    @vite("resources/js/admin-attendance-create.js")
</body>

</html>