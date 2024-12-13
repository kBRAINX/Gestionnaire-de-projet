@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Mes Projets</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau Projet
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($projects as $project)
            <div class="col">
                <div class="card h-100 shadow-sm hover-shadow">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($project->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-muted">
                                <i class="far fa-calendar-alt"></i> {{ $project->created_at->format('d/m/Y') }}
                            </div>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary btn-sm">
                                Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    Vous n'avez pas encore de projets. 
                    <a href="{{ route('projects.create') }}" class="alert-link">Créez votre premier projet</a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection
