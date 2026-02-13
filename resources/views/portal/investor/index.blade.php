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
                                <div id="DataTables_Table_0_filter" class="dataTables_filter ms-n3">
                                    <form action="{{ route('investor.index') }}" method="get">
                                        <label>
                                            @if($filter->search)
                                                <input name="search" type="search" class="form-control" placeholder="{{ __('all.search') }}" value="{{ $filter->search }}">

                                            @else
                                                <input name="search" type="search" class="form-control" placeholder="{{ __('all.search') }}" >

                                            @endif
{{--                                            <input name="issue_date" type="datetime-local" class="form-control" placeholder="Search Order" aria-controls="DataTables_Table_0">--}}
                                            {{--                                            <button type="submit" class="btn btn-secondary add-new btn-primary py-2"><span><i class="ti ti-plus me-0 me-sm-1 mb-1 ti-xs"></i><span class="d-none d-sm-inline-block">أضافة</span></span>--}}
                                            {{--                                            </button>--}}
                                        </label>
                                    </form>
                                </div>
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
                                <th>Customer</th>
                                <th>reference</th>
                                <th>contract</th>
                                <th>phone</th>
                                <th>cash</th>
                                <th>currency</th>
                                <th>profit</th>
                                <th>total profit</th>
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
                                    <td class="text-sm">{{ $row->reference ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->contract_ref ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->phone ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->cash ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->currency ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->profit ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->total_profit ?? '-' }}</td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            @if($row->deleted_at == null)
                                                <a class="btn btn-sm btn-icon delete-record" href="{{ route('investor.showGeneral', $row->id) }}"><i class="ti ti-eye"></i></a>
                                            @else
                                                <span class="badge bg-label-danger">تم المسح</span>
                                            @endif
                                            {{--                                            <button class="btn btn-sm btn-icon"  type="button" data-bs-toggle="offcanvas"--}}
                                            {{--                                                    data-bs-target="#investorEdit{{$row->id}}"><i class="ti ti-edit"></i></button>--}}
{{--                                            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">--}}
{{--                                                <i class="ti ti-dots-vertical me-2"></i></button>--}}
{{--                                            <div class="dropdown-menu dropdown-menu-end m-0">--}}
{{--                                                <a href="javascript:0;" class="dropdown-item">View</a>--}}
{{--                                                <a href="javascript:0;" class="dropdown-item">Suspend</a>--}}
{{--                                            </div>--}}
                                        </div>
                                    </td>

                                </tr>
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
{{--                                        <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a aria-controls="DataTables_Table_0" aria-disabled="true" aria-role="link"--}}
{{--                                                                                                                                    data-dt-idx="previous" tabindex="0" class="page-link">Previous</a></li>--}}
{{--                                        <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next"><a aria-controls="DataTables_Table_0" aria-disabled="true" aria-role="link" data-dt-idx="next"--}}
{{--                                                                                                                            tabindex="0" class="page-link">Next</a></li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Offcanvas to add new investor -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceCustomerAdd" aria-labelledby="offcanvasEcommerceCustomerAddLabel">
                    <div class="offcanvas-header">
                                                <h5 id="offcanvasEcommerceCustomerAddLabel" class="offcanvas-title">أضافة</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body mx-0 flex-grow-0">
                        <form class="ecommerce-customer-add pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="eCommerceCustomerAddForm" action="{{ route('investor.store') }}" method="post">
                            @csrf
                            <div class="ecommerce-customer-add-basic mb-3">
                                <h6 class="mb-3">{{__('all.add')}} {{__('all.investor')}}</h6>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="name">{{__('all.name')}}*</label>
                                    <input type="text" class="form-control" id="name" placeholder="" name="name" aria-label="">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="email">{{__('all.email')}}*</label>
                                    <input type="text" class="form-control" id="email" placeholder="" name="email" aria-label="">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="phone">{{__('all.phone')}}*</label>
                                    <input type="text" class="form-control" id="phone" placeholder="" name="phone" aria-label="">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="cash">{{__('all.cash')}}*</label>
                                    <input type="number" class="form-control" id="cash" placeholder="" name="cash" aria-label="">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="modalEditUserStatus">{{__('all.currency')}}</label>
                                    <select id="modalEditUserStatus" name="currency" class="select2 form-select select2-hidden-accessible">
                                        <option value="IQD">IQD</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="expire_contract">{{__('all.expire_contract')}}*</label>
                                    <input type="date" class="form-control" id="expire_contract" placeholder="" name="expire_contract" aria-label="">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="contract_ref">{{__('all.contract_ref')}}*</label>
                                    <input type="text" class="form-control" id="contract_ref" placeholder="" name="contract_ref" aria-label="">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="d-sm-flex mb-3 pt-3">

                                </div>
                                <div class="d-sm-flex mb-3 pt-3">

                                </div>


                                <div class="row mb-3">
                                    <div class="col-12 col-md-4">
                                        <label class="form-label" for="modalEditUserStatus">{{__('all.status')}}</label>
                                        <div class="position-relative">
                                            <select id="modalEditUserStatus" name="enabled" class="select2 form-select select2-hidden-accessible" aria-label="Default select example"
                                                    data-select2-id="modalEditUserStatus" tabindex="-1" aria-hidden="true">
                                                <option value="1" >فعال</option>
                                                <option value="0" >غير فعال</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 fv-plugins-icon-container">
                                        <label class="form-label" for="insurance">{{__('all.insurance')}}</label>
                                        <div class="position-relative">
                                            <select id="modalEditUserStatus" name="insurance" class="select2 form-select select2-hidden-accessible" aria-label="Default select example"
                                                    data-select2-id="modalEditUserStatus" tabindex="-1" aria-hidden="true" >
                                                <option value="1" >فعال</option>
                                                <option value="0" >غير فعال</option>
                                            </select>
                                        </div>
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label" for="ecommerce-customer-add-country">{{__('all.city')}}</label>
                                    <div class="position-relative">
                                        <select id="ecommerce-customer-add-country" class="select2 form-select select2-hidden-accessible"
                                                                           name="city">
                                            <option value="Baghdad">Baghdad</option>
                                            <option value="Dhi Qar">Dhi Qar</option>
                                            <option value="Babylon">Babylon</option>
                                            <option value="Al-Qādisiyyah">Al-Qādisiyyah</option>
                                            <option value="Karbala">Karbala</option>
                                            <option value="Al Muthanna">Al Muthanna</option>
                                            <option value="Basra">Basra</option>
                                            <option value="Saladin">Saladin</option>
                                            <option value="Najaf">Najaf</option>
                                            <option value="Nineveh">Nineveh</option>
                                            <option value="Al Anbar">Al Anbar</option>
                                            <option value="Diyala">Diyala</option>
                                            <option value="Maysan">Maysan</option>
                                            <option value="Dohuk">Dohuk</option>
                                            <option value="Erbil">Erbil</option>
                                            <option value="Sulaymaniyah">Sulaymaniyah</option>
                                            <option value="Wasit">Wasit</option>
                                            <option value="Kirkuk">Kirkuk</option>
                                        </select>
                                    </div>
                                </div>


{{--                                <div class="mb-3 fv-plugins-icon-container">--}}
{{--                                    <label class="form-label" for="ecommerce-customer-add-email">{{__('all.email')}}</label>--}}
{{--                                    <input type="text" id="ecommerce-customer-add-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email">--}}
{{--                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <label class="form-label" for="ecommerce-customer-add-contact">{{__('all.phone')}}</label>--}}
{{--                                    <input type="text" id="ecommerce-customer-add-contact" class="form-control phone-mask" placeholder="+(123) 456-7890" aria-label="+(123) 456-7890" name="phone">--}}
{{--                                </div>--}}
                            </div>

{{--                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">--}}
{{--                                <h6 class="mb-3">Shipping Information</h6>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label" for="ecommerce-customer-add-address">Address Line 1</label>--}}
{{--                                    <input type="text" id="ecommerce-customer-add-address" class="form-control" placeholder="45 Roker Terrace" aria-label="45 Roker Terrace" name="customerAddress1">--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label" for="ecommerce-customer-add-address-2">Address Line 2</label>--}}
{{--                                    <input type="text" id="ecommerce-customer-add-address-2" class="form-control" aria-label="address2" name="customerAddress2">--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label" for="ecommerce-customer-add-town">Town</label>--}}
{{--                                    <input type="text" id="ecommerce-customer-add-town" class="form-control" placeholder="New York" aria-label="New York" name="customerTown">--}}
{{--                                </div>--}}
{{--                                <div class="row mb-3">--}}
{{--                                    <div class="col-12 col-sm-6">--}}
{{--                                        <label class="form-label" for="ecommerce-customer-add-state">State / Province</label>--}}
{{--                                        <input type="text" id="ecommerce-customer-add-state" class="form-control" placeholder="Southern tip" aria-label="Southern tip" name="customerState">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-12 col-sm-6">--}}
{{--                                        <label class="form-label" for="ecommerce-customer-add-post-code">Post Code</label>--}}
{{--                                        <input type="text" id="ecommerce-customer-add-post-code" class="form-control" placeholder="734990" aria-label="734990" name="pin" pattern="[0-9]{8}" maxlength="8">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <label class="form-label" for="ecommerce-customer-add-country">Country</label>--}}
{{--                                    <div class="position-relative"><select id="ecommerce-customer-add-country" class="select2 form-select select2-hidden-accessible" data-select2-id="ecommerce-customer-add-country"--}}
{{--                                                                           tabindex="-1" aria-hidden="true">--}}
{{--                                            <option value="" data-select2-id="2">Select</option>--}}
{{--                                            <option value="Australia">Australia</option>--}}
{{--                                            <option value="Bangladesh">Bangladesh</option>--}}
{{--                                            <option value="Belarus">Belarus</option>--}}
{{--                                            <option value="Brazil">Brazil</option>--}}
{{--                                            <option value="Canada">Canada</option>--}}
{{--                                            <option value="China">China</option>--}}
{{--                                            <option value="France">France</option>--}}
{{--                                            <option value="Germany">Germany</option>--}}
{{--                                            <option value="India">India</option>--}}
{{--                                            <option value="Indonesia">Indonesia</option>--}}
{{--                                            <option value="Israel">Israel</option>--}}
{{--                                            <option value="Italy">Italy</option>--}}
{{--                                            <option value="Japan">Japan</option>--}}
{{--                                            <option value="Korea">Korea, Republic of</option>--}}
{{--                                            <option value="Mexico">Mexico</option>--}}
{{--                                            <option value="Philippines">Philippines</option>--}}
{{--                                            <option value="Russia">Russian Federation</option>--}}
{{--                                            <option value="South Africa">South Africa</option>--}}
{{--                                            <option value="Thailand">Thailand</option>--}}
{{--                                            <option value="Turkey">Turkey</option>--}}
{{--                                            <option value="Ukraine">Ukraine</option>--}}
{{--                                            <option value="United Arab Emirates">United Arab Emirates</option>--}}
{{--                                            <option value="United Kingdom">United Kingdom</option>--}}
{{--                                            <option value="United States">United States</option>--}}
{{--                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 352px;"><span class="selection"><span--}}
{{--                                                    class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"--}}
{{--                                                    aria-labelledby="select2-ecommerce-customer-add-country-container"><span class="select2-selection__rendered" id="select2-ecommerce-customer-add-country-container"--}}
{{--                                                                                                                             role="textbox" aria-readonly="true"><span--}}
{{--                                                            class="select2-selection__placeholder">United States </span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span--}}
{{--                                                class="dropdown-wrapper" aria-hidden="true"></span></span></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="d-sm-flex mb-3 pt-3">--}}
{{--                                <div class="me-auto mb-2 mb-md-0">--}}
{{--                                    <h6 class="mb-0">Use as a billing address?</h6>--}}
{{--                                    <small class="text-muted">If you need more info, please check budget.</small>--}}
{{--                                </div>--}}
{{--                                <label class="switch m-auto pe-2">--}}
{{--                                    <input type="checkbox" class="switch-input">--}}
{{--                                    <span class="switch-toggle-slider">--}}
{{--                            <span class="switch-on"></span>--}}
{{--                            <span class="switch-off"></span>--}}
{{--                          </span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
                            <div class="pt-3">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light">{{__('all.add')}}</button>
                                <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">{{__('all.cancel')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <!-- Footer -->
{{--        <footer class="content-footer footer bg-footer-theme">--}}
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
{{--        </footer>--}}
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
