<!DOCTYPE html>
<html>
<head>
    <title>Notification de tâche</title>
</head>
<body>
    <h2>{{ $message }}</h2>
    <p><strong>Titre de la tâche :</strong> {{ $task->title }}</p>
    <p><strong>Description :</strong> {{ $task->description }}</p>
    <p><strong>Échéance :</strong> {{ $task->due_date }}</p>

    <p>Consultez votre tableau de bord pour plus de détails.</p>

    <p>Merci,</p>
    <p>L'équipe de gestion des tâches</p>
</body>
</html>
