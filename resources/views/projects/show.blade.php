@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('projects') }}" class="btn btn-link">
            <i class="fas fa-arrow-left"></i> Retour aux projets
        </a>
    </div>
    <div class="row">
        <!-- Détails du projet -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="h3 mb-0">{{ $project->name }}</h1>
                        <div>
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline-primary me-2">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="text-muted">{{ $project->description }}</p>
                    <div class="small text-muted">
                        <i class="far fa-calendar-alt"></i> Créé le {{ $project->created_at->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de création de tâche -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Nouvelle Tâche</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de la tâche</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Date de début</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Date de fin</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Créer la tâche
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des tâches -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Tâches du projet</h5>
                </div>
                <div class="card-body">
                    @if($project->tasks->count() > 0)
                        <div class="list-group">
                            @foreach($project->tasks as $task)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1">{{ $task->name }}</h6>
                                        <div>
                                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="collapse" 
                                                data-bs-target="#task-{{ $task->id }}">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="collapse" id="task-{{ $task->id }}">
                                        <div class="mt-3">
                                            <p class="mb-1">{{ $task->description }}</p>
                                            <div class="small text-muted">
                                                <span class="me-3">
                                                    <i class="fas fa-calendar-alt"></i> Début: {{ $task->start_date }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-flag"></i> Fin: {{ $task->end_date }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <p>Aucune tâche n'a encore été créée pour ce projet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
}
.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
@endsection
