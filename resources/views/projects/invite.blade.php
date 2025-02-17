@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="pagetitle d-flex flex-wrap justify-content-between ">
            <div>
                <h1>Inviter un utilisateur au projet : {{ $project->title }}</h1>

                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Lites projets</a></li>
                        <li class="breadcrumb-item active">Tableau de bord</li>
                    </ol>
                </nav>
            </div>


        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row justify-content-center  ">

                <!-- Left side columns -->
                <div class="col-lg-8 ">
                    <div class="card p-2">
                        @if (session('error'))
                            <div class="alert alert-danger text-center">{{ session('error') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('projects.invite.store', $project->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="user_id" class="form-label">Sélectionner un utilisateur</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                    id="user_id" required>
                                    <option value="">-- Choisir un utilisateur --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Rôle</label>
                                <select class="form-control" name="role" required>
                                    <option value="membre">Membre</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Inviter</button>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
