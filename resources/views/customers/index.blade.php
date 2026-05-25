@extends('layouts.app')

@section('header_title', 'Customers')

@section('content')
<div class="flex flex-col gap-5" x-data="{ 
    showAddModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }}, 
    showEditModal: {{ $errors->any() && old('_method') == 'PUT' ? 'true' : 'false' }}, 
    showDeleteModal: false,
    deleteUrl: '',
    editForm: { id: '', customer_id: '', name: '', email: '', address: '', status: '' } 
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
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Customer ID</th>
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Customer Name</th>
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Email</th>
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Address</th>
                    <th class="py-4 px-6 font-medium whitespace-nowrap">Status</th>
                    <th class="py-4 px-6 font-medium text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse ($customers as $customer)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors relative">
                        <td class="py-4 px-6">{{ $customer['customer_id'] ?? $customer['id'] }}</td>
                        <td class="py-4 px-6 font-medium">{{ $customer['name'] }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ $customer['email'] ?? '-' }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ $customer['address'] ?? '-' }}</td>
                        
                        <td class="py-4 px-6">
                            @if(in_array(strtolower((string)($customer['status'] ?? '0')), ['active', '1', 'true']))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-green-50 text-green-600">Active</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-500">Inactive</span>
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
                                     class="absolute right-8 top-0 w-36 bg-white border border-gray-100 rounded-lg shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] py-2 z-50 text-left">
                                    
                                    @if(!in_array(strtolower((string)($customer['status'] ?? '0')), ['active', '1', 'true']))
                                    <form action="{{ route('customers.updateStatus', $customer['id']) }}" method="POST" class="w-full m-0 p-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                            Active
                                        </button>
                                    </form>
                                    @endif

                                    @if(in_array(strtolower((string)($customer['status'] ?? '0')), ['active', '1', 'true']))
                                    <form action="{{ route('customers.updateStatus', $customer['id']) }}" method="POST" class="w-full m-0 p-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="0">
                                        <button type="submit" class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            Deactivate
                                        </button>
                                    </form>
                                    @endif

                                    <button @click="
                                        editForm = {
                                            id: '{{ $customer['id'] }}',
                                            customer_id: '{{ $customer['customer_id'] ?? '' }}',
                                            name: '{{ $customer['name'] }}',
                                            email: '{{ $customer['email'] ?? '' }}',
                                            address: '{{ $customer['address'] ?? '' }}',
                                            status: '{{ (in_array(strtolower((string)($customer['status'] ?? '0')), ['active', '1', 'true'])) ? '1' : '0' }}'
                                        };
                                        showEditModal = true;
                                        open = false;
                                    " class="w-full px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2 border-t border-gray-100 mt-1 pt-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </button>
                                    
                                    <button type="button" @click="
                                        deleteUrl = '{{ route('customers.destroy', $customer['id']) }}';
                                        showDeleteModal = true;
                                        open = false;
                                    " class="w-full px-4 py-2.5 text-[13px] font-medium text-red-600 hover:bg-red-50 flex items-center gap-2 text-left">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500 font-medium">No customer data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-show="showAddModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px]" style="display: none;">
        <div @click.outside="showAddModal = false" class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100"><h3 class="text-xl font-bold text-gray-800 text-center">Add Customer</h3></div>
            <form action="{{ route('customers.store') }}" method="POST" class="p-8 space-y-5">
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
                    <label class="block text-sm font-bold text-gray-700">Customer ID</label>
                    <input type="text" name="customer_id" value="{{ old('customer_id') }}" placeholder="Enter your ID" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('customer_id') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Customer Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter your address" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('address') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Status</label>
                    <select name="status" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('status') && !old('_method') ? 'border-red-500' : 'border-gray-200' }} text-sm bg-white">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="showAddModal = false" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-[#333b47] hover:bg-slate-800 text-white rounded-lg text-sm font-bold">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showEditModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px]" style="display: none;">
        <div @click.outside="showEditModal = false" class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100"><h3 class="text-xl font-bold text-gray-800 text-center">Edit Customer</h3></div>
            
            <form x-bind:action="'/customers/' + editForm.id" method="POST" class="p-8 space-y-5">
                @csrf
                @method('PUT')

                @if($errors->any() && old('_method') == 'PUT')
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
                    <label class="block text-sm font-bold text-gray-700">Customer ID</label>
                    <input type="text" name="customer_id" x-model="editForm.customer_id" placeholder="Enter your ID" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('customer_id') && old('_method') == 'PUT' ? 'border-red-500' : 'border-gray-200' }} text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Customer Name</label>
                    <input type="text" name="name" x-model="editForm.name" placeholder="Enter your name" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') && old('_method') == 'PUT' ? 'border-red-500' : 'border-gray-200' }} text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Email</label>
                    <input type="email" name="email" x-model="editForm.email" placeholder="Enter your email" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') && old('_method') == 'PUT' ? 'border-red-500' : 'border-gray-200' }} text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Address</label>
                    <input type="text" name="address" x-model="editForm.address" placeholder="Enter your address" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('address') && old('_method') == 'PUT' ? 'border-red-500' : 'border-gray-200' }} text-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Status</label>
                    <select name="status" x-model="editForm.status" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('status') && old('_method') == 'PUT' ? 'border-red-500' : 'border-gray-200' }} text-sm bg-white">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="showEditModal = false" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-[#333b47] hover:bg-slate-800 text-white rounded-lg text-sm font-bold">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showDeleteModal" 
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px]" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.outside="showDeleteModal = false" 
             class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 overflow-hidden text-center"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-50 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h3 class="text-lg font-bold text-gray-800 mb-2">Delete Customer</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this customer? This action cannot be undone.</p>
            
            <form x-bind:action="deleteUrl" method="POST" class="flex justify-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" @click="showDeleteModal = false" 
                        class="px-5 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold shadow-md transition-all active:scale-95">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
    </div>
@endsection