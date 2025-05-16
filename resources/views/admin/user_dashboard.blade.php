<x-base>
    <x-slot name="content">
        <x-sidebar>
            <x-slot name="content">
                @include('components.toast');
                <div class="ps-5 ms-5 mt-3">
                    <table id="table" class="display">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td class="d-flex flex-shrink gap-3">
                                    <a href="#" class="btn btn-primary px-2 py-1" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="{{$user->id}}"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal fade " id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editUserForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="editId">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="editUserForm" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this user?</p>
                            </div>
                            <div class="modal-footer">
                                <form id="deleteUserForm" method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" id="deleteId">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
        </x-sidebar>
    </x-slot>
</x-base>
<script>
    new DataTable('#table');

    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        
        $('#editId').val(id);
        $('#name').val(name);
        $('#email').val(email);
        let formAction = "{{ route('users.update', '__ID__') }}";
        $('#editUserForm').attr('action', formAction.replace('__ID__', button.data('id')));
    });

    $('#deleteUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        $('#deleteId').val(id);
        let formAction = "{{ route('users.destroy', '__ID__') }}";
        $('#deleteUserForm').attr('action', formAction.replace('__ID__', id));
    });
</script>
