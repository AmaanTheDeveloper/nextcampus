<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Blocked</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            color: #fff;
        }
        .container {
            text-align: center;
            background: rgba(0,0,0,0.4);
            padding: 2rem 3rem;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            max-width: 400px;
            animation: fadeIn 0.6s ease-out;
        }
        h1 {
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        p {
            margin-bottom: 2rem;
            line-height: 1.5;
        }
        a.button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #e67e22;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: transform 0.2s, background 0.2s;
        }
        a.button:hover {
            background: #d35400;
            transform: translateY(-2px);
        }
        @keyframes fadeIn {
            from {opacity:0; transform:scale(0.95);} to {opacity:1; transform:scale(1);}
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Account Blocked</h1>
        <p>{{ auth()->user()->block_message ?? 'Your account has been blocked by the administration.' }}</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="button" style="border:none;cursor:pointer;">Logout</button>
        </form>
    </div>
</body>
</html>
