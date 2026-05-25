@extends('layouts.app')

@section('header_title', 'Subscriptions')

@section('content')
<div class="flex flex-col gap-5" x-data="{ 
    showAddModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }}
}">
    
    @if(session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg text-sm font-medium border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error') && !old('_method'))
        <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg text-sm font-medium border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-end">
        <button @click="showAddModal = true" class="bg-[#333b47] hover:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors shadow-sm">
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
                    @php 
                        $currentStatus = strtolower($sub['status'] ?? 'trial'); 
                    @endphp
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors relative">
                        <td class="py-4 px-6 font-medium">{{ $sub['customer']['name'] ?? 'Unknown Customer' }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ $sub['service']['name'] ?? 'Unknown Service' }}</td>
                        <td class="py-4 px-6 text-gray-500 whitespace-nowrap">
                            {{ $sub['start_date'] ?? '-' }} to {{ $sub['end_date'] ?? '-' }}
                        </td>
                        
                        <td class="py-4 px-6">
                            @if($currentStatus === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-green-50 text-green-600">Active</span>
                            @elseif($currentStatus === 'trial')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-orange-50 text-orange-600">Trial</span>
                            @elseif($currentStatus === 'isolir')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-600">Isolir</span>
                            @elseif($currentStatus === 'dismantle')
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
                                    
                                    @if($currentStatus !== 'dismantle')
                                        @if($currentStatus !== 'active')
                                        <form action="{{ route('subscriptions.updateStatus', $sub['id']) }}" method="POST" class="w-full m-0 p-0">
                                            @csrf @method('PATCH') <input type="hidden" name="status" value="active">
                                            <button type="submit" class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>Active</button>
                                        </form>
                                        @endif
                                        
                                        @if($currentStatus !== 'inactive')
                                        <form action="{{ route('subscriptions.updateStatus', $sub['id']) }}" method="POST" class="w-full m-0 p-0">
                                            @csrf @method('PATCH') <input type="hidden" name="status" value="inactive">
                                            <button type="submit" class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>Inactive</button>
                                        </form>
                                        @endif

                                        @if($currentStatus !== 'trial')
                                        <form action="{{ route('subscriptions.updateStatus', $sub['id']) }}" method="POST" class="w-full m-0 p-0">
                                            @csrf @method('PATCH') <input type="hidden" name="status" value="trial">
                                            <button type="submit" class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3h12v4l-5 5 5 5v4H6v-4l5-5-5-5V3z"></path></svg>Trial</button>
                                        </form>
                                        @endif

                                        @if($currentStatus !== 'isolir')
                                        <form action="{{ route('subscriptions.updateStatus', $sub['id']) }}" method="POST" class="w-full m-0 p-0">
                                            @csrf @method('PATCH') <input type="hidden" name="status" value="isolir">
                                            <button type="submit" class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Isolir</button>
                                        </form>
                                        @endif

                                        <form action="{{ route('subscriptions.updateStatus', $sub['id']) }}" method="POST" class="w-full m-0 p-0" onsubmit="return confirm('Dismantling this subscription will lock it from future status changes. Proceed?');">
                                            @csrf @method('PATCH') <input type="hidden" name="status" value="dismantle">
                                            <button type="submit" class="w-full px-4 py-2.5 text-[13px] font-medium text-red-600 hover:bg-red-50 flex items-center gap-2 border-t border-gray-100 mt-1 pt-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Dismantle</button>
                                        </form>
                                    @else
                                        <div class="px-4 py-3 text-xs text-center text-gray-400 italic">
                                            Action Restricted
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500 font-medium">No subscription data available.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <div x-show="showAddModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px]" style="display: none;">
        <div @click.outside="showAddModal = false" class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100"><h3 class="text-xl font-bold text-gray-800 text-center">Add Subscription</h3></div>
            <form action="{{ route('subscriptions.store') }}" method="POST" class="p-8 space-y-5">
                @csrf
                
                @if($errors->any() && !old('_method'))
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-200">
                        <span class="font-bold">Validasi Gagal:</span>
                        <ul class="list-disc pl-5 mt-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Customer</label>
                    <select name="customer_id" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('customer_id') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm bg-white">
                        <option value="" disabled selected>Select a Customer</option>
                        @foreach($customers as $c)
                            <option value="{{ $c['id'] }}" {{ old('customer_id') == $c['id'] ? 'selected' : '' }}>{{ $c['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Service</label>
                    <select name="service_id" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('service_id') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm bg-white">
                        <option value="" disabled selected>Select a Service</option>
                        @foreach($services as $s)
                            <option value="{{ $s['id'] }}" {{ old('service_id') == $s['id'] ? 'selected' : '' }}>{{ $s['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('start_date') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('end_date') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm">
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Status</label>
                    <select name="status" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('status') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm bg-white">
                        <option value="trial" {{ old('status') == 'trial' ? 'selected' : '' }}>Trial</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="isolir" {{ old('status') == 'isolir' ? 'selected' : '' }}>Isolir</option>
                        <option value="dismantle" {{ old('status') == 'dismantle' ? 'selected' : '' }}>Dismantle</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="showAddModal = false" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-[#333b47] hover:bg-slate-800 text-white rounded-lg text-sm font-bold">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection