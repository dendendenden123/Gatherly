@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('css/admin/members/index.css') }}" rel="stylesheet">
@endsection

@section('header')
    <div class="members-header">
        <div class="members-title">
            <h1>Member Management</h1>
            <p>View and manage all church members</p>
        </div>
    </div>

    <div
        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 cursor-pointer">
        <a href="{{ route('admin.members.recalculateMemberStatus') }}" class="hover:no-underline">
            Recalculate Status
        </a>
    </div>
@endsection

@section('content')
    <!-- Filters -->
    <form id="filterForm" action="{{ route('admin.members') }}" class="members-filters">


        <div class="filter-group">
            <label>Status:</label>
            <select name="status">
                <option value="">All Members</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="partially-active">Partially Active</option>
                <option value="expelled">Expelled</option>
                <option value="transferred">Transferred</option>
                <option value="pending">Requesting for Transfer</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Volunteers:</label>
            <select name="role">
                <option value="">All Volunteers</option>
                <option value="0">None</option>
                <option value="1">Minister</option>
                <option value="2">Head Deacon</option>
                <option value="3">Deacon</option>
                <option value="4">Deaconess</option>
                <option value="5">Choir</option>
                <option value="6">Secretary</option>
                <option value="7">Finance</option>
                <option value="8">SCAN</option>
                <option value="9">Overseer</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Sort By:</label>
            <select name="sort">
                <option value="latest">Recently Added</option>
                <option value="alphabetAsc">Name (A-Z)</option>
                <option value="alphabetDesc">Name (Z-A)</option>
                <option value="locale">Locale</option>
            </select>
        </div>

        <div class="members-search">
            <i class="fas fa-search"></i>
            <input name="memberName" id="member-search" type="text" placeholder="Search members...">
        </div>




    </form>
    <div class="index-list ">
        @include('admin.members.index-list')
    </div>

    @vite('resources/js/admin-members-index.js')
@endsection