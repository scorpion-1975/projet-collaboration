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
                                    <th>Nbre de tâche</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
