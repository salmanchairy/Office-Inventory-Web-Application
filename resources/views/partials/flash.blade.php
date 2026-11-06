@foreach (['success', 'error', 'warning'] as $type)
    @if (session($type))
        <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show" role="alert">{{ session($type) }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
@endforeach
@if ($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
