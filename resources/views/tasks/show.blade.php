<!DOCTYPE html>
<html>
<head>
    <title>Task Details</title>
</head>
<body>
    @if($task->attachment)
    <p>
        <a href="{{ asset('storage/'.$task->attachment) }}"
         target="_blank">
         View Attachment
     </a>
 </p>
 @endif

 <h2>Task Details</h2>

 <p>
    <strong>ID:</strong>
    {{ $task->id }}
</p>

<p>
    <strong>Title:</strong>
    {{ $task->title }}
</p>

<p>
    <strong>Description:</strong>
    {{ $task->description }}
</p>

<p>
    <strong>Status:</strong>
    {{ $task->status }}
</p>

<a href="{{ route('tasks.index') }}">
    Back
</a>

</body>
</html>