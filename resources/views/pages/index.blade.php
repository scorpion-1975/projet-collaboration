@extends('layouts.app')

@section('content')
    <div class="pagetitle d-flex flrx-wrap justify-content-between">
        <div>
            <h1>Tableau de bord</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Tableau de bord</li>
                </ol>
            </nav>
        </div>
        <div>
            @if (auth()->check() && auth()->user()->roles->isNotEmpty() && auth()->user()->roles->first()->name == 'admin')
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Ajouter un projet
                </a>
            @else
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Rejoindre un projet
                </a>
            @endif
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Projets en cours -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Projets en cours</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-bar-chart-line"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $ongoingProjects }}</h6>
                                        <span class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">increase</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Tâches en retard -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Tâches en retard</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-bell-fill text-danger"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $overdueTasks }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Progression moyenne -->
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Progression moyenne</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ number_format($averageProgress, 2) }}%</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Customers Card -->

                    <!-- Projets actifs -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Projets Actifs</h5>
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Projet</th>
                                            <th scope="col">Progression</th>
                                            <th scope="col">Échéance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activeProjects as $project)
                                            <tr>
                                                <td>#{{ $project->id }}</td>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->progress }}%</td>
                                                <td>{{ $project->due_date->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Projets Actifs -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Tâches imminentes -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">📅 Tâches imminentes</h5>
                        <div class="activity">
                            @foreach ($upcomingTasks as $task)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{ $task->due_date->diffForHumans() }}</div>
                                    <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                    <div class="activity-content">
                                        {{ $task->name }} - <a href="#" class="fw-bold text-dark">{{ $task->description }}</a>
                                    </div>
                                </div><!-- End activity item-->
                            @endforeach
                        </div>
                    </div>
                </div><!-- End Recent Activity -->
            </div><!-- End Right side columns -->
        </div>
    </section>
@endsection
