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
    
    // Update the task's data with the new status_id
    droppedTask.dataset.taskStatusId = targetStatusId;

    // Remove the task from its current parent before appending it to the new one
    droppedTask.parentNode.removeChild(droppedTask);

    // Find the task list corresponding to the target status
    var $taskList = $('[data-status-id="' + targetStatusId + '"]');
    $taskList.append(droppedTask);

    // Update the task's status using AJAX
    var taskId = droppedTask.dataset.taskId;
    updateTaskStatus(taskId, targetStatusId);
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
@endsection
