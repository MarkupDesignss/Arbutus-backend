@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">

    <h2 class="text-3xl font-bold bg-gradient-to-r from-teal-500 to-blue-500 bg-clip-text text-transparent">
        Dashboard Overview
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Active Users --}}
        <div class="relative bg-gradient-to-br from-green-500 to-emerald-500 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Total Users</h3>
                <i class="bi bi-person-check text-white text-xl"></i>
            </div>

            <p class="text-4xl font-bold mt-4 text-white">{{ $users }}</p>
            <p class="text-sm text-white/80 mt-2">Currently active users</p>
        </div>

        {{-- Inactive Users --}}
        <div class="relative bg-gradient-to-br from-gray-500 to-slate-600 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Total Subscription</h3>
                <i class="bi bi-person-check-fill text-white text-xl"></i>
            </div>

            <p class="text-4xl font-bold mt-4 text-white">{{ $subscription }}</p>
            <p class="text-sm text-white/80 mt-2">Currently Subscription users</p>
        </div>

        {{-- Total Categories --}}
        <div class="relative bg-gradient-to-br from-blue-500 to-indigo-500 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Total Contact Us</h3>
                <i class="bi bi-people-fill text-white text-xl"></i>

            </div>

            <p class="text-4xl font-bold mt-4 text-white">{{ $contacts }}</p>
            <p class="text-sm text-white/80 mt-2">Currently Contact Us</p>
        </div>

        {{-- Total Items --}}
        <div class="relative bg-gradient-to-br from-yellow-500 to-amber-500 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Total Fund</h3>
                <i class="bi bi-box-seam text-white text-xl"></i>
            </div>

            <p class="text-4xl font-bold mt-4 text-white">{{ $funds }}</p>
            <p class="text-sm text-white/80 mt-2">Currently Funds</p>
        </div>

    </div>
</div>
@endsection
