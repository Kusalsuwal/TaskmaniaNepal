@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $board->title }}</h1>

        <div id="statuses-container" class="row">
            <!-- Check if $statuses is not null before iterating -->
            @if (!is_null($statuses))
                @foreach($statuses as $key=>$status)
                    <div class="col-md-4">
                        <div class="card">
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
                                    <input type="text" name="name"   class="form-control" placeholder="Enter task name">
                                    <input hidden name="status" value="{{ $status->id }}">
                                    <input hidden  name="board_id" value="{{ $board->id }}">
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

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Task added successfully');
                        // You might want to update the UI here to reflect the new task
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle error
                    }
                });
            });

            // $('#task-form').submit(function(event) {
            //     event.preventDefault(); // Prevent default form submission
            //     var formData = $(this).serialize();
            //     $.ajax({
            //         url: '{{route("task.store") }}',
            //         type: 'POST',
            //         data: formData,
            //         success: function(response) {

            //             alert('success')
                 
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(error);
            //             // Handle error
            //         }
            //     });
            // });
 // Add event listeners to all task forms
    // document.querySelectorAll('task-form_old').forEach(form => {
    //     alert('asda')

    //     form.addEventListener('submit', function (e) {
    //         e.preventDefault();
    //         const formData = new FormData(form);
            
    //         fetch(form.action, {
    //             method: 'POST',
    //             body: formData,
    //             headers: {
    //                 'X-Requested-With': 'XMLHttpRequest',
    //             }
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 form.reset(); // Reset the form to clear the input after successful task addition
    //                 // Append the newly added task to the corresponding div
    //                 const task = document.createElement('div');
    //                 task.onclick = () => showModal(data.task.name, data.task.description, data.task.id);
    //                 task.draggable = true;
    //                 task.ondragstart = drag;
    //                 task.className = 'task card mb-3';
    //                 task.id = `task-${data.task.id}`;
    //                 task.dataset.taskId = data.task.id;
    //                 task.dataset.taskName = data.task.name;
    //                 task.innerHTML = `<div class="card-body">${data.task.name}</div>`;
    //                 document.getElementById(`tasks-${data.task.status}`).appendChild(task);
    //             } else {
    //                 alert('Error adding task');
    //             }
    //         })
    //         .catch(error => console.error('Error:', error));
    //     });
    // });


        });
    </script>
@endsection
