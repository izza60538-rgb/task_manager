<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
</head>
<body>

    <h2>Task List</h2>

    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('tasks.create') }}">Add New Task</a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->status }}</td>

            <td>
                <a href="{{ route('tasks.show', $task->id) }}">
                    View
                </a>

                |

                <a href="{{ route('tasks.edit', $task->id) }}">
                    Edit
                </a>

                |

                <form
                action="{{ route('tasks.destroy', $task->id) }}"
                method="POST"
                style="display:inline;"
                >
                @csrf
                @method('DELETE')

                <button type="submit">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
    

</table>

<br>

{{ $tasks->links() }}

</body>
</html>