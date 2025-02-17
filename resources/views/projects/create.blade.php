@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="pagetitle d-flex flex-wrap justify-content-between ">
            <div>
                <h1>Créer un projet</h1>

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
                        <form action="{{ route('projects.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Titre</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Créer</button>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
