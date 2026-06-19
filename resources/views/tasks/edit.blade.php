<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
</head>
<body>

<h2>Edit Task</h2>

<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')

    <p>Title</p>
    <input
        type="text"
        name="title"
        value="{{ $task->title }}"
    >

    <p>Description</p>
    <textarea name="description">{{ $task->description }}</textarea>

    <p>Status</p>

    <select name="status">
        <option value="Pending"
            {{ $task->status == 'Pending' ? 'selected' : '' }}>
            Pending
        </option>

        <option value="Completed"
            {{ $task->status == 'Completed' ? 'selected' : '' }}>
            Completed
        </option>
    </select>

    <br><br>

    <button type="submit">
        Update Task
    </button>
</form>

</body>
</html>