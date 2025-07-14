<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
    <h1>New Task Assigned</h1>
    <p>Dear {{ $task->user->name }},</p>
    <p>You have been assigned a new task:</p>
    <ul>
        <li><strong>Title:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Deadline:</strong> {{ $task->deadline }}</li>
        <li><strong>Status:</strong> {{ $task->status }}</li>
    </ul>
    <p>Please log in to the Task Management System to view and update the task.</p>
</body>
</html>
