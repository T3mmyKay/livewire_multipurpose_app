<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Appointments</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.appointments') }}">Appointments</a> </li>
                        <li class="breadcrumb-item active">Create</li>
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

                    <div class="card">
                        <div class="card-header">
                            <h1>Add New Appointment</h1>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent='addAppointment' autocomplete="off">
                                <div class="form-group">
                                    <label for="name">Client</label>
                                    <select id="" class="form-control" wire:model.defer='state.client_id'>
                                        <option value="">...Select A Client</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appointmentStartTime">Start Time:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fas fa-clock"></i></span></div>
                                                <x:timepicker wire:model.defer="state.appointment_start_time"
                                                    id="appointment_start_time" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appointmentEndTime">End Time:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fas fa-clock"></i></span></div>
                                                <x:timepicker wire:model.defer="state.appointment_end_time"
                                                    id="appointment_end_time" />

                                            </div>
                                        </div>
                                    </div>
                                </div> --}}





                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appointment_date">Appointment Date</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fas fa-calendar-day"></i></span></div>
                                                <x:datepicker wire:model.defer="state.date" id="appointment_date" />

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="appointment_time">Appointment Time:</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fas fa-user-clock"></i>
                                                    </div>
                                                </div>
                                                <x-timepicker id="appointment_time" wire:model.defer="state.time" />

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div wire:ignore class="form-group">
                                    <label for="note">Note</label>
                                    <textarea class="form-control" data-note="@this" id="note"></textarea>

                                </div>





                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times mr-1"></i>
                                    Cancel</button>
                                <button id="submit" type="submit" class="btn btn-primary"><i
                                        class="fa fa-save mr-1"></i>Save</button>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    @push('js')

    <script>
        $(function(){
            // $("#appointment_date").datetimepicker({
            //     format:'L',
            // });
            // $('#appointment_time').datetimepicker({
            //     format:'LT'
            // })

            // $('#appointment_date').on("change.datetimepicker",function(e){
            //   let date = $(this).data('appointmentdate');
            //   eval(date).set('state.date',$('#appDI').val());
            // });

            // $('#appointment_time').on("change.datetimepicker",function(e){
            //     time = $(this).data('apptime');
            //     eval(time).set('state.time',$('#appT').val());
            // });

    ClassicEditor
    .create( document.querySelector( '#note' ) )
        .then((editor) => {
            // editor.model.document.on('change:data',()=>{
            //     let note = $('#note').data('note');
            //     eval(note).set('state.note',editor.getData());
            // })
            document.querySelector('#submit').addEventListener('click',()=>{
                let note = $('#note').data('note');
                eval(note).set('state.note',editor.getData());
            })

        }).catch((err) => {
            console.error(err);
        });
        });
    </script>
    @endpush

</div>
