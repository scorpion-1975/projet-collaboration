@extends('layouts.app')

@section('content')
<div class="container">

    <div class="pagetitle">
        <h1>Modifier la tâche : {{ $task->title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Tous les projets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a></li>
                <li class="breadcrumb-item active">Modifier la tâche</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row justify-content-center">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>

            <div class="col-md-12">
                <div class="card mt-2 p-2">
                    <form action="{{ route('tasks.update', ['project' => $project->id, 'task' => $task->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Titre de la tâche</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Date d'échéance</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Statut</label>
                            <select name="status" id="status" class="form-select">
                                <option value="en cours" {{ old('status', $task->status) == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminée" {{ old('status', $task->status) == 'terminée' ? 'selected' : '' }}>Terminée</option>
                                <option value="suspendue" {{ old('status', $task->status) == 'suspendue' ? 'selected' : '' }}>Suspendue</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Assigné à</label>
                            <select name="user_id" id="user_id" class="form-select">
                                <option value="">Aucun</option>
                                @foreach ($project->users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == old('user_id', $task->user_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div  class="mb-3">
                            <label for="files">Ajouter des fichiers :</label>
                            <input type="file" name="files[]" multiple class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à jour la tâche</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
