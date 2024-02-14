<x-app-layout>
    <x-slot:menuselected>roles</x-slot:menuselected>
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
            <!-- role list start -->
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        <div class="head-label"><h4 class="mb-0">{{ __('roles.datatable.title') }}</h4></div>
                        <div class="text-end">
                            <div class="dt-buttons d-inline-flex">
                                <button class="dt-button create-new btn btn-primary" tabindex="0" type="button"
                                        data-bs-toggle="modal" id="addRoleBtn"
                                        data-bs-target="#role-modal"><span>{{ __('roles.datatable.add_btn') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <div class="p-2">
                            <table class="role-list-table table">
                                <thead class="table-light">
                                <tr>
                                    <th>{{ __('roles.datatable.columns.number') }}</th>
                                    <th>{{ __('roles.datatable.columns.name') }}</th>
                                    <th>{{ __('roles.datatable.columns.guard_name') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </section>
            <!-- list and filter end -->
        </div>
        <!-- roles list ends -->
    </div>

    <!-- Modal to add new role-->
    <div class="modal modal-slide-in fade" id="role-modal">
        <div class="modal-dialog">
            <form class="modal-content pt-0" id="role-form">
                <button type="reset" class="btn-close cancel" data-bs-dismiss="modal"
                        aria-label="Close">×
                </button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">{{ __('roles.datatable.modal.title') }}</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-2">
                        <label class="form-label"
                               for="name">{{ __('roles.datatable.modal.name') }}</label>
                        <input type="text" class="form-control dt-full-name"
                               id="name"
                               name="name" autocomplete="off"/>
                    </div>
                    <div class="mb-2">
                        <label class="form-label"
                               for="guard_name">{{ __('roles.datatable.modal.guard_name.title') }}</label>
                        <select class="select2 form-select" id="guard_name" name="guard_name"
                                autocomplete="off">
                            <optgroup label="{{__('roles.datatable.modal.guard_name.option')}}">
                                <option selected></option>
                                @foreach($guards as $guard)
                                    <option value="{{ $guard }}">{{ $guard }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="mb-2 permissions-div d-none">
                        <label class="form-label permission-form-lable"
                               for="permission">{{ __('roles.datatable.modal.permissions') }}</label>
                        <div class="checkbox">
                            @foreach($permissions as $permission)
                                <div
                                    class="form-check form-check-inline permissions permissions-form {{ 'guard-'.$permission->guard_name }}">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           name="permission"
                                           value="{{ $permission->name }}" id="permission_{{ $permission->id }}">
                                    <label for="permission" class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit"
                            class="btn btn-primary me-1 data-submit"
                            id="submitBtn">{{ __('roles.datatable.modal.button') }}</button>
                    <button type="reset" class="btn btn-outline-secondary cancel"
                            data-bs-dismiss="modal">
                        {{ __('roles.datatable.modal.cancel_btn') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal to add new role-->
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

                /** Select 2 for guard name */
                $('.select2').select2();

                /** Roles Datatable */
                table = $('.role-list-table').DataTable({
                    "drawCallback": function (settings) {
                        feather.replace();
                    },
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('management.role.datatable') }}",
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
                            orderable: false,
                            width: '1%'
                        },
                    ],
                })

                /** Role add/edit form validation */
                validator = $('#role-form').validate({
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
                        let url = '{{ route('management.role.store') }}'
                        let type = 'POST'
                        if ($('#role-modal').data('id')) {
                            url = '{{ route('management.role.update',':id') }}'
                            url = url.replace(':id', $('#role-modal').data('id'))
                            type = 'PATCH'
                        }
                        let permissions = $("#role-form input:checkbox:checked").map(function () {
                            return $(this).val();
                        }).get()
                        $.ajax({
                            url: url,
                            type: type,
                            data: {
                                'name': $('#name').val(),
                                'guard_name': $('#guard_name').val(),
                                'permissions': permissions
                            }
                        }).then(function (response) {
                            form.reset();
                            $("#role-modal").modal('hide');
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
                });
            })

            /** On open edit modal */
            $(document).on('click', '.editRole', function () {
                $('h5.modal-title').text('{{ __('roles.datatable.modal.title_edit') }}');
                $('#submitBtn').text('{{ __('roles.datatable.modal.button_edit') }}');
                let rowData = table.row($(this).closest('tr')).data();
                $.each(rowData, function (key, val) {
                    $('#role-modal #' + key).val(val).trigger('change')
                    if (key == 'permissions') {
                        $.each(val, function (index, data) {
                            $(`#role-modal input:checkbox[id='permission_${data.id}']`).prop('checked', true)
                        })
                    }
                })
                $('#role-modal').data('id', rowData.id)
                $('#role-modal').modal('show')
            })

            /** On open add modal */
            $(document).on('click', '#addRoleBtn', function () {
                $('h5.modal-title').text('{{ __('roles.datatable.modal.title_add') }}');
                $('#submitBtn').text('{{ __('roles.datatable.modal.button_add') }}');
            })

            /** Filter permissions based on guard choice */
            $('.select2').change(function () {
                $('.permissions-div').addClass('d-none')
                $('.permissions').removeClass('d-none')
                $('input:checkbox').prop('checked', false);
                if ($('.select2').val() != '') {
                    $('.permissions-div').removeClass('d-none')
                    !$(`.permissions:not(.guard-${$('.select2').val()})`).addClass('d-none')
                    if ($('.permissions-form.d-none').length == $('.permissions-form').length) {
                        $('.permissions-div').addClass('d-none')
                    }
                }
            })

            /** Reset form on close */
            $('#role-modal').on('hidden.bs.modal', function () {
                validator.resetForm()
                $(this).find(':input:not([type=checkbox])').val('').trigger('change');
                $(this).find(':input').removeClass('error');
                $(this).find(':input[type=checkbox]').prop('checked', false);
                $(this).data('id', null);
            })

        </script>
    </x-slot>
</x-app-layout>


