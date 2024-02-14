<x-app-layout>
    <x-slot:menuselected>permissions</x-slot:menuselected>
    <x-slot name="styles">
        <!-- Datatable -->
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/datatable/responsive.bootstrap5.min.css') }}">
        <!-- Jquery Validations -->
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/forms/form-validation.css') }}">
        <!-- Toastr -->
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/toastr/toastr.min.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/toastr/ext-component-toastr.css') }}">
        <!-- Select 2 -->
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/select/select2.min.css') }}">
        <!-- Sweet alerts -->
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/sweet-alert/ext-component-sweet-alerts.css') }}">
    </x-slot>

    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- permission list start -->
            <section class="app-permission-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        <div class="head-label"><h4 class="mb-0">{{ __('permissions.datatable.title') }}</h4></div>
                        <div class="text-end">
                            <div class="dt-buttons d-inline-flex">
                                <button class="dt-button create-new btn btn-primary" tabindex="0" type="button"
                                        data-bs-toggle="modal" id="addPermissionBtn"
                                        data-bs-target="#permission-modal"><span>{{ __('permissions.datatable.add_btn') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <div class="p-2">
                            <table class="permissions-list-table table">
                                <thead class="table-light">
                                <tr>
                                    <th>{{ __('permissions.datatable.columns.number') }}</th>
                                    <th>{{ __('permissions.datatable.columns.name') }}</th>
                                    <th>{{ __('permissions.datatable.columns.guard_name') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Modal to add new permission-->
                    <div class="modal modal-slide-in fade" id="permission-modal">
                        <div class="modal-dialog">
                            <form class="modal-content pt-0" id="permission-form">
                                <button type="reset" class="btn-close cancel" data-bs-dismiss="modal"
                                        aria-label="Close">×
                                </button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title">{{ __('permissions.datatable.modal.title_add') }}</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-2">
                                        <label class="form-label"
                                               for="name">{{ __('permissions.datatable.modal.name') }}</label>
                                        <input type="text" class="form-control dt-full-name"
                                               id="name"
                                               name="name" autocomplete="off"/>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label"
                                               for="guard_name">{{ __('permissions.datatable.modal.guard_name.title') }}</label>
                                        <select class="select2 form-select" id="guard_name" name="guard_name"
                                                autocomplete="off">
                                            <optgroup label="{{__('permissions.datatable.modal.guard_name.option')}}">
                                                <option selected></option>
                                                @foreach($guards as $guard)
                                                    <option value="{{ $guard }}">{{ $guard }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-primary me-1 data-submit"
                                            id="submitBtn">{{ __('permissions.datatable.modal.button_add') }}</button>
                                    <button type="reset" class="btn btn-outline-secondary cancel"
                                            data-bs-dismiss="modal"
                                            id="cancelBtn">
                                        {{ __('permissions.datatable.modal.cancel_btn') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal to add new permission-->
                </div>
                <!-- list and filter end -->
            </section>
            <!-- permissions list ends -->
        </div>
    </div>
    <!-- END: Content-->

    <!--Scripts-->
    <x-slot name="scripts">
        <!-- Datatable -->
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/dataTables.responsive.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/vfs_fonts.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/datatables.buttons.min.js') }}"></script>
        <!--Validation -->
        <script src="{{ Vite::asset('resources/theme/plugins/forms/validation/jquery.validate.min.js') }}"></script>
        <!-- Toastr -->
        <script src="{{ Vite::asset('resources/theme/plugins/toastr/toastr.min.js') }}"></script>
        <!-- Select  -->
        <script src="{{ Vite::asset('resources/theme/plugins/select/select2.full.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/select/form-select2.js') }}"></script>
        <!-- Sweet alerts -->
        <script src="{{ Vite::asset('resources/theme/plugins/sweet-alert/ext-component-sweet-alerts.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/sweet-alert/sweetalert2.all.min.js') }}"></script>

        <script>
            let table;
            let validator;
            $(function () {

                /** Guard Select2 */
                $('.select2').select2()

                /** Permissions Datatable */
                table = $('.permissions-list-table').DataTable({
                    "drawCallback": function (settings){
                      feather.replace()
                    },
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('management.permission.datatable') }}",
                        type: 'POST'
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'guard_name',
                            name: 'guard_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            width: '1%',
                            orderable: false,
                        },
                    ],
                })

                /** Add Permission form/validator */
                validator = $('#permission-form').validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        guard_name: {
                            required: true,
                        },
                    },
                    submitHandler(form, e) {
                        e.preventDefault();
                        let data = new FormData(form);
                        let url = '{{ route('management.permission.store') }}'
                        let type = 'POST'
                        if ($('#permission-modal').data('id')) {
                            url = '{{ route('management.permission.update',':id') }}'
                            url = url.replace(':id', $('#permission-modal').data('id'))
                            data.append('_method', 'PATCH')
                        }
                        $.ajax({
                            url: url ,
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            cache: false,
                            async: false,
                            data: data
                        }).then(function (response) {
                            form.reset();
                            $("#permission-modal").modal('hide');
                            table.draw();
                            toastr.success(response.message, 'Success!')
                        }).catch(function (response) {
                            if (response.status == 422) {
                                validator.showErrors(response.responseJSON.errors)
                                return
                            }
                            toastr.error(response.statusText, response.status, {
                                tapToDismiss: true,
                                rtl: false
                            })
                        })
                    }
                })
            })

            /** On open edit modal */
            $(document).on('click', '.editPermission', function () {
                $('h5.modal-title').text('{{ __('permissions.datatable.modal.title_edit') }}');
                $('#submitBtn').text('{{__('permissions.datatable.modal.button_edit')}}');
                let rowData = table.row($(this).closest('tr')).data();
                $.each(rowData, function (key, val) {
                    $('#permission-modal #' + key).val(val).trigger('change')
                })
                $('#permission-modal').data('id', rowData.id)
                $('#permission-modal').modal('show');
            })

            /** On open add modal */
            $(document).on('click', '#addPermissionBtn', function () {
                $('h5.modal-title').text('{{ __('permissions.datatable.modal.title_add') }}');
                $('#submitBtn').text('{{ __('permissions.datatable.modal.button_add') }}');
            })

            /** Delete permission btn */
            $(document).on('click', '.deletePermission', function () {
                let rowData = table.row($(this).closest('tr')).data();
                let url = "{{route('management.permission.destroy',':permission')}}";
                url = url.replace(':permission', rowData.id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Permission has been deleted.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                })
                                table.draw();
                            },
                            error: function (response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oups!',
                                    text: 'Delete did not happen!',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            }
                        });
                    }
                });
            })

            /** Form reset on close */
            $('#permission-modal').on('hidden.bs.modal', function () {
                validator.resetForm()
                $(this).find(':input').val('').trigger('change');
                $(this).find(':input').removeClass('error');
                $(this).data('id', null);
            })

        </script>

    </x-slot>
</x-app-layout>


