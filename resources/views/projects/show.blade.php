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
                <!-- Left side columns -->
                <div class="col-lg-8 ">
                    <div class="card p-2">

                        <!-- Liste des tâches -->
                        <h4>Liste des tâches</h4>

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

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 ">
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
                    <div class="card mt-2 p-2">
                        <form action="{{ route('projects.updateStatus', $project->id) }}" method="POST" class="d-inline">
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
                </div>
            </div>
        </section>
    </div>
@endsection
