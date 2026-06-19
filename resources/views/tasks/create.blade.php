<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
</head>
<body>

    <h2>Create Task</h2>

    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{ route('tasks.store') }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf

    <input type="text" name="title">

    <textarea name="description"></textarea>

    <input type="file" name="attachment">

    <button type="submit">
        Save Task
    </button>
</form>

<br>

<a href="{{ route('tasks.index') }}">View Tasks</a>

</body>
</html>