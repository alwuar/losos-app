@if (session('status'))
    <div class="alert alert-success admin-alert" role="status">
        <i class="bi bi-check-circle" aria-hidden="true"></i> {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger admin-alert" role="alert">
        <i class="bi bi-exclamation-triangle" aria-hidden="true"></i> {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger admin-alert" role="alert">
        <strong>Revisa los campos marcados.</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
