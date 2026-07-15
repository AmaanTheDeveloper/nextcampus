@extends('layouts.dashboard-layout')

@section('page-title', 'Pending Approvals')

@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-person-check text-primary me-2"></i>Pending Teacher & Company Approvals</h5>

    @if($pendingUsers->isEmpty())
        <div class="text-center py-5">
            <div class="fs-1 text-success"><i class="bi bi-check-circle"></i></div>
            <p class="text-secondary mt-2">All accounts are reviewed. No pending approvals.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table datatables table-hover align-middle">
                <thead class="table-light small text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Details</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach($pendingUsers as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold text-navy">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'teacher' ? 'bg-info' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                @if($user->role === 'teacher')
                                    <span class="text-secondary"><i class="bi bi-building me-1"></i>{{ $user->teacherProfile?->department ?? 'N/A' }}</span>
                                @elseif($user->role === 'company')
                                    <span class="text-secondary"><i class="bi bi-briefcase me-1"></i>{{ $user->companyProfile?->company_name ?? 'N/A' }}</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-lg me-1"></i>Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this account?')">
                                            <i class="bi bi-x-lg me-1"></i>Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
