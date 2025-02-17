@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="pagetitle">
            <h1>Tâche : {{ $task->title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Tous les projets</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a>
                    </li>
                    <li class="breadcrumb-item active">Fichiers attachés</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row justify-content-center">

                <div class="col-12">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                </div>

                <div class="col-12">
                    <ul>
                        @php
                            $fileIndex = 0;
                        @endphp
                        @forelse ($task->getMedia() as $file)
                            <li class="mb-3">
                                <a href="{{ $file->getFullUrl() }}" target="_blank">{{ $file->file_name }}</a>


                                @if ($file->getFullUrl())
                                    <a href="{{ route('tasks.download', ['project' => $project->id, 'task' => $task->id, 'file' => $fileIndex]) }}"
                                        class="btn btn-success mx-2">
                                        📥 Télécharger le fichier
                                    </a>
                                    @php
                                        $fileIndex++;
                                    @endphp
                                @endif


                                <form action="{{ route('tasks.files.destroy', [$task->id, $file->id]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Voulez-vous supprimer ce fichier ?')">
                                        <div class="bi bi-trash"></div>
                                    </button>
                                </form>
                            </li>
                        @empty

                            <div class="alert alert-info">
                                Pas de fichiers associé
                            </div>
                        @endforelse

                    </ul>

                </div>
            </div>
        </section>
    </div>
@endsection
