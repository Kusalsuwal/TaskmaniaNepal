@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div id="div1" class="dropzone" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h3 class="title">To Do</h3>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task1">Task 1</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task2">Task 2</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task3">Task 3</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task4">Task 4</div>
        </div>

        <div id="div2" class="dropzone" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h3 class="title">Doing</h3>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task5">Task 5</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task6">Task 6</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task7">Task 7</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task8">Task 8</div>
        </div>

        <div id="div3" class="dropzone" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h3 class="title">Done</h3>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task9">Task 9</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task10">Task 10</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task11">Task 11</div>
            <div class="task" draggable="true" ondragstart="drag(event)" id="task12">Task 12</div>
        </div>
    </div>
</div>

<script>
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
    console.log('gf,',target.id)

    // Traverse up to find the closest parent dropzone element
    while (!target.classList.contains('dropzone') && target.parentNode) {
        target = target.parentNode;
    }

    if (target.classList.contains('dropzone')) {
        target.appendChild(document.getElementById(data));
        // Log the id of the dropzone to the console
        console.log('Task dropped in:', target.id);
        
        // Example: Perform an action based on the dropzone
        switch (target.id) {
            case 'div1':
                console.log('Task is now in To Do',target.id);
                break;
            case 'div2':
                console.log('Task is now in Doing',target.id);
                break;
            case 'div3':
                console.log('Task is now in Done',target.id);
                break;
        }
    }
}

</script>

<style>
.container {
    display: flex;
    justify-content: space-around;
    padding: 20px;
}
.dropzone {
    flex: 1; /* Each dropzone will take up equal space */
    min-width: 300px; /* Ensures that the width does not go below 300px */
    min-height: 300px;
    background-color: #f4f4f8;
    border: 2px dashed #ccc;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    padding: 10px;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: start;
    overflow: auto;
    margin: 0 10px; /* Adds space between the columns */
}
.title {
    color: #333;
    font-size: 1.2em;
    margin-bottom: 15px;
}
.task {
    padding: 10px 15px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 3px;
    margin-bottom: 10px;
    width: 100%;
    box-sizing: border-box;
    text-align: center;
    cursor: pointer;
}
</style>
@endsection
