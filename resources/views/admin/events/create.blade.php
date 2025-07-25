@extends('layouts.admin')


@section('header')
    <div class="header">
        <div class="header-title">
            <h1>Gatherly - Events Management</h1>
        </div>
        <div class="user-avatar"></div>
    </div>
@endsection

@section('content')
    <div class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="modal-container bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="modal-header bg-[--primary-green] text-white p-4 rounded-t-lg flex justify-between items-center">
                <h3 class="text-xl font-semibold">Create New Event</h3>
                <button @click="showCreateModal = false" class="text-white hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="modal-body p-6">
                <form @submit.prevent="submitEventForm">
                    <!-- Event Name -->
                    <div class="mb-4">
                        <label for="eventName" class="block text-sm font-medium text-gray-700 mb-1">Event Name *</label>
                        <input type="text" id="eventName" v-model="eventForm.name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[--primary-green] focus:border-transparent">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="eventDescription"
                            class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="eventDescription" v-model="eventForm.description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[--primary-green] focus:border-transparent"></textarea>
                    </div>

                    <!-- Date/Time Row -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <!-- Start Date -->
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                            <input type="date" id="startDate" v-model="eventForm.start_date" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[--primary-green] focus:border-transparent">
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="startTime" class="block text-sm font-medium text-gray-700 mb-1">Start Time *</label>
                            <input type="time" id="startTime" v-model="eventForm.start_time" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[--primary-green] focus:border-transparent">
                        </div>
                    </div>

                    <!-- Location & Volunteers -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" id="location" v-model="eventForm.location"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[--primary-green] focus:border-transparent">
                        </div>

                        <!-- Volunteers -->
                        <div>
                            <label for="volunteers" class="block text-sm font-medium text-gray-700 mb-1">Volunteers
                                Needed</label>
                            <input type="number" id="volunteers" v-model="eventForm.volunteers_needed" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[--primary-green] focus:border-transparent">
                        </div>
                    </div>

                    <!-- Recurring Event Toggle -->
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" id="isRecurring" v-model="eventForm.is_recurring"
                            class="h-4 w-4 text-[--primary-green] focus:ring-[--primary-green] border-gray-300 rounded">
                        <label for="isRecurring" class="ml-2 block text-sm text-gray-700">Recurring Event</label>
                    </div>

                    <!-- Recurring Options (Conditional) -->
                    <div v-if="eventForm.is_recurring" class="mb-4 bg-[--light-gray] p-3 rounded-md">
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div>
                                <label for="repeatFrequency"
                                    class="block text-sm font-medium text-gray-700 mb-1">Frequency</label>
                                <select id="repeatFrequency" v-model="eventForm.repeat_frequency"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[--primary-green] focus:border-transparent">
                                    <option value="weekly">Weekly</option>
                                    <option value="biweekly">Bi-Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div>
                                <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="date" id="endDate" v-model="eventForm.repeat_until"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[--primary-green] focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" @click="showCreateModal = false"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[--primary-green]">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-[--primary-green] border border-transparent rounded-md text-sm font-medium text-white hover:bg-[--dark-green] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[--dark-green]">
                            Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection