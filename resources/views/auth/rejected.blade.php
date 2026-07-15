@extends('layouts.bootstrap')

@section('title', 'Registration Rejected - NextCampus')

@section('body')
    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="p-5 bg-white rounded-4 border shadow-sm animate-fade-in-up">
                    <div class="fs-1 text-danger mb-4"><i class="bi bi-x-circle-fill"></i></div>
                    <h2 class="fw-bold text-navy mb-3">Registration Rejected</h2>
                    <p class="text-secondary mb-4">
                        Unfortunately, your account request as a <strong>{{ ucfirst(auth()->user()->role) }}</strong> has been rejected by our administration team.
                    </p>
                    <div class="alert alert-danger small text-start border mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> If you believe this was an error, please contact support at <strong>support@nextcampus.com</strong>.
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ url('/') }}" class="btn btn-premium-outline"><i class="bi bi-house"></i> Home</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-premium"><i class="bi bi-box-arrow-right"></i> Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
