@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('css/admin/members/index.css') }}" rel="stylesheet">
@endsection

@section('header')
<div class="flex justify-between mb-7">
    <div class="members-title">
        <h1>Update Member</h1>
        <p>Edit and update member information</p>
    </div>
</div>
@endSection

@section('content')
    <div class="max-w-auto mx-auto px-4">
        <form method='POST' action="{{ route('admin.members.update') }}" enctype="multipart/form-data"
            class="bg-white rounded-xl shadow-lg overflow-hidden form-card">
            @csrf
            @method('PUT')
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6'
                    })
                </script>
            @endif
            @if(session('errpr'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#3085d6'
                    })
                </script>
            @endif


            <!-- Personal Information Section -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-green-600 mr-3"></i>Personal Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="first_name">First Name
                            *</label>
                        <input id="first_name" name="first_name" type="text" value="{{ $user->first_name }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter first name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="last_name">Last Name *</label>
                        <input id="last_name" name="last_name" type="text" value="{{ $user->last_name }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter last name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="middle_name">Middle
                            Name</label>
                        <input id="middle_name" name="middle_name" type="text" value="{{ $user->middle_name }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter middle name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="birthdate">Birthdate *</label>
                        <input id="birthdate" name="birthdate" type="date" value="{{ $user->birthdate->format('Y-m-d') }}"
                            required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="sex">Sex *</label>
                        <select id="sex" name="sex" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus">
                            <option value="">Select sex</option>
                            <option value="male" {{ $user->sex == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $user->sex == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="marital_status">Marital
                            Status</label>
                        <select id="marital_status" name="marital_status"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus">
                            <option value="">Select status</option>
                            <option value="single" {{ $user->marital_status == 'single' ? 'selected' : '' }}>Single
                            </option>
                            <option value="married" {{ $user->marital_status == 'married' ? 'selected' : '' }}>Married
                            </option>
                            <option value="separated" {{ $user->marital_status == 'separated' ? 'selected' : '' }}>
                                Separated</option>
                            <option value="widowed" {{ $user->marital_status == 'widowed' ? 'selected' : '' }}>Widowed
                            </option>
                            <option value="annulled" {{ $user->marital_status == 'annulled' ? 'selected' : '' }}>Annulled
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="baptism_date">Baptism
                            Date</label>
                        <input id="baptism_date" name="baptism_date" type="date" value="{{ $user->baptism_date }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus">
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text- text-green-600  mr-3"></i>Contact Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email Address *</label>
                        <input id="email" name="email" type="email" value="{{ $user->email }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter email address">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">Phone Number *</label>
                        <input id="phone" name="phone" type="tel" value="{{ $user->phone }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter phone number">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="district">District *</label>
                        <input id="district" name="district" type="text" value="{{ $user->district }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter district">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="locale">Locale *</label>
                        <input id="locale" name="locale" type="text" value="{{ $user->locale }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter locale">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="purok_grupo">Purok/Grupo
                            *</label>
                        <input id="purok_grupo" name="purok_grupo" type="text" value="{{ $user->purok_grupo }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter purok/grupo">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="address">Complete Address
                            *</label>
                        <textarea id="address" name="address" required rows="3"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring- text-green-600  input-focus"
                            placeholder="Enter complete address">{{ $user->address }}</textarea>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-file-upload text- text-green-600  mr-3"></i>Document Upload
                    <i class="font-thin text-sm"> (Do not upload if you want it to remain unchanged)</i>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer">
                        <i class="fas fa-user-circle text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600 font-medium">Profile Image</p>
                        <p class="text-gray-500 text-sm mt-1">Click to upload or drag and drop</p>
                        <p class="text-gray-400 text-xs mt-1">JPG, PNG (Max 2MB)</p>
                        <input type="file" class="hidden" id="profile_image" name="profile_image" accept="image/*">
                    </div>

                    <div
                        class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer">
                        <i class="fas fa-file-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600 font-medium">Document Image</p>
                        <p class="text-gray-500 text-sm mt-1">Click to upload or drag and drop</p>
                        <p class="text-gray-400 text-xs mt-1">JPG, PNG, PDF (Max 5MB)</p>
                        <input type="file" class="hidden" id="document_image" name="document_image" accept="image/*,.pdf">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 flex flex-col md:flex-row justify-end items-center">

                <div class="flex space-x-3">
                    <a href="{{ route('admin.members') }}">
                        <button type="button"
                            class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                            Cancel
                        </button>
                    </a>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-green-600  text-white font-medium hover:bg-green-600 transition">
                        Update Account
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // File upload functionality
        document.querySelectorAll('.upload-area').forEach(area => {
            const input = area.querySelector('input[type="file"]');

            area.addEventListener('click', () => {
                input.click();
            });

            area.addEventListener('dragover', (e) => {
                e.preventDefault();
                area.classList.add('border-indigo-400', 'bg-indigo-50');
            });

            area.addEventListener('dragleave', () => {
                area.classList.remove('border-indigo-400', 'bg-indigo-50');
            });

            area.addEventListener('drop', (e) => {
                e.preventDefault();
                area.classList.remove('border-indigo-400', 'bg-indigo-50');

                if (e.dataTransfer.files.length) {
                    input.files = e.dataTransfer.files;

                    // Update UI to show file name
                    const fileName = e.dataTransfer.files[0].name;
                    area.querySelector('p.text-gray-600').textContent = fileName;
                    area.querySelector('p.text-gray-500').textContent = 'File ready for upload';
                }
            });

            input.addEventListener('change', () => {
                if (input.files.length) {
                    const fileName = input.files[0].name;
                    area.querySelector('p.text-gray-600').textContent = fileName;
                    area.querySelector('p.text-gray-500').textContent = 'File ready for upload';
                }
            });
        });
    </script>
@endsection