<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="d-flex justify-content-end mb-2"><button wire:click.prevent='addNewUser'
                            class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i>Add New User</button>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><a href="javascript:void(0)" wire:click.prevent='edit({{ $user }})'><i
                                                    class="fa fa-edit mr-2"></i>
                                            </a>
                                            <a href=""><i class="fa fa-trash text-danger"
                                                    wire:click.prevent="confirmDelete({{ $user->id }})"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="class-footer d-flex justify-content-end mr-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent={{ $showEditModal ? 'updateUser' : 'createUser'}}>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@if($showEditModal)<span>Edit
                                User</span>@else<span>Add User</span>@endif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" placeholder="Enter your full name" wire:model.defer='state.name' class="form-control @error('name')
                                is-invalid
                                @enderror" id="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="text" class="form-control @error('email')is-invalid @enderror"
                                wire:model.defer='state.email' id="email" aria-describedby="emailHelp"
                                placeholder="Email Address">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @if(!$showEditModal)
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" placeholder="Password" wire:model.defer='state.password' class="form-control @error('password')
                                    is-invalid
                                @enderror" id="password" aria-described>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif
                        @if (!$showEditModal)
                        <div class="form-group">
                            <label for="con-password">Confirm Password</label>
                            <input type="password" placeholder="Confirm Password"
                                wire:model.defer='state.confirm_password' class="form-control @error('confirm_password')
                                    is-invalid
                                @enderror" id="con-password">
                            @error('confirm_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fa fa-times mr-1"></i>
                            Cancel</button>
                        <button type="submit" class="btn btn-primary"><i
                                class="fa fa-save mr-1"></i>@if($showEditModal)<span>Save Changes</span>@else
                            <span>Save</span>@endif</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="msg"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" wire:click.prevent="deleteUser" class="btn btn-danger"><i
                            class="fa fa-trash mr-1"></i>Delete</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        $(function() {
            toastr.options = {
                "positionClass": "toast-bottom-right",
                "progressBar": true,
            }
            window.addEventListener('hide_form',e=>{
                $('#form').modal('toggle');
                toastr.success(event.detail.message, 'Success');
            })
        })
        window.addEventListener('show-form',e=>{
            $('#form').modal('toggle');
        })
        window.addEventListener('confirmDelete',e=>{
            $('#confirmationModal').modal('toggle');
            $('#msg').html(e.detail.message);
        })
        window.addEventListener('hide-delete-modal',e=>{
            $('#confirmationModal').modal('toggle');
            toastr.success(event.detail.message, 'Deleted');
        })

    </script>
    @endpush

</div>
