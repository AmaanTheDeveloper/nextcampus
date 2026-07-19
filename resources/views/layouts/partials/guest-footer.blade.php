<footer class="bg-white border-top pt-5 pb-4 mt-auto">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <a class="navbar-brand fw-bold fs-4 text-navy d-flex align-items-center mb-3" href="{{ url('/') }}">
                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>NextCampus
                </a>
                <p class="text-secondary small pe-lg-5 mb-4">The enterprise university ecosystem bridging the gap between academic learning and professional success.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-sm btn-light rounded-circle text-secondary border"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="btn btn-sm btn-light rounded-circle text-secondary border"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="btn btn-sm btn-light rounded-circle text-secondary border"><i class="bi bi-github"></i></a>
                    <a href="#" class="btn btn-sm btn-light rounded-circle text-secondary border"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold text-navy mb-3">Platform</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('guest.internships') }}" class="text-secondary text-decoration-none hover-primary">Internships</a></li>
                    <li><a href="{{ route('guest.scholarships') }}" class="text-secondary text-decoration-none hover-primary">Scholarships</a></li>
                    <li><a href="{{ route('guest.competitions') }}" class="text-secondary text-decoration-none hover-primary">Hackathons</a></li>
                    <li><a href="{{ route('guest.events') }}" class="text-secondary text-decoration-none hover-primary">Events</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold text-navy mb-3">Tools</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">Resume Builder</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">Portfolio Generator</a></li>
                    <li><a href="{{ route('guest.notes') }}" class="text-secondary text-decoration-none hover-primary">Study Notes</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">AI Assistant</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold text-navy mb-3">Company</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">About Us</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">Careers</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">Contact</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">Partners</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold text-navy mb-3">Legal</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">Privacy Policy</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">Terms of Service</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-primary">Cookie Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="border-top pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="text-secondary small mb-0">&copy; {{ date('Y') }} NextCampus Enterprise. All rights reserved.</p>
            <p class="text-secondary small mb-0 mt-2 mt-md-0">Designed for Excellence.</p>
        </div>
    </div>
</footer>
