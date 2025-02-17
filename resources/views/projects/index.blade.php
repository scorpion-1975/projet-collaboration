@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="pagetitle d-flex flrx-wrap justify-content-between ">
            <div>
                <h1>Mes projets</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Accueil</a></li>
                        <li class="breadcrumb-item active">Tableau de bord</li>
                    </ol>
                </nav>
            </div>

            <div>
                @if (auth()->user()->roles->first()->name == 'admin')
                    <a href="{{ route('projects.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i>
                        Ajouter un projet
                    </a>
                @else
                    <a href="#" class="btn btn-primary">
                        <i class="bi bi-plus"></i>
                        Rejoindre un projet
                    </a>
                @endif
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
                <div class="col-lg-8 card">

                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->status }}</td>
                                    <td>
                                        <a href="{{ route('projects.show', $project->id) }}"
                                            class="btn btn-info btn-sm">Voir</a>
                                        <a href="{{ route('projects.invite', $project->id) }}" class="btn btn-warning btn-sm">Inviter</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
