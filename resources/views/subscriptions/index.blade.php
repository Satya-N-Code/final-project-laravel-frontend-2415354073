@extends('layouts.app')

@section('header_title', 'Subscriptions')

@section('content')
<div class="flex flex-col gap-5">
    
    <div class="flex justify-end">
        <button class="bg-[#333b47] hover:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Data
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] border border-gray-100 overflow-visible">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-gray-100 text-gray-600 text-sm">
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Customer Name</th>
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Service</th>
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Service Period</th>
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Status</th>
                    <th class="py-4 px-6 font-medium text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                
                @forelse ($subscriptions as $sub)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors relative">
                        <td class="py-4 px-6 font-medium">{{ $sub['customer_name'] ?? $sub['customer']['name'] ?? '-' }}</td>
                        
                        <td class="py-4 px-6 text-gray-500">{{ $sub['service_name'] ?? $sub['service']['name'] ?? '-' }}</td>
                        
                        <td class="py-4 px-6 text-gray-500 whitespace-nowrap">
                            {{ $sub['start_date'] ?? '-' }} - {{ $sub['end_date'] ?? '-' }}
                        </td>
                        
                        <td class="py-4 px-6">
                            @if($sub['status'] === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-green-50 text-green-600">Active</span>
                            @elseif($sub['status'] === 'trial')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-orange-50 text-orange-600">Trial</span>
                            @elseif($sub['status'] === 'isolir')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-600">Isolir</span>
                            @elseif($sub['status'] === 'dismantle')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-600">Dismantle</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-gray-100 text-gray-500">Inactive</span>
                            @endif
                        </td>
                        
                        <td class="py-4 px-6 text-center" x-data="{ open: false }">
                            <div class="relative inline-block text-left">
                                <button @click="open = !open" @click.outside="open = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-md focus:outline-none">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </button>

                                <div x-show="open" style="display: none;" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-8 top-0 w-40 bg-white border border-gray-100 rounded-lg shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] py-2 z-50 text-left">
                                    
                                    <button class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                        Active
                                    </button>
                                    
                                    <button class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        Deactivate
                                    </button>

                                    <button class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3h12v4l-5 5 5 5v4H6v-4l5-5-5-5V3z"></path></svg>
                                        Trial
                                    </button>

                                    <button class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Isolir
                                    </button>

                                    <button class="w-full px-4 py-2.5 text-[13px] font-medium text-red-600 hover:bg-red-50 flex items-center gap-2 border-t border-gray-100 mt-1 pt-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Dismantle
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500 font-medium">
                            No subscription data available.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
@endsection