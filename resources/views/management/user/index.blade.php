<x-app-layout>
    <x-slot:menuselected>users</x-slot:menuselected>
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
            <!-- user list start -->
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        <div class="head-label"><h4 class="mb-0">{{ __('users.datatable.title') }}</h4></div>
                        <div class="text-end">
                            <div class="dt-buttons d-inline-flex">
                                <button class="dt-button create-new btn btn-primary" tabindex="0" type="button"
                                        data-bs-toggle="modal" id="addUserBtn"
                                        data-bs-target="#user-modal"><span>{{ __('users.datatable.add_btn') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <div class="p-2">
                            <table class="user-list-table table">
                                <thead class="table-light">
                                <tr>
                                    <th>{{ __('users.datatable.columns.number') }}</th>
                                    <th>{{ __('users.datatable.columns.name') }}</th>
                                    <th>{{ __('users.datatable.columns.email') }}</th>
                                    <th>{{ __('users.datatable.columns.role') }}</th>
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
        <!-- users list ends -->
    </div>


    <!-- Modal to add new user-->
    <div class="modal modal-slide-in fade" id="user-modal">
        <div class="modal-dialog">
            <form class="modal-content pt-0" id="user-form">
                @csrf
                <button type="reset" class="btn-close cancel" data-bs-dismiss="modal"
                        aria-label="Close">×
                </button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">{{ __('users.datatable.modal.title') }}</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-2">
                        <label class="form-label"
                               for="name">{{ __('users.datatable.modal.name') }}</label>
                        <input type="text" class="form-control dt-full-name"
                               id="name"
                               name="name" autocomplete="off"/>
                    </div>
                    <div class="mb-2">
                        <label class="form-label"
                               for="email">{{ __('users.datatable.modal.email') }}</label>
                        <input type="text" class="form-control dt-email"
                               id="email"
                               name="email" autocomplete="off"/>
                    </div>
                    <div class="mb-2">
                        <label class="form-label"
                               for="role">{{ __('users.datatable.modal.role.title') }}</label>
                        <select class="select2 form-select" id="role" name="role" autocomplete="off">
                            <optgroup label="{{__('users.datatable.modal.role.option')}}">
                                <option selected></option>
                                @foreach($roles as $role)
                                    <option class="{{ $role->guard_name }}"
                                            value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <input type="hidden" id="guard" name="guard" autocomplete="off"/>
                    <div class="mb-2 permissions-div d-none">
                        <label class="form-label permission-form-lable"
                               for="permission">{{ __('users.datatable.modal.permissions') }}</label>
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
                            id="submitBtn">{{ __('users.datatable.modal.button') }}</button>
                    <button type="reset" class="btn btn-outline-secondary cancel"
                            data-bs-dismiss="modal">
                        {{ __('users.datatable.modal.cancel_btn') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal to add new user-->

    <!-- Modal for gsm-box providers-->
    <div class="modal modal-slide-in fade" id="gsm-box-modal">
        <div class="modal-dialog">
            <form class="modal-content pt-0" id="gsm-box-form">
                @csrf
                <button type="reset" class="btn-close cancel" data-bs-dismiss="modal"
                        aria-label="Close">×
                </button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">{{ __('users.datatable.gsm_box_modal.title') }}</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-0">
                        <label class="form-label"
                               for="gsm-box">{{ __('users.datatable.gsm_box_modal.providers') }}</label>
                        @foreach($gsmBoxes as $gsmBox => $params)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="checkbox gsm-box row m-0">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox"
                                                   class="form-check-input gsm-box-name"
                                                   name="gsm_permissions"
                                                   value="{{ $gsmBox }}" id="{{ $gsmBox }}">
                                            <label for="gsm-box" class="form-check-label">{{ $params['name'] }}</label>
                                            <br><br>
                                            @foreach($params['port'] as $port)
                                                <div
                                                    class="form-check form-check-inline {{ $gsmBox.'_gms-box-port-div' }} col-lg-2">
                                                    <input type="checkbox" disabled
                                                           class="form-check-input {{ $gsmBox.'-port' }}"
                                                           name="gsm_box[{{ $gsmBox }}][]"
                                                           value="{{ $port }}" id="{{ $gsmBox.'_'.$port }}">
                                                    <label for="permission" class="form-check-label">{{ $port }}</label>
                                                </div>
                                            @endforeach
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                    <button type="submit"
                            class="btn btn-primary me-1 data-submit"
                            id="submitBtnGsmBox">{{ __('users.datatable.gsm_box_modal.button_save') }}</button>
                    <button type="reset" class="btn btn-outline-secondary cancel"
                            data-bs-dismiss="modal">
                        {{ __('users.datatable.gsm_box_modal.button_cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal for gsm-box providers-->

    <!--Scripts-->
    <x-slot name="scripts">
        <!-- Datatable -->
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/dataTables.responsive.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/theme/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
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
            let validatorGsm;
            let firstEdit = true;
            $(function () {

                /** Role select */
                $('.select2').select2();

                /** User list datatable */
                table = $('.user-list-table').DataTable({
                    "drawCallback": function (settings) {
                        feather.replace();
                    },
                    serverSide: true,
                    processing: true,
                    paging: true,
                    ajax: {
                        url: "{{ route('management.user.datatable') }}",
                        type: 'POST',
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
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            width: '1%',
                            orderable: false
                        },
                    ],
                })

                /** Add user validator */
                validator = $('#user-form').validate({
                    rules: {
                        name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true,
                        },
                        role: {
                            required: true
                        },
                    }, submitHandler(form, e) {
                        e.preventDefault();
                        let url = '{{ route('management.user.store') }}'
                        let type = 'POST'
                        let userId = $('#user-modal').data('id');
                        if (userId) {
                            url = "{{route('management.user.update',':user')}}";
                            url = url.replace(':user', userId);
                            type = 'PATCH'
                        }
                        let permissions = $("#user-form input:checkbox:checked").map(function () {
                            return $(this).val();
                        }).get()
                        $.ajax({
                            url: url,
                            type: type,
                            data: {
                                'name': $('#name').val(),
                                'email': $('#email').val(),
                                'role': $('#role').val(),
                                'guard': $('#guard').val(),
                                'permissions': permissions,
                            }
                        }).then(function (response) {
                            form.reset();
                            $("#user-modal").modal('hide');
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
            $(document).on('click', '.editUser', function () {
                $('h5.modal-title').text('{{ __('users.datatable.modal.title_edit') }}');
                $('#submitBtn').text('{{ __('users.datatable.modal.button_edit') }}');
                let rowData = table.row($(this).closest('tr')).data();
                $.each(rowData, function (key, val) {
                    $('#user-modal #' + key).val(val).trigger('change')
                })
                $.each(rowData.permissions, function (index, permission) {
                    $(`#user-modal input:checkbox[id='permission_${permission.id}']`).prop('checked', true)
                })
                $('#user-modal').data('id', rowData.id)
                $('#user-modal').modal('show');
                firstEdit = false;
            })

            /** On open add modal */
            $(document).on('click', '#addUserBtn', function () {
                $('h5.modal-title').text('{{ __('users.datatable.modal.title_add') }}');
                $('#submitBtn').text('{{ __('users.datatable.modal.button_add') }}');
                $('input:checkbox').removeAttr('checked');
                firstEdit = false;
            })

            /** Delete user btn */
            $(document).on('click', '.deleteUser', function () {
                let rowData = table.row($(this).closest('tr')).data();
                let url = "{{route('management.user.destroy',':user')}}";
                url = url.replace(':user', rowData.id);
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
                                    text: 'User has been deleted.',
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

            /** Filter permissions based on role choice */
            $('.select2').change(function () {
                let rolePermissions =@json($rolePermissions);
                $('.permissions').removeClass('d-none')
                $('.permission-form-lable').removeClass('d-none')
                $('input:checkbox').prop('checked', false);
                $('.permissions-div').addClass('d-none')
                if ($('.select2').val() != '') {
                    $('.permissions-div').removeClass('d-none')
                    !$(`.permissions:not(.guard-${$('select[name="role"] :selected').attr('class')})`).addClass('d-none')
                    if ($('.permissions-form.d-none').length == $('.permissions-form').length) {
                        $('.permission-form-lable').addClass('d-none')
                    }
                    $('#guard').val($('select[name="role"] :selected').attr('class'));
                    if (!firstEdit) {
                        $.each(rolePermissions[$('.select2').val()], function (index, id) {
                            $(`#user-modal input:checkbox[id='permission_${id}']`).prop('checked', true)
                        })
                    }
                }
            })

            /** Reset form on close */
            $('#user-modal').on('hidden.bs.modal', function () {
                validator.resetForm()
                $(this).find(':input:not([type=checkbox])').val('').trigger('change');
                $(this).find(':input').removeClass('error');
                $(this).find(':input[type=checkbox]').prop('checked', false);
                $(this).data('id', null);
                firstEdit = true;
            })

            /** Add gsmBox permission validator */
            validatorGsm = $('#gsm-box-form').validate({
                // rules: {
                //     gsm_box: {
                //         required: true
                //     },
                // },
                submitHandler(form, e) {
                    e.preventDefault();
                    let data = new FormData(form);
                    let url = '{{ route('management.user.gsm-box', ':id')}}'
                    url = url.replace(':id', $('#gsm-box-modal').data('id'))
                    $.ajax({
                        url: url,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: data
                    }).then(function (response) {
                        form.reset();
                        $("#gsm-box-modal").modal('hide');
                        table.draw();
                        toastr.success(response.message, 'Success!')
                    }).catch(function (response) {
                        if (response.status == 422) {
                            validatorGsm.showErrors(response.responseJSON.errors)
                            return
                        }
                        toastr.error(response.statusText, response.status, {
                            tapToDismiss: true,
                            rtl: false
                        })
                    })
                }
            })

            /** On open gsmbox modal */
            $(document).on('click', '.gsmBoxBtn', function () {
                let rowData = table.row($(this).closest('tr')).data();
                $.each(rowData.gsm_permissions, function (provider, ports) {
                    $(`#gsm-box-modal input:checkbox[id='${provider}']`).prop('checked', true)
                    $("." + $(`#gsm-box-modal input:checkbox[id='${provider}']`).val() + "-port").prop("disabled", false)
                    $.each(ports, function (index, port) {
                        $(`#gsm-box-modal input:checkbox[id='${provider}_${port}']`).prop('checked', true)
                    })
                })
                $('#gsm-box-modal').data('id', rowData.id)
                $('#gsm-box-modal').modal('show');
            })

            /** On click gsm providers */
            $('.gsm-box-name').on('click', function () {
                if ($(this).is(":checked")) {
                    $("." + $(this).val() + "-port").prop("disabled", false)
                } else {
                    $("." + $(this).val() + "-port").prop("disabled", true)
                    $("." + $(this).val() + "-port").prop("checked", false)
                }
            })

            /** Reset gsm box modal on close */
            $('#gsm-box-modal').on('hidden.bs.modal', function () {
                $(this).find(':input[type=checkbox]').prop('checked', false);
                $(this).find(':input[type=checkbox][name!="gsm_permissions"]').prop('disabled', true);
                $(this).data('id', null);
            })

        </script>
    </x-slot>
</x-app-layout>
