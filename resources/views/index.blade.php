@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach(['todo' => 'To Do', 'doing' => 'Doing', 'done' => 'Done'] as $status => $title)
        <div class="col-md-4">
            <h3>{{ $title }}</h3>
            <ul id="{{ $status }}" class="list-group dropzone">
                @foreach($tasks->where('status', $status) as $task)
                <li class="list-group-item draggable" draggable="true" data-id="{{ $task->id }}">
                    {{ $task->name }}
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
    <button class="btn btn-primary" onclick="addTask()">Add Task</button>
</div>

<script>
function addTask() {
    const taskName = prompt('Enter the task name:', 'New Task');
    if (taskName) {
        fetch('{{ route('task.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({name: taskName, status: 'todo'})
        }).then(response => {
            return response.json();
        }).then(data => {
            window.location.reload(); // Reload the page to see the new task
        });
    }
}

document.querySelectorAll('.draggable').forEach(item => {
    item.addEventListener('dragstart', handleDragStart, false);
    item.addEventListener('dragend', handleDragEnd, false);
});

document.querySelectorAll('.dropzone').forEach(list => {
    list.addEventListener('dragover', handleDragOver, false);
    list.addEventListener('drop', handleDrop, false);
});

function handleDragStart(e) {
    e.dataTransfer.setData('text/plain', e.target.dataset.id);
    e.target.classList.add('dragging');
}

function handleDragOver(e) {
    e.preventDefault();
}

function handleDrop(e) {
    e.preventDefault();
    const taskId = e.dataTransfer.getData('text/plain');
    const status = e.target.id;

    fetch(`/task/${taskId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({status: status})
    }).then(response => {
        window.location.reload(); // Reload the page to reflect the change of status
    });
}

function handleDragEnd(e) {
    e.target.classList.remove('dragging');
}
</script>

@endsection
