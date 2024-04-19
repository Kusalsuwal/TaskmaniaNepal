@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach(['todo' => 'To Do', 'doing' => 'Doing', 'done' => 'Done'] as $status => $title)
        <div id="div-{{ $status }}" class="dropzone" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h3 class="title">{{ $title }}</h3>
            @if($status == 'todo')
            <form action="{{ route('tasks.store') }}" method="POST" class="task-form">
                @csrf
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="text" name="name" placeholder="Enter task name">
                <button type="submit">Add Task</button>
            </form>
            @endif
            <div id="tasks-{{ $status }}">
                @foreach ($tasks[$status] ?? [] as $task)
                <div onclick="showModal(this)" draggable="true" ondragstart="drag(event)" class="task" id="task-{{ $task->id }}" data-task-name="{{ $task->name }}">
                    {{ $task->name }}
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div id="taskModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Task Details</h2>
        <p id="taskName">No task selected</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.task-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const task = document.createElement('div');
                    task.className = 'task'; 
                    task.draggable = true;
                    task.ondragstart = drag;
                    task.id = `task-${data.task.id}`;
                    task.textContent = data.task.name;
                    document.querySelector(`#div-${data.task.status}`).appendChild(task);
                    form.reset(); // Reset the form to clear the input after successful task addition
                } else {
                    alert('Error adding task');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});


function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var target = ev.target;
    while (!target.classList.contains('dropzone') && target.parentNode) {
        target = target.parentNode;
    }
    if (target.classList.contains('dropzone')) {
        var droppedTask = document.getElementById(data);
        target.appendChild(droppedTask);
        updateTaskStatus(droppedTask.id.replace('task-', ''), target.id.replace('div-', ''));
    }
}

function showModal(element) {
    var modal = document.getElementById('taskModal');
    var taskName = element.getAttribute('data-task-name');
    document.getElementById('taskName').textContent = taskName;
    modal.style.display = 'block';
}

function closeModal() {
    var modal = document.getElementById('taskModal');
    modal.style.display = 'none';
}

function updateTaskStatus(taskId, newStatus) {
    fetch(`/tasks/${taskId}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({status: newStatus})
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Failed to update task status');
        }
    })
    .catch(error => console.error('Error updating task status:', error));
}
</script>

<style>

    .task:hover{
        background-color: gold;
    }

.container { display: flex; justify-content: space-around; padding: 20px; }
.dropzone { flex: 1; min-width: 300px; min-height: 300px; background-color: #f4f4f8; border: 2px dashed #ccc; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 10px; border-radius: 5px; display: flex; flex-direction: column; align-items: center; justify-content: start; overflow: auto; margin: 0 10px; }
.title { color: #333; font-size: 1.2em; margin-bottom: 15px; }
.task { background-color: #000;
transition: background-color 0.5s;padding: 10px 15px; background-color: #fff; border: 1px solid #ddd; border-radius: 3px; margin-bottom: 10px; width: 100%; box-sizing: border-box; text-align: center; cursor: pointer; }
.modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4); }
.modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 50%; height: 300px;}
.close { color: #aaaaaa; float: right; font-size: 28px; font-weight: bold; margin-left: 600px;}
.close:hover, .close:focus { color: #000; text-decoration: none; cursor: pointer; }
</style>
@endsection
