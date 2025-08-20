<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Registration | Church Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <!-- Header -->
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-secondary mb-2">Guest Registration</h1>
            <p class="text-gray-600">Welcome to our church! Please provide your information</p>
        </header>

        <!-- Guest Form Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
            <!-- Card Header -->
            <div class="bg-primary px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Guest Information</h2>
            </div>

            <!-- Form Body -->
            <form class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- First Name -->
                    <div>
                        <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                        <input type="text" id="first-name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                        <input type="text" id="last-name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <!-- Phone -->
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                    <input type="tel" id="phone" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" id="address"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <!-- How did you hear about us? -->
                <div class="mb-6">
                    <label for="referral" class="block text-sm font-medium text-gray-700 mb-1">How did you hear about
                        us?</label>
                    <select id="referral"
                        class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Select an option</option>
                        <option>Friend/Family</option>
                        <option>Website</option>
                        <option>Social Media</option>
                        <option>Community Event</option>
                        <option>Drive By</option>
                        <option>Other</option>
                    </select>
                </div>

                <!-- Additional Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                    <textarea id="notes" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                </div>

                <!-- Photo Consent -->
                <div class="mb-6 flex items-start">
                    <div class="flex items-center h-5">
                        <input id="photo-consent" type="checkbox"
                            class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="photo-consent" class="font-medium text-gray-700">Photo Consent</label>
                        <p class="text-gray-500">I consent to having my photo taken during church events</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3">
                    <button type="button"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-secondary hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Register Guest
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>* indicates required fields</p>
            <p class="mt-2">Your information will be kept confidential and used only for church purposes.</p>
        </div>
    </div>
</body>

</html>