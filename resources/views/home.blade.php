@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach(['todo' => 'To Do', 'doing' => 'Doing', 'done' => 'Done'] as $status => $title)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <div class="card-body dropzone" ondrop="drop(event, '{{ $status }}')" ondragover="allowDrop(event)">
                    @if($status == 'todo' || $status == 'doing' || $status == 'done')
                    <form id="form-{{ $status }}" action="{{ route('tasks.store') }}" method="POST" class="task-form">
                        @csrf <!-- Include CSRF token -->
                        <input type="hidden" name="status" value="{{ $status }}">
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Enter task name">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </form>
                    @endif
                    <div id="tasks-{{ $status }}" class="task-list">
                        @foreach ($tasks[$status] ?? [] as $task)
                        <div onclick="showModal('{{ $task->name }}', '{{ $task->description }}', '{{ $task->id }}')" draggable="true" ondragstart="drag(event)" class="task card mb-3" id="task-{{ $task->id }}" data-task-id="{{ $task->id }}" data-task-name="{{ $task->name }}">
                            <div class="card-body">{{ $task->name }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div id="taskModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 class="mb-3">Task Details</h2>
        <p id="taskName"></p>
        <div class="mb-3">
            <label for="taskDescription" class="form-label">Description</label>
            <textarea id="taskDescription" class="form-control" placeholder="Enter task description"></textarea>
        </div>
        <button onclick="saveTaskDescription()" class="btn btn-primary">Save Description</button>
        <input type="hidden" id="taskId"> <!-- Hidden input to store task ID -->
        <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF token -->
    </div>
</div>

<script>
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }
    function drop(ev, newStatus) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var droppedTask = document.getElementById(data);
    var tasksContainer = document.getElementById(`tasks-${newStatus}`);
    var taskElements = tasksContainer.getElementsByClassName("task");

    // Find the index where the dropped task should be inserted
    var insertIndex = 0;
    for (var i = 0; i < taskElements.length; i++) {
        var taskRect = taskElements[i].getBoundingClientRect();
        if (ev.clientY < taskRect.top + taskRect.height / 2) {
            insertIndex = i;
            break;
        }
        insertIndex = i + 1;
    }

    // Remove the task from its original position
    droppedTask.parentNode.removeChild(droppedTask);

    // Insert the task into the new position
    if (insertIndex >= taskElements.length) {
        tasksContainer.appendChild(droppedTask); // Append to the end
    } else {
        tasksContainer.insertBefore(droppedTask, taskElements[insertIndex]); // Insert before the next task
    }

    var taskId = droppedTask.dataset.taskId;
    updateTaskStatus(taskId, newStatus);
}


    function showModal(taskName, taskDescription, taskId) {
        var modal = document.getElementById('taskModal');
        document.getElementById('taskName').textContent = taskName;
        document.getElementById('taskDescription').value = taskDescription; // Populate description
        document.getElementById('taskId').value = taskId; // Populate task ID
        modal.style.display = 'block';
    }

    function closeModal() {
        var modal = document.getElementById('taskModal');
        modal.style.display = 'none';
    }

    function saveTaskDescription() {
        var taskId = document.getElementById('taskId').value;
        var description = document.getElementById('taskDescription').value;
        
        // Prepare the data to send in the request body
        var formData = new FormData();
        formData.append('description', description);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); // Include CSRF token
        
        fetch(`/tasks/${taskId}/update-description`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Task description saved successfully');
                closeModal(); // Close modal after saving the description
            } else {
                alert('Failed to save task description');
            }
        })
        .catch(error => console.error('Error:', error));
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

    // Add event listeners to all task forms
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
                    form.reset(); // Reset the form to clear the input after successful task addition
                    // Append the newly added task to the corresponding div
                    const task = document.createElement('div');
                    task.onclick = () => showModal(data.task.name, data.task.description, data.task.id);
                    task.draggable = true;
                    task.ondragstart = drag;
                    task.className = 'task card mb-3';
                    task.id = `task-${data.task.id}`;
                    task.dataset.taskId = data.task.id;
                    task.dataset.taskName = data.task.name;
                    task.innerHTML = `<div class="card-body">${data.task.name}</div>`;
                    document.getElementById(`tasks-${data.task.status}`).appendChild(task);
                } else {
                    alert('Error adding task');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

<style>
    body {
        background-image: url('https://source.unsplash.com/1600x900/?office');
        background-size: cover;
        background-repeat: no-repeat;
        font-family: Arial, sans-serif;
    }
    .navbar {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px 20px;
    }
    .navbar-brand {
        color: #fff;
    }
    .card {
        background-color: #fff;
        border: 1px solid #d0d0d0;
        border: none;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .dropzone {
        min-height: auto;
        padding: 15px;
    }
    .task.card:hover {
        background-color: #f4f4f8;
        box-shadow: 0 0 0 2px #d0d0d0;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%; 
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }
    
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover, .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
    #taskDescription {
        width: 100%;
        height: 100px;
        margin-bottom: 10px;
    }
    .card-body {
        max-height: 300px; /* Adjust the maximum height as needed */
        overflow-y: auto; /* Add vertical scroll when content exceeds max height */
    }
</style>
@endsection
