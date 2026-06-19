<!DOCTYPE html>
<html>
<body>

<h2>Deleted Tasks</h2>

@foreach($tasks as $task)

<p>
    {{ $task->title }}

    <form action="{{ route('tasks.restore',$task->id) }}"
          method="POST">
        @csrf
        <button>
            Restore
        </button>
    </form>

    <form action="{{ route('tasks.forceDelete',$task->id) }}"
          method="POST">
        @csrf
        @method('DELETE')

        <button>
            Delete Permanently
        </button>
    </form>
</p>

@endforeach

</body>
</html>