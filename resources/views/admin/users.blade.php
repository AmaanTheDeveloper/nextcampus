@extends('layouts.dashboard-layout')

@section('page-title', 'Manage Users')

@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-people text-primary me-2"></i>All Registered Users</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle">
            <thead class="table-light small text-secondary">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Block</th>
                    <th>Registered</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($user->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_blocked)
                                <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm" title="Unblock"><i class="bi bi-unlock"></i></button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="reason" value="Blocked by admin via UI">
                                    <button type="submit" class="btn btn-outline-warning btn-sm" title="Block"><i class="bi bi-lock"></i></button>
                                </form>
                            @endif
                        </td>
                        <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                </form>
                            @else
                                <span class="text-muted small">You</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
