@extends('layouts.app')

@push('upper-style-1')

@endpush


@push('upper-style-2')
    {{--    <link id="pagestyle" href="https://demos.creative-tim.com/soft-ui-dashboard-pro/assets/css/soft-ui-dashboard.min.css?v=1.0.9" rel="stylesheet">--}}
@endpush
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-2">
                @foreach($breadcrumb as $url_list)
                    @if(end($breadcrumb) == $url_list)
                        {{ $url_list }}
                    @else
                        <span class="text-muted fw-light">{{ $url_list }} /</span>
                    @endif
                @endforeach
            </h4>

            <!-- customers List Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header d-flex flex-wrap pb-md-2">
                            <div class="d-flex align-items-center me-5">
{{--                                <div id="DataTables_Table_0_filter" class="dataTables_filter ms-n3"><label><input type="search" class="form-control" placeholder="Search Order" aria-controls="DataTables_Table_0"></label>--}}
{{--                                </div>--}}
                            </div>
                            <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end gap-3 gap-sm-0 flex-wrap flex-sm-nowrap pt-0">
                                {{--                                <div class="dataTables_length ms-n2 mt-0 mt-md-3 me-2" id="DataTables_Table_0_length"><label><select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"--}}
                                {{--                                                                                                                                     class="form-select">--}}
                                {{--                                            <option value="10">10</option>--}}
                                {{--                                            <option value="25">25</option>--}}
                                {{--                                            <option value="50">50</option>--}}
                                {{--                                            <option value="100">100</option>--}}
                                {{--                                        </select></label>--}}
                                {{--                                </div>--}}
                                <div class="dt-buttons btn-group flex-wrap">
                                    {{--                                    <div class="btn-group">--}}
                                    {{--                                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-3" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog"--}}
                                    {{--                                                aria-expanded="false"><span><i class="ti ti-download me-1"></i>Export</span><span class="dt-down-arrow"></span></button>--}}
                                    {{--                                    </div>--}}
                                    <button class="btn btn-secondary add-new btn-primary py-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasEcommerceCustomerAdd"><span><i class="ti ti-plus me-0 me-sm-1 mb-1 ti-xs"></i><span class="d-none d-sm-inline-block">أضافة</span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <table class="datatables-customers table border-top dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>name</th>
                                <th>email</th>
                                <th>permission</th>
                                <th>status</th>
                                <th>created at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <h6 class="ms-3 my-auto">{{ $row->id }}</h6>
                                        </div>
                                    </td>
                                    {{--                                    <td class="text-sm">--}}
                                    {{--                                        @if($row->enabled == 1)--}}
                                    {{--                                            <span class="badge bg-label-success">فعال</span>--}}
                                    {{--                                        @else--}}
                                    {{--                                            <span class="badge bg-label-gray">غير فعال</span>--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </td>--}}
                                    <td class="text-sm">{{ $row->name ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->email ?? '-' }}</td>
                                    <td>
                                        @if($row->type == 1)
                                            <span class="badge bg-label-primary">admin</span>
                                        @else
                                            <span class="badge bg-label-info">user</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->enabled == 1)
                                            <span class="badge bg-label-success">فعال</span>
                                        @else
                                            <span class="badge bg-label-danger">غير فعال</span>
                                        @endif
                                    </td>
                                    <td class="text-sm">{{ $row->created_at ?? '-' }}</td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="offcanvas"
                                                    data-bs-target="#userEdit{{$row->id}}"><i class="ti ti-edit"></i></button>
{{--                                            <a class="btn btn-sm btn-icon delete-record" href="{{ route('investor.showGeneral', $row->id) }}"><i class="ti ti-eye"></i></a>--}}
                                        </div>
                                    </td>

                                </tr>
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="userEdit{{$row->id}}" aria-labelledby="userEditLabel">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasEcommerceCustomerAddLabel" class="offcanvas-title">تعديل مستثمر</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form class="ecommerce-customer-add pt-0 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('users.update', $row->id) }}" method="post">
                                            @csrf
                                            <div class="ecommerce-customer-add-basic mb-3">
                                                <h6 class="mb-3">Basic Information</h6>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="ecommerce-customer-add-name">{{__('all.name')}}*</label>
                                                    <input type="text" class="form-control" id="ecommerce-customer-add-name" placeholder="John Doe" aria-label="John Doe" name="name" value="{{ $row->name }}">
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="ecommerce-customer-add-email">{{__('all.email')}}*</label>
                                                    <input type="text" id="ecommerce-customer-add-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email"
                                                           value="{{ $row->email }}">
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="ecommerce-customer-add-email">{{__('all.password')}}*</label>
                                                    <input type="password" id="ecommerce-customer-add-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="password">
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="ecommerce-customer-add-country">{{ __('all.permission') }}</label>
                                                    <div class="position-relative">
                                                        <select id="ecommerce-customer-add-country" class="select2 form-select select2-hidden-accessible"
                                                                                           data-select2-id="ecommerce-customer-add-country"
                                                                                           tabindex="-1" aria-hidden="true" name="type">
                                                            <option value="1" {{ $row->type == '1' ? 'selected' : ''}}>Admin</option>
                                                            <option value="2" {{ $row->type == '2' ? 'selected' : ''}}>User</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="enabled">{{ __('all.status') }}</label>
                                                    <div class="position-relative">
                                                        <select id="enabled" class="select2 form-select select2-hidden-accessible"
                                                                                           data-select2-id="ecommerce-customer-add-country"
                                                                                           tabindex="-1" aria-hidden="true" name="enabled">
                                                            <option value="1" {{ $row->enabled == '1' ? 'selected' : ''}}>Enable</option>
                                                            <option value="0" {{ $row->enabled == '0' ? 'selected' : ''}}>Disable</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-3">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light">{{ __('all.submit') }}</button>
                                                <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">{{ __('all.cancel') }}</button>
                                            </div>
                                            <input type="hidden"></form>
                                    </div>
                                </div>
                            @endforeach
                            {{--                            <tr class="odd">--}}
                            {{--                                <td valign="top" colspan="6" class="dataTables_empty">Loading...</td>--}}
                            {{--                            </tr>--}}
                            </tbody>
                        </table>
                        <div class="row mx-2">
                            <div class="col-sm-12 col-md-6">
{{--                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 0 to 0 of 0 entries</div>--}}
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        {!! $data->appends(request()->query())->links('pagination::bootstrap-5') !!}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Offcanvas to add new customer -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceCustomerAdd" aria-labelledby="offcanvasEcommerceCustomerAddLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasEcommerceCustomerAddLabel" class="offcanvas-title">أضافة</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body mx-0 flex-grow-0">
                        <form class="ecommerce-customer-add pt-0 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('users.store') }}" method="post">
                            @csrf
                            <div class="ecommerce-customer-add-basic mb-3">
{{--                                <h6 class="mb-3">Basic Information</h6>--}}
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="ecommerce-customer-add-name">{{__('all.name')}}*</label>
                                    <input type="text" class="form-control" id="ecommerce-customer-add-name" placeholder="John Doe" aria-label="John Doe" name="name">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="ecommerce-customer-add-email">{{__('all.email')}}*</label>
                                    <input type="text" id="ecommerce-customer-add-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="ecommerce-customer-add-email">{{__('all.password')}}*</label>
                                    <input type="password" id="ecommerce-customer-add-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="password">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="ecommerce-customer-add-country">{{ __('all.permission') }}</label>
                                    <div class="position-relative">
                                        <select id="ecommerce-customer-add-country" class="select2 form-select select2-hidden-accessible"
                                                data-select2-id="ecommerce-customer-add-country"
                                                tabindex="-1" aria-hidden="true"
                                        name="type">
                                            <option value="1">Admin</option>
                                            <option value="2">User</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="enabled">{{ __('all.status') }}</label>
                                    <div class="position-relative">
                                        <select id="enabled" class="select2 form-select select2-hidden-accessible"
                                                name="enabled">
                                            <option value="1">Enable</option>
                                            <option value="0" >Disable</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light">{{ __('all.submit') }}</button>
                                <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">{{ __('all.cancel') }}</button>
                            </div>
                            <input type="hidden"></form>

                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
{{--            <div class="container-xxl">--}}
{{--                <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">--}}
{{--                    <div>--}}
{{--                        ©--}}
{{--                        <script>--}}
{{--                            document.write(new Date().getFullYear());--}}
{{--                        </script>--}}
{{--                        2023--}}
{{--                        , made with ❤️ by <a href="https://pixinvent.com" target="_blank" class="fw-medium">Pixinvent</a>--}}
{{--                    </div>--}}
{{--                    <div class="d-none d-lg-inline-block">--}}
{{--                        <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank">License</a>--}}
{{--                        <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4">More Themes</a>--}}

{{--                        <a href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>--}}

{{--                        <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </footer>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
