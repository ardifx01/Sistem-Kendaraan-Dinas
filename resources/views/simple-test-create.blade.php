<!DOCTYPE html>
<html>
<head>
    <title>Simple Test Create</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Simple Test Create</h1>

    @auth
        <p>User: {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
        <p>Session ID: {{ session()->getId() }}</p>
        <p>CSRF Token: {{ csrf_token() }}</p>
    @else
        <p>Not authenticated</p>
    @endauth

    @if ($errors->any())
        <div style="color: red;">
            <strong>Errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('test.vehicle.create') }}">
        @csrf
        <p><input type="submit" value="Create Test Vehicle"></p>
    </form>

    <div id="result"></div>

    <script>
        // Handle form submission with AJAX
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            console.log('Form submitted');
            console.log('Action:', this.action);
            console.log('Method:', this.method);
            console.log('CSRF Token:', document.querySelector('input[name="_token"]').value);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = '<div style="color: red;">Error: ' + error.message + '</div>';
            });
        });
    </script>
</body>
</html>
