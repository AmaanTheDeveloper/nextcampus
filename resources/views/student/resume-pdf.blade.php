<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $resume->personal_info['name'] ?? 'Resume' }} - CV</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; }
        .header { background: #1e3a8a; color: white; padding: 28px 30px; }
        .header h1 { font-size: 22px; letter-spacing: 1px; margin-bottom: 4px; }
        .header .contact { font-size: 10px; opacity: 0.85; margin-top: 6px; }
        .header .contact span { margin-right: 16px; }
        .main { padding: 20px 30px; }
        .section { margin-bottom: 18px; }
        .section-title { font-size: 12px; font-weight: bold; color: #1e3a8a; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #1e3a8a; padding-bottom: 4px; margin-bottom: 10px; }
        .summary { color: #475569; font-size: 11px; line-height: 1.6; }
        .item { margin-bottom: 10px; }
        .item-header { display: flex; justify-content: space-between; }
        .item-title { font-weight: bold; color: #0f172a; }
        .item-date { color: #94a3b8; font-size: 10px; }
        .item-sub { color: #2563eb; font-size: 10px; margin-bottom: 3px; }
        .item-desc { color: #475569; font-size: 10px; margin-top: 3px; }
        .skills-grid { display: flex; flex-wrap: wrap; gap: 6px; }
        .skill-tag { background: #eff6ff; color: #1e3a8a; border: 1px solid #bfdbfe; padding: 3px 10px; border-radius: 99px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $resume->personal_info['name'] ?? auth()->user()->name }}</h1>
        <div class="contact">
            @if(!empty($resume->personal_info['email']))
                <span>{{ $resume->personal_info['email'] }}</span>
            @endif
            @if(!empty($resume->personal_info['phone']))
                <span>{{ $resume->personal_info['phone'] }}</span>
            @endif
            @if(!empty($resume->personal_info['address']))
                <span>{{ $resume->personal_info['address'] }}</span>
            @endif
            @if(!empty($resume->personal_info['website']))
                <span>{{ $resume->personal_info['website'] }}</span>
            @endif
        </div>
    </div>

    <div class="main">
        @if(!empty($resume->personal_info['summary']))
            <div class="section">
                <div class="section-title">Professional Summary</div>
                <p class="summary">{{ $resume->personal_info['summary'] }}</p>
            </div>
        @endif

        @if(!empty($resume->experience))
            <div class="section">
                <div class="section-title">Work Experience</div>
                @foreach($resume->experience as $exp)
                    <div class="item">
                        <div class="item-header">
                            <span class="item-title">{{ $exp['role'] ?? '' }}</span>
                            <span class="item-date">{{ $exp['start'] ?? '' }} – {{ $exp['end'] ?? 'Present' }}</span>
                        </div>
                        <div class="item-sub">{{ $exp['company'] ?? '' }}</div>
                        @if(!empty($exp['description']))
                            <div class="item-desc">{{ $exp['description'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($resume->education))
            <div class="section">
                <div class="section-title">Education</div>
                @foreach($resume->education as $edu)
                    <div class="item">
                        <div class="item-header">
                            <span class="item-title">{{ $edu['degree'] ?? '' }}</span>
                            <span class="item-date">{{ $edu['start'] ?? '' }} – {{ $edu['end'] ?? 'Present' }}</span>
                        </div>
                        <div class="item-sub">{{ $edu['school'] ?? '' }}</div>
                        @if(!empty($edu['grade']))
                            <div class="item-desc">Grade: {{ $edu['grade'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($resume->projects))
            <div class="section">
                <div class="section-title">Projects</div>
                @foreach($resume->projects as $proj)
                    <div class="item">
                        <div class="item-header">
                            <span class="item-title">{{ $proj['title'] ?? '' }}</span>
                            @if(!empty($proj['link']))
                                <span class="item-date">{{ $proj['link'] }}</span>
                            @endif
                        </div>
                        @if(!empty($proj['technologies']))
                            <div class="item-sub">{{ $proj['technologies'] }}</div>
                        @endif
                        @if(!empty($proj['description']))
                            <div class="item-desc">{{ $proj['description'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($resume->skills))
            <div class="section">
                <div class="section-title">Technical Skills</div>
                <div class="skills-grid">
                    @foreach($resume->skills as $skill)
                        <span class="skill-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>
</html>
