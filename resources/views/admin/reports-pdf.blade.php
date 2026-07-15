<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1e293b; }
        .header { background: #1e3a8a; color: white; padding: 20px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 4px 0 0 0; font-size: 11px; opacity: 0.8; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f1f5f9; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; color: #64748b; border-bottom: 2px solid #e2e8f0; }
        td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        tr:nth-child(even) { background: #f8fafc; }
        .badge { background: #2563eb; color: white; padding: 2px 8px; border-radius: 99px; font-size: 10px; }
        .footer { margin-top: 30px; font-size: 10px; color: #94a3b8; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>NextCampus – {{ $title }}</h2>
        <p>Generated on: {{ date('F d, Y \a\t h:i A') }}</p>
    </div>

    @if($type === 'students')
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Name</th><th>Email</th><th>Institute</th><th>Registered</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->studentProfile->institute ?? 'N/A' }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($type === 'internships')
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Title</th><th>Company</th><th>Location</th><th>Deadline</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->company?->companyProfile?->company_name ?? $item->company?->name ?? 'N/A' }}</td>
                        <td>{{ $item->location }}</td>
                        <td>{{ $item->deadline->format('M d, Y') }}</td>
                        <td><span class="badge">{{ ucfirst($item->status) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($type === 'competitions')
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Title</th><th>Category</th><th>Reg. Deadline</th><th>Start Date</th><th>End Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->category->name ?? 'N/A' }}</td>
                        <td>{{ $item->registration_deadline->format('M d, Y') }}</td>
                        <td>{{ $item->start_date->format('M d, Y') }}</td>
                        <td>{{ $item->end_date->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($type === 'events')
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Title</th><th>Type</th><th>Location</th><th>Event Date</th><th>Reg. Deadline</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->location }}</td>
                        <td>{{ $item->event_date->format('M d, Y') }}</td>
                        <td>{{ $item->registration_deadline->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        NextCampus — Student Opportunity & Career Platform &bull; Generated automatically by the Admin Panel
    </div>
</body>
</html>
