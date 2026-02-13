@extends('layouts.app')

@push('upper-style-1')

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
                <div class="card-header">
                    {{--                    <h5 class="card-title mb-0">Filter</h5>--}}
                    <form class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0" action="{{ route('profit-check.index') }}" method="get">

                        <div class="col-md-3">
                            <label class="form-label" for="email">{{ __('all.investor') }}</label>
                            <input name="investor" type="text" class="form-control" placeholder="{{ __('all.investor') }}"  value="{{ $filter->investor }}">

                        </div>
                        <div class="col-md-3">
                            @if(isset($filter))
                                <label class="form-label" for="email">{{ __('all.date_from') }}</label>
                                <input name="date_from" type="date" class="form-control" placeholder="{{ __('all.date_from') }}"  value="{{ $filter->date_from }}">

                            @else
                                <label class="form-label" for="email">{{ __('all.date_from') }}</label>
                                <input name="date_from" type="date" class="form-control" placeholder="{{ __('all.date_from') }}" >

                            @endif
                        </div>
                        <div class="col-md-3">
                            @if(isset($filter))
                                <label class="form-label" for="email">{{ __('all.date_to') }}</label>
                                <input name="date_to" type="date" class="form-control" placeholder="{{ __('all.date_to') }}"  value="{{ $filter->date_to }}">

                            @else
                                <label class="form-label" for="email">{{ __('all.date_to') }}</label>
                                <input name="date_to" type="date" class="form-control" placeholder="{{ __('all.date_to') }}" >

                            @endif
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="status">{{ __('all.status') }}</label>
                            <select id="status" name="status" class="form-select text-capitalize">
                                <option value="-1" ></option>
                                <option value="0" {{ $filter->status == '0' ? 'selected' : ''}}>غير فعال</option>
                                <option value="1" {{ $filter->status == '1' ? 'selected' : ''}}>  فعال</option>
                            </select></div>
                        <div class="col-md-3 pt-3">


                            <button type="submit" class="btn  btn-primary">
                                {{ __('all.search') }}
                            </button>

                        </div>
                    </form>

                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header d-flex border-top rounded-0 flex-wrap py-2">
                            <div class="me-5 ms-n2 pe-5">
                                                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                                    <form action="{{ route('profit-check.release') }}" method="get">
                                                                        <label>
                                                                            <button type="submit" class="btn btn-secondary add-new btn-primary py-2">
                                                                                <span><i class="ti ti-plus me-0 me-sm-1 mb-1 ti-xs">
                                                                                    </i><span class="d-none d-sm-inline-block">أطلاق الارباح</span></span>
                                                                                                                        </button>
                                                                        </label>
                                                                    </form>
                                                                </div>
                            </div>
{{--                            <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">--}}
{{--                                <div class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">--}}

{{--                                    <div class="dt-buttons d-flex flex-wrap">--}}
{{--                                        <form action="{{ route('withdraw-check.export') }}" method="get">--}}
{{--                                            <button type="submit" class="dt-button buttons-collection  btn btn-label-secondary me-3" ><span><i class="ti ti-download me-1 ti-xs"></i>{{ __('all.export') }}</span>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                        --}}{{----}}{{--                                        <button class="dt-button add-new btn btn-primary ms-2 ms-sm-0" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i--}}
{{--                                        --}}{{----}}{{--                                                    class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">{{ __('all.add') }}</span></span>--}}
{{--                                        --}}{{----}}{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <table class="datatables-customers table border-top dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('all.investor') }}</th>
                                <th>{{ __('all.reference') }}</th>
                                <th>{{ __('all.cash') }}</th>
                                <th>{{ __('all.ratio') }}</th>
                                <th>{{ __('all.ratio_per_day') }}</th>
                                <th>{{ __('all.days_to_calculate') }}</th>
                                <th>{{ __('all.total') }}</th>
                                <th>{{ __('all.created_at') }}</th>
                                <th>{{ __('all.status') }}</th>
                                <th>{{ __('all.action') }}</th>
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

                                    <td class="text-sm">{{ $row->userDetail->name ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->userDetail->reference ?? '-' }}</td>
                                    <td class="text-sm">{{ number_format($row->cash,2) ?? '-' }} - {{ $row->userDetail->currency ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->ratio ?? '-' }}</td>
                                    <td class="text-sm">{{ number_format($row->ratio_per_day,2) ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->days_to_calculate ?? '-' }}</td>
                                    <td class="text-sm">{{ number_format($row->total,2) ?? '-' }}</td>
                                    <td class="text-sm">{{ $row->created_at ?? '-' }}</td>
                                    <td class="text-sm">
                                        @if($row->status == 1)
                                            <span class="badge bg-label-success">فعال</span>
                                        @else
                                            <span class="badge bg-label-danger">غير فعال</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->status != 1)
                                            <form action="{{ route('profit-check.approve', $row->id) }}" method="get">
                                                @csrf
                                                <button class="btn btn-sm btn-icon" type="submit"><i class="ti ti-checkbox"></i></button>
                                            </form>
                                        @else
                                            {{--                                                <span class="badge bg-label-danger">غير فعال</span>--}}
                                        @endif
                                    </td>

                                </tr>
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="investorEdit{{$row->id}}" aria-labelledby="investorEditLabel">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasEcommerceCustomerAddLabel" class="offcanvas-title">تعديل مستثمر</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form class="ecommerce-customer-add pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="eCommerceCustomerAddForm" onsubmit="return false" novalidate="novalidate">
                                            <div class="ecommerce-customer-add-basic mb-3">
                                                <h6 class="mb-3">Basic Information</h6>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="ecommerce-customer-add-name">Name*</label>
                                                    <input type="text" class="form-control" id="ecommerce-customer-add-name" placeholder="John Doe" name="customerName" aria-label="John Doe" value="{{ $row->name }}">
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="ecommerce-customer-add-email">Email*</label>
                                                    <input type="text" id="ecommerce-customer-add-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="customerEmail">
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div>
                                                    <label class="form-label" for="ecommerce-customer-add-contact">Mobile</label>
                                                    <input type="text" id="ecommerce-customer-add-contact" class="form-control phone-mask" placeholder="+(123) 456-7890" aria-label="+(123) 456-7890"
                                                           name="customerContact">
                                                </div>
                                            </div>

                                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">
                                                <h6 class="mb-3">Shipping Information</h6>
                                                <div class="mb-3">
                                                    <label class="form-label" for="ecommerce-customer-add-address">Address Line 1</label>
                                                    <input type="text" id="ecommerce-customer-add-address" class="form-control" placeholder="45 Roker Terrace" aria-label="45 Roker Terrace" name="customerAddress1">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="ecommerce-customer-add-address-2">Address Line 2</label>
                                                    <input type="text" id="ecommerce-customer-add-address-2" class="form-control" aria-label="address2" name="customerAddress2">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="ecommerce-customer-add-town">Town</label>
                                                    <input type="text" id="ecommerce-customer-add-town" class="form-control" placeholder="New York" aria-label="New York" name="customerTown">
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label" for="ecommerce-customer-add-state">State / Province</label>
                                                        <input type="text" id="ecommerce-customer-add-state" class="form-control" placeholder="Southern tip" aria-label="Southern tip" name="customerState">
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label" for="ecommerce-customer-add-post-code">Post Code</label>
                                                        <input type="text" id="ecommerce-customer-add-post-code" class="form-control" placeholder="734990" aria-label="734990" name="pin" pattern="[0-9]{8}" maxlength="8">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="form-label" for="ecommerce-customer-add-country">Country</label>
                                                    <div class="position-relative"><select id="ecommerce-customer-add-country" class="select2 form-select select2-hidden-accessible"
                                                                                           data-select2-id="ecommerce-customer-add-country"
                                                                                           tabindex="-1" aria-hidden="true">
                                                            <option value="" data-select2-id="2">Select</option>
                                                            <option value="Australia">Australia</option>
                                                            <option value="Bangladesh">Bangladesh</option>
                                                            <option value="Belarus">Belarus</option>
                                                            <option value="Brazil">Brazil</option>
                                                            <option value="Canada">Canada</option>
                                                            <option value="China">China</option>
                                                            <option value="France">France</option>
                                                            <option value="Germany">Germany</option>
                                                            <option value="India">India</option>
                                                            <option value="Indonesia">Indonesia</option>
                                                            <option value="Israel">Israel</option>
                                                            <option value="Italy">Italy</option>
                                                            <option value="Japan">Japan</option>
                                                            <option value="Korea">Korea, Republic of</option>
                                                            <option value="Mexico">Mexico</option>
                                                            <option value="Philippines">Philippines</option>
                                                            <option value="Russia">Russian Federation</option>
                                                            <option value="South Africa">South Africa</option>
                                                            <option value="Thailand">Thailand</option>
                                                            <option value="Turkey">Turkey</option>
                                                            <option value="Ukraine">Ukraine</option>
                                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                                            <option value="United Kingdom">United Kingdom</option>
                                                            <option value="United States">United States</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 352px;"><span class="selection"><span
                                                                    class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                                                    aria-labelledby="select2-ecommerce-customer-add-country-container"><span class="select2-selection__rendered"
                                                                                                                                             id="select2-ecommerce-customer-add-country-container"
                                                                                                                                             role="textbox" aria-readonly="true"><span
                                                                            class="select2-selection__placeholder">United States </span></span><span class="select2-selection__arrow" role="presentation"><b
                                                                            role="presentation"></b></span></span></span><span
                                                                class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                                                </div>
                                            </div>

                                            <div class="d-sm-flex mb-3 pt-3">
                                                <div class="me-auto mb-2 mb-md-0">
                                                    <h6 class="mb-0">Use as a billing address?</h6>
                                                    <small class="text-muted">If you need more info, please check budget.</small>
                                                </div>
                                                <label class="switch m-auto pe-2">
                                                    <input type="checkbox" class="switch-input">
                                                    <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                          </span>
                                                </label>
                                            </div>
                                            <div class="pt-3">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light">Add</button>
                                                <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Discard</button>
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
                                {{--                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Displaying 1 to 7 of 100 entries</div>--}}
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        {!! $data->appends(request()->query())->links('pagination::bootstrap-5') !!}
                                        {{--                                        <li>--}}
                                        {{--                                            {{ $data->links() }}--}}
                                        {{--                                        </li>--}}
                                        {{--                                        <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a aria-controls="DataTables_Table_0" aria-disabled="true" aria-role="link"--}}
                                        {{--                                                                                                                                    data-dt-idx="previous" tabindex="0" class="page-link">Previous</a></li>--}}
                                        {{--                                        <li class="paginate_button page-item active"><a href="#" aria-controls="DataTables_Table_0" aria-role="link" aria-current="page" data-dt-idx="0" tabindex="0"--}}
                                        {{--                                                                                        class="page-link">1</a></li>--}}
                                        {{--                                        <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="1" tabindex="0" class="page-link">2</a></li>--}}
                                        {{--                                        <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="2" tabindex="0" class="page-link">3</a></li>--}}
                                        {{--                                        <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="3" tabindex="0" class="page-link">4</a></li>--}}
                                        {{--                                        <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="4" tabindex="0" class="page-link">5</a></li>--}}
                                        {{--                                        <li class="paginate_button page-item disabled" id="DataTables_Table_0_ellipsis"><a aria-controls="DataTables_Table_0" aria-disabled="true" aria-role="link" data-dt-idx="ellipsis"--}}
                                        {{--                                                                                                                           tabindex="0" class="page-link">…</a></li>--}}
                                        {{--                                        <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="14" tabindex="0" class="page-link">15</a></li>--}}
                                        {{--                                        <li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="next" tabindex="0"--}}
                                        {{--                                                                                                                   class="page-link">Next</a>--}}
                                        {{--                                        </li>--}}
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
                        <form class="ecommerce-customer-add pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="eCommerceCustomerAddForm" onsubmit="return false" novalidate="novalidate">
                            <div class="ecommerce-customer-add-basic mb-3">
                                <h6 class="mb-3">Basic Information</h6>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="ecommerce-customer-add-name">Name*</label>
                                    <input type="text" class="form-control" id="ecommerce-customer-add-name" placeholder="John Doe" name="customerName" aria-label="John Doe">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="mb-3 fv-plugins-icon-container">
                                    <label class="form-label" for="ecommerce-customer-add-email">Email*</label>
                                    <input type="text" id="ecommerce-customer-add-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="customerEmail">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div>
                                    <label class="form-label" for="ecommerce-customer-add-contact">Mobile</label>
                                    <input type="text" id="ecommerce-customer-add-contact" class="form-control phone-mask" placeholder="+(123) 456-7890" aria-label="+(123) 456-7890" name="customerContact">
                                </div>
                            </div>

                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">
                                <h6 class="mb-3">Shipping Information</h6>
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-customer-add-address">Address Line 1</label>
                                    <input type="text" id="ecommerce-customer-add-address" class="form-control" placeholder="45 Roker Terrace" aria-label="45 Roker Terrace" name="customerAddress1">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-customer-add-address-2">Address Line 2</label>
                                    <input type="text" id="ecommerce-customer-add-address-2" class="form-control" aria-label="address2" name="customerAddress2">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-customer-add-town">Town</label>
                                    <input type="text" id="ecommerce-customer-add-town" class="form-control" placeholder="New York" aria-label="New York" name="customerTown">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label" for="ecommerce-customer-add-state">State / Province</label>
                                        <input type="text" id="ecommerce-customer-add-state" class="form-control" placeholder="Southern tip" aria-label="Southern tip" name="customerState">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label" for="ecommerce-customer-add-post-code">Post Code</label>
                                        <input type="text" id="ecommerce-customer-add-post-code" class="form-control" placeholder="734990" aria-label="734990" name="pin" pattern="[0-9]{8}" maxlength="8">
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label" for="ecommerce-customer-add-country">Country</label>
                                    <div class="position-relative"><select id="ecommerce-customer-add-country" class="select2 form-select select2-hidden-accessible" data-select2-id="ecommerce-customer-add-country"
                                                                           tabindex="-1" aria-hidden="true">
                                            <option value="" data-select2-id="2">Select</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Canada">Canada</option>
                                            <option value="China">China</option>
                                            <option value="France">France</option>
                                            <option value="Germany">Germany</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Korea">Korea, Republic of</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Philippines">Philippines</option>
                                            <option value="Russia">Russian Federation</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 352px;"><span class="selection"><span
                                                    class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                                    aria-labelledby="select2-ecommerce-customer-add-country-container"><span class="select2-selection__rendered" id="select2-ecommerce-customer-add-country-container"
                                                                                                                             role="textbox" aria-readonly="true"><span
                                                            class="select2-selection__placeholder">United States </span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                                </div>
                            </div>

                            <div class="d-sm-flex mb-3 pt-3">
                                <div class="me-auto mb-2 mb-md-0">
                                    <h6 class="mb-0">Use as a billing address?</h6>
                                    <small class="text-muted">If you need more info, please check budget.</small>
                                </div>
                                <label class="switch m-auto pe-2">
                                    <input type="checkbox" class="switch-input">
                                    <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                          </span>
                                </label>
                            </div>
                            <div class="pt-3">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light">Add</button>
                                <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Discard</button>
                            </div>
                            <input type="hidden"></form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <!-- Footer -->
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
