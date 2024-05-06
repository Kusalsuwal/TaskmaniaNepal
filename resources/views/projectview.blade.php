@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $board->title }}</h1>

        <div id="statuses-container" class="row">
            <!-- Check if $statuses is not null before iterating -->
            @if (!is_null($statuses))
                @foreach($statuses as $key=>$status)
                    <div class="col-md-4">
                        <!-- Update the card's div to handle drop events -->
                        <div class="card" ondrop="drop(event)" ondragover="allowDrop(event)">
                            <div class="card-header">{{ $status->name }}</div>
                            <div class="card-body show"> <!-- Add 'show' class here -->
                                <!-- Tasks within the status -->
                                <ul class="list-group task-list" data-status-id="{{ $status->id }}">
                                    <!-- Check if $status->tasks is not null before iterating -->
                                    @if (!is_null($status->tasks))
                                        <!-- Iterate over tasks for this status -->
                                        @foreach ($status->tasks as $task)
                                            <li class="list-group-item">{{ $task->name }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                                <!-- Form to add new task -->
                                <form id="task-form-{{$key}}" class="task-form">
                                    @csrf
                                    <!-- Iterate over the cards and add them to the respective status -->
                                    @foreach ($board->cards as $card)
                                        @if ($card->status_id == $status->id)  
                                        <div onclick="showModal('{{ $card->name }}', '{{ $card->description }}', '{{ $card->id }}')" draggable="true" ondragstart="drag(event)" class="task card mb-3" id="task-{{ $card->id }}" data-task-id="{{ $card->id }}" data-task-name="{{ $card->name }}" data-task-status-id="{{ $status->id }}">
    <div class="card-body">{{ $card->name }}</div>
</div>

                                        @endif 
                                    @endforeach
                                    <input type="text" name="name" class="form-control" placeholder="Enter task name">
                                    <input hidden name="status" value="{{ $status->id }}">
                                    <input hidden name="board_id" value="{{ $board->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Add Task</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- Form to add new status -->
        <form id="status-form" style="margin-top: 10px;">
            @csrf
            <input type="text" name="name" placeholder="Enter status name" class="form-control mb-3">
            <input type="hidden" name="board_id" value="{{ $board->id }}">
            <button type="submit" class="btn btn-primary">Add Status</button>
        </form>
    </div>



    <!-- Modal -->
    <div id="taskModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 class="mb-3">Task Details</h2>
        <div id="taskHistory"></div>
        <p id="taskName"></p>
        <div class="mb-3">
        <div id="taskHistory">
    <!-- Task History will be displayed here -->
</div>
            <label for="taskDescription" class="form-label">Description</label>
            <textarea id="taskDescription" class="form-control" placeholder="Enter task description"></textarea>
        </div>
        <button onclick="saveTaskDescription()" class="btn btn-primary">Save Description</button>
        <input type="hidden" id="taskId"> <!-- Hidden input to store task ID -->
        <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF token -->
    </div>
</div>
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // JavaScript function to handle drag event
        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        // JavaScript function to handle dragover event
        function allowDrop(ev) {
            ev.preventDefault();
        }

        // JavaScript function to handle drop event
// JavaScript function to handle drop event
// JavaScript function to handle drop event
// JavaScript function to handle drop event
// JavaScript function to handle drop event
function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var droppedTask = document.getElementById(data);
    var targetStatusId = ev.target.closest('.card').querySelector('.task-list').dataset.statusId;
    
   
    droppedTask.dataset.taskStatusId = targetStatusId;

   
    droppedTask.parentNode.removeChild(droppedTask);

    // Find the task list corresponding to the target status
    var $taskList = $('[data-status-id="' + targetStatusId + '"]');
    $taskList.append(droppedTask);

    // Update the task's status using AJAX
    var taskId = droppedTask.dataset.taskId;
    updateTaskStatus(taskId, targetStatusId);
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
            
            // Fetch task history data
            fetch(`/tasks/${taskId}/history`)
            .then(response => response.json())
            .then(history => {
                // Display task history
                if (history.length > 0) {
                    var historyHtml = '<h3>Task History</h3><ul>';
                    history.forEach(event => {
                        historyHtml += `<li>${event.timestamp} - ${event.oldStatus} -> ${event.newStatus}</li>`;
                    });
                    historyHtml += '</ul>';
                    // Append history to some element in your UI, for example:
                    document.getElementById('taskHistory').innerHTML = historyHtml;
                } else {
                    // If no history found, display a message
                    document.getElementById('taskHistory').innerHTML = '<p>No history available.</p>';
                }
            })
            .catch(error => console.error('Error fetching task history:', error));
            
        } else {
            alert('Failed to save task description');
        }
    })
    .catch(error => console.error('Error:', error));
}


// Function to update task status using AJAX
function updateTaskStatus(taskId, statusId) {
    $.ajax({
        url: '/update-task-status',
        type: 'POST',
        data: {
            task_id: taskId,
            status_id: statusId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('Task status updated successfully');
        },
        error: function(xhr, status, error) {
            console.error('Error updating task status:', error);
        }
    });
}



        $(document).ready(function() {
            // AJAX for adding a new status
            $('#status-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: '{{ route("statuses.store") }}',
                    type: 'POST',
                    data: formData,  
                    success: function(response) {
                        // Append the newly created status card to the container
                        $('#statuses-container').append(`
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">${response.name}</div>
                                    <div class="card-body show"> <!-- Add 'show' class here -->
                                        <ul class="list-group task-list" data-status-id="${response.id}">
                                        </ul>
                                        <form class="task-form" data-status-id="${response.id}">
                                            @csrf
                                            <input type="text" class="form-control task-input" name="name" placeholder="Enter task name">
                                            <button type="submit" class="btn btn-primary btn-sm mt-2">Add Task</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `);

                        // Clear the form fields
                        $('#status-form')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle error
                    }
                });
            });
            // Use event delegation to handle dynamic forms
            $(document).on('submit', '.task-form', function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize();
                var url = '{{ route("task.store") }}'; // Define URL here
                var $form = $(this); // Cache the form element
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Task added successfully');
                        // Update the UI to reflect the new task
                        var taskName = $form.find('input[name="name"]').val();
                        var statusId = $form.data('status-id');
                        var $taskList = $('[data-status-id="' + statusId + '"]'); // Find the task list corresponding to the status
                        $taskList.append('<li class="list-group-item">' + taskName + '</li>');

                        // Clear the task input field
                        $form.find('input[name="name"]').val('');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle error
                    }
                });
            });
        });
    </script>
    <style>    body {
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
    }</style>
@endsection
