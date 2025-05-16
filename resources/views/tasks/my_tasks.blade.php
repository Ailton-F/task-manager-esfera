@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/my_tasks.css') }}">
@endsection

<x-base>
    <x-slot name="content">
        <x-sidebar>
            <x-slot name="content">
                @include('components.toast');
                <div class="ps-5 ms-5">
                    <div class="d-flex my-4 justify-content-between align-items-center">
                        <h2 class="fw-bold">My Tasks</h1>
                            <button class="btn btn-primary h-auto" data-bs-toggle="modal" data-bs-target="#addTaskModal">Add Task</button>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('tasks.index') }}" method="GET" id="searchForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text" id="search-addon"><i class="bi bi-search"></i></span>
                                            <input type="text" class="form-control" placeholder="Search by title or description" name="search" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" name="user" id="userFilter">
                                            <option value="">All Users</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" name="status" id="statusFilter">
                                            <option value="">All Status</option>
                                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr>
                    <div class="gap-3 row row-cols-2 row-cols-md-3 row-cols-lg-4">
                        @if($tasks->isEmpty())
                        <div class="alert alert-info text-center w-100" role="alert">
                            No tasks available. Please add a task or adjust your search criteria.
                        </div>
                        @else

                        @foreach ($tasks as $task)
                        <div class="card col">
                            <div class="card-header bg-transparent border-0 pb-0 py-3">
                                <h5 class="card-title fw-bold mt-2">{{ $task->title }}</h5>
                            </div>

                            <div class="card-body">

                                <p class="desc">{{ $task->description }}</p>

                                <p class="card-text"><strong>Users:</strong>
                                    @foreach ($task->user as $user)
                                    <span class="badge bg-primary" data-user-id="{{ $user->id }}">{{ $user->name }}</span>
                                    @endforeach
                                </p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" disabled {{ $task->status ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Done
                                    </label>
                                </div>
                                <div class="d-flex gap-2 mt-3 justify-content-end">
                                    <button class="btn-info btn text-white edit-task-btn" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-task-id="{{ $task->id }}">Edit</button>
                                    <button class="btn-danger btn delete-task-btn" data-bs-toggle="modal" data-bs-target="#deleteTaskModal" data-task-id="{{ $task->id }}">Delete</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>


                <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('tasks.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="addTaskName" class="col-form-label">Task Name:</label>
                                        <input type="text" name="title" class="form-control" id="addTaskName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="taskDescription" class="col-form-label">Description:</label>
                                        <textarea class="form-control" name="description" id="taskDescription"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="taskUsers" class="col-form-label">Users:</label>
                                        <select class="form-select taskUsers" name="users[]" id="taskUser" multiple>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="taskStatus" class="col-form-label">Status:</label>
                                        <select class="form-select" name="status" id="taskStatus">
                                            <option value="0">Pending</option>
                                            <option value="1">Completed</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            @if($tasks->isEmpty())
                            @else
                            <input type="hidden" name="id" id="editId">
                            <div class="modal-body">
                                <form method="POST" id="editTaskForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="editTaskName" class="col-form-label">Task Name:</label>
                                        <input required type="text" name="title" class="form-control" id="editTaskName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTaskDescription" class="col-form-label">Description:</label>
                                        <textarea class="form-control" name="description" id="editTaskDescription"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTaskUsers" class="col-form-label">Users:</label>
                                        <select class="form-select taskUsers" name="users[]" id="editTaskUsers" multiple>
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTaskStatus" class="col-form-label">Status:</label>
                                        <select required class="form-select" name="status" id="editTaskStatus">
                                            <option value="0">Pending</option>
                                            <option value="1">Completed</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal fade " id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteTaskModalLabel">Delete Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            @if($tasks->isEmpty())
                            @else
                            <input type="hidden" name="id" id="deleteId">
                            <div class="modal-body">
                                <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <p>Are you sure you want to delete this task?</p>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <script>
                    $(".taskUsers").selectize();

                    document.addEventListener('DOMContentLoaded', function() {
                        const editButtons = document.querySelectorAll('.edit-task-btn');
                        editButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const taskId = this.getAttribute('data-task-id');
                                const form = document.querySelector('#editTaskModal form');
                                form.action = form.action.replace(/\/\d+$/, '/' + taskId);
                            });
                        });

                        const deleteButtons = document.querySelectorAll('.delete-task-btn');
                        deleteButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const taskId = this.getAttribute('data-task-id');
                                const form = document.querySelector('#deleteTaskModal form');
                                form.action = form.action.replace(/\/\d+$/, '/' + taskId);
                            });
                        });
                    });

                    $('#editTaskModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget);
                        var taskId = button.data('task-id');
                        var taskTitle = button.closest('.card').find('.card-title').text();
                        var taskDescription = button.closest('.card').find('.desc').text();
                        var taskStatus = button.closest('.card').find('input[type="checkbox"]').is(':checked') ? 1 : 0;

                        var taskUsers = [];
                        button.closest('.card').find('.badge').each(function() {
                            taskUsers.push($(this).data('user-id'));
                        });
                        
                        $('#editId').val(taskId);
                        $('#editTaskName').val(taskTitle);
                        $('#editTaskDescription').val(taskDescription);
                        $('#editTaskStatus').val(taskStatus);

                        let selectize = $('#editTaskUsers')[0].selectize;
                        selectize.clear();
                        selectize.addItems(taskUsers);
                        let formAction = "{{ route('tasks.update', '__ID__') }}";
                        $('#editTaskForm').attr('action', formAction.replace('__ID__', taskId));
                    });

                    $('#deleteTaskModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget);
                        $('#deleteId').val(button.data('id'));
                    });
                </script>
            </x-slot>
        </x-sidebar>
    </x-slot>
</x-base>