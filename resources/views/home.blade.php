@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                <h3 class="card-title">Create your project</h3>
                </div>
                <div class="card-body">
                    <form id="form-new-board" action="{{ route('Bstores') }}" method="POST">
                        @csrf 
                        <div class="mb-3">
                            <input type="text" name="title" class="form-control" placeholder="Enter board name">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Board</button>
                    </form>
                </div>
            </div>
        </div>
        @foreach ($boards as $board)
        <div class="col-md-4">
        <a href="{{ route('board.show', ['id' => $board->id]) }}" style="text-decoration: none;">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">{{ $board->title }}</h3>
                    </div>
                    <div class="card-body dropzone" ondrop="drop(event, '{{ $board->id }}')" ondragover="allowDrop(event)">
                        <form id="form-board-{{ $board->id }}" action="{{ route('tasks.store') }}" method="POST" class="task-form" style="display: none;">
                            @csrf 
                            <input type="hidden" name="board_id" value="{{ $board->id }}">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Enter task name">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Task</button>
                        </form>
                        <div id="tasks-board-{{ $board->id }}" class="task-list">
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>



<script>
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
                    form.reset(); 

                    const task = document.createElement('div');
                    task.onclick = () => showModal(data.task.name, data.task.description, data.task.id);
                    task.draggable = true;
                    task.ondragstart = drag;
                    task.className = 'task card mb-3';
                    task.id = `task-${data.task.id}`;
                    task.dataset.taskId = data.task.id;
                    task.dataset.taskName = data.task.name;
                    task.innerHTML = `<div class="card-body">${data.task.name}</div>`;
                    document.getElementById(`tasks-board-${data.task.board_id}`).appendChild(task);


                    Swal.fire({
                        title: "Auto close alert!",
                        html: "Project added successfully!",
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log("Alert closed by the timer");
                        }
                    });
                } else {
                    alert('Error adding task');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
</body>
</html>

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
        max-height: 300px; 
        overflow-y: auto; 
    }
</style>
@endsection
