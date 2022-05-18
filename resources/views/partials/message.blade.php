@if (session()->has('errors'))
    <div class="alert alert-danger">
        <ul>
            @foreach (session()->get('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session()->get('success') }}</li>
        </ul>
    </div>
@endif

@if (session()->has('info'))
    <div class="alert alert-info">
        <ul>
            @foreach (session()->get('info') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
