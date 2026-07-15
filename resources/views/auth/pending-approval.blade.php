@extends('layouts.bootstrap')

@section('title', 'Pending Approval - NextCampus')

@section('body')
    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="p-5 bg-white rounded-4 border shadow-sm animate-fade-in-up">
                    <div class="fs-1 text-warning mb-4"><i class="bi bi-clock-history"></i></div>
                    <h2 class="fw-bold text-navy mb-3">Registration Pending</h2>
                    <p class="text-secondary mb-4">
                        Thank you for joining NextCampus! Your registration as a <strong>{{ ucfirst(auth()->user()->role) }}</strong> is currently under review by our administration.
                    </p>
                    <div class="alert alert-warning small text-start border mb-4">
                        <h6 class="fw-bold mb-1"><i class="bi bi-info-circle-fill me-1"></i>What happens next?</h6>
                        <ul class="mb-0 ps-3">
                            <li>Our administrative team will verify your credentials.</li>
                            <li>You will gain access to your dashboard once approved.</li>
                            <li>This process usually takes 24-48 hours.</li>
                        </ul>
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
