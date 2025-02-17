@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="pagetitle d-flex flex-wrap justify-content-between ">
            <div>
                <h1>{{ $project->title }}</h1>

                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Lites projets</a></li>
                        <li class="breadcrumb-item active">Tableau de bord</li>
                    </ol>
                </nav>
            </div>

            <div>
                <a class="btn btn-info">
                    <strong>Date début :</strong> {{ $project->start_date ?? 'Non définie' }}
                    <br>
                    <strong>Date limite :</strong> {{ $project->end_date ?? 'Non définie' }}
                </a>
            </div>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row justify-content-center  ">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>

                <div class="col-md-12">

                    <details>
                        <summary class="btn btn-primary">Cliquer pour ajouter tache</summary>

                        <div class="card mt-2 p-2">
                            <form action="{{ route('tasks.store', $project->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titre de la tâche</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Date d'échéance</label>
                                    <input type="date" name="due_date" id="due_date" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Statut</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="en cours">En cours</option>
                                        <option value="terminée">Terminée</option>
                                        <option value="suspendue">Suspendue</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Assigné à</label>
                                    <select name="user_id" id="user_id" class="form-select">
                                        <option value="">Aucun</option>
                                        @foreach ($project->users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="file" class="form-label">Fichier</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Ajouter Tâche</button>
                            </form>

                        </div>
                    </details>

                    <details>
                        <summary class="btn btn-primary my-2">Cliquer pour changer statut</summary>
                        <div class="card mt-2 p-2">
                            <form action="{{ route('projects.updateStatus', $project->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <label for="status">Changer le statut :</label>
                                <select name="status" id="status" class="form-select mt-2 d-inline w-100" required>
                                    <option value="en cours" {{ $project->status == 'en cours' ? 'selected' : '' }}>En cours
                                    </option>
                                    <option value="terminé" {{ $project->status == 'terminé' ? 'selected' : '' }}>Terminé
                                    </option>
                                    <option value="en attente" {{ $project->status == 'en attente' ? 'selected' : '' }}>En
                                        attente</option>
                                </select>
                                <button type="submit" class="btn btn-primary mt-2 w-100">Mettre à jour</button>
                            </form>


                        </div>
                    </details>

                </div>



                <!-- Left side columns -->
                <div class="col-lg-12 ">
                    <div class="card p-2">

                        <!-- Liste des tâches -->
                        <h4>Liste des tâches</h4>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Description</th>
                                        <th>Date limite</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Non définie' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="btn btn-sm p-1
                                                @if ($task->status == 'en cours') btn-warning
                                                @elseif($task->status == 'terminée')  btn-success
                                                @elseif($task->status == 'suspendue')  btn-secondary @endif">
                                                    {{ ucfirst($task->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <!-- Actions (modifier, supprimer) -->
                                                <a href="{{ route('tasks.edit', ['project' => $project->id, 'task' => $task->id]) }}"
                                                    class="btn btn-warning btn-sm">Modifier</a>


                                                <form
                                                    action="{{ route('tasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <div class="card p-2">

                        <!-- Liste des tâches -->
                        <h4>Utilisateurs associé</h4>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->pivot->role }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
