@extends('layouts.marketplace')

@section('title', 'Manage users')

@section('content')

    <h1 class="text-2xl font-bold mb-4">Users</h1>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Reg. no.</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t">
                        <td class="p-3">{{ $user->name }}<br>
                            <span class="text-xs text-gray-500">{{ $user->email }}</span></td>
                        <td class="p-3">{{ $user->reg_no ?? '-' }}</td>
                        <td class="p-3">{{ $user->phone ?? '-' }}</td>
                        <td class="p-3">{{ ucfirst($user->role) }}</td>
                        <td class="p-3">{{ ucfirst($user->status) }}</td>
                        <td class="p-3">
                            @if ($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    @if ($user->status === 'active')
                                        <input type="hidden" name="status" value="suspended">
                                        <button class="text-red-600 hover:underline">Suspend</button>
                                    @else
                                        <input type="hidden" name="status" value="active">
                                        <button class="text-green-700 hover:underline">
                                            {{ $user->status === 'pending' ? 'Approve' : 'Reactivate' }}
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection