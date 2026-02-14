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

            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
                <div class="mb-2 mb-sm-0">
                    <h4 class="mb-1">
                        {{__('all.investor')}} #{{ $data->reference }}
                    </h4>
                    <p class="mb-0" style="direction: ltr">
                        {{ $data->created_at }}
                    </p>
                </div>
                <button type="button" class="btn btn-label-danger delete-customer waves-effect" onclick="window.location='{{ route('investor.cancelContract', $data->id) }}'"><i class="ti ti-folder-cancel me-1"></i>الغاء العقد</button>
            </div>


            <div class="row">
                <!-- Customer-detail Sidebar -->
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- Customer-detail Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="customer-avatar-section">
                                <div class="d-flex align-items-center flex-column">
{{--                                    <img class="img-fluid rounded my-3" src="../../assets/img/avatars/15.png" height="110" width="110" alt="User avatar">--}}
                                    <div class="customer-info text-center">
                                        <h4 class="mb-1">{{ $data->name }}</h4>
                                        <small>{{__('all.investor')}} #{{ $data->reference }}</small>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="d-flex justify-content-around flex-wrap my-4">--}}
{{--                                <div class="d-flex align-items-center gap-2">--}}
{{--                                    <div class="avatar">--}}
{{--                                        <div class="avatar-initial rounded bg-label-primary">--}}
{{--                                            <i class="ti ti-shopping-cart ti-md"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="gap-0 d-flex flex-column">--}}
{{--                                        <p class="mb-0 fw-medium">184</p>--}}
{{--                                        <small>Orders</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="d-flex align-items-center gap-2">--}}
{{--                                    <div class="avatar">--}}
{{--                                        <div class="avatar-initial rounded bg-label-primary">--}}
{{--                                            <i class="ti ti-currency-dollar ti-md"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="gap-0 d-flex flex-column">--}}
{{--                                        <p class="mb-0 fw-medium">$12,378</p>--}}
{{--                                        <small>Spent</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="info-container">
                                <small class="d-block pt-4 border-top fw-normal text-uppercase text-muted my-3">{{__('all.details')}}</small>
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">{{__('all.name')}}:</span>
                                        <span>{{ $data->name }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">{{__('all.email')}}:</span>
                                        <span>{{ $data->email }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">{{__('all.status')}}:</span>
                                        @if($data->enabled == 1)
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-danger">Inactive</span>
                                        @endif
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">{{__('all.phone')}}:</span>
                                        <span>{{ $data->phone }}</span>
                                    </li>

                                </ul>
                                <div class="d-flex justify-content-center">
                                    <a href="javascript:;" class="btn btn-primary block me-3 waves-effect waves-light" data-bs-target="#editUser" data-bs-toggle="modal">تعديل التفاصيل</a>

                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    @if(!is_null($data->document_type))
                                        @if($data->document_type == 'جواز السفر')
                                            <a href="{{ url('/') . $data->id_front_image }}" class="btn btn-success me-3 waves-effect waves-light" target="_blank">صورة جواز السفر</a>
                                        @else
                                            <a href="{{ env('APP_API') . $data->id_front_image }}" class="btn btn-success me-3 waves-effect waves-light" target="_blank">صورة امامية للهوية</a>
                                            <a href="{{ env('APP_API') . $data->id_back_image }}" class="btn btn-success me-3 waves-effect waves-light" target="_blank">صورة خلفية للهوية</a>

                                        @endif

                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Customer-detail Card -->
                    <!-- Plan Card -->

{{--                    <div class="card mb-4 bg-gradient-primary">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row justify-content-between mb-3">--}}
{{--                                <div class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1  order-lg-0 order-xl-1 order-xxl-0">--}}
{{--                                    <h4 class="card-title text-white text-nowrap">Upgrade to premium</h4>--}}
{{--                                    <p class="card-text text-white">Upgrade customer to premium membership to access pro features.</p>--}}
{{--                                </div>--}}
{{--                                <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"><img src="../../assets/img/illustrations/rocket.png" class="w-px-75 m-2" alt="3dRocket"></span>--}}
{{--                            </div>--}}
{{--                            <button class="btn btn-white text-primary w-100 fw-medium shadow-md waves-effect waves-light" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">Upgrade to premium</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <!-- /Plan Card -->
                </div>
                <!--/ Customer Sidebar -->


                <!-- Customer Content -->
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <!-- Customer Pills -->
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item"><a class="nav-link py-2 {{ Route::current()->getName() ==  'investor.showGeneral' ? 'active' : '' }}" href="{{ route('investor.showGeneral', $data->id) }}"><i class="ti ti-user me-1"></i>{{ __('all.general') }}</a></li>
                        <li class="nav-item"><a class="nav-link py-2 {{ Route::current()->getName() ==  'investor.showProfit' ? 'active' : '' }}" href="{{ route('investor.showProfit', $data->id) }}"><i class="ti ti-lock me-1"></i>{{ __('all.profit') }}</a></li>
                        <li class="nav-item"><a class="nav-link py-2 {{ Route::current()->getName() ==  'investor.showWithdraw' ? 'active' : '' }}" href="{{ route('investor.showWithdraw', $data->id) }}"><i class="ti ti-file-invoice me-1"></i>{{ __('all.withdraw') }}</a></li>
                    </ul>
                    <!--/ Customer Pills -->

                    <!--/ Investor Detail Route -->
                    @yield('investor_detail')
                    <!--/ Investor Detail Route -->


                </div>
                <!--/ Customer Content -->
            </div>

            <!-- Modal -->
            <!-- Edit User Modal -->
            <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="text-center mb-4">
                                <h3 class="mb-2">{{__('all.edit')}} {{__('all.investor')}}</h3>
                                {{--                                <p class="text-muted">Updating user details will receive a privacy audit.</p>--}}
                            </div>
                            <form id="editUserForm" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('investor.update', $data->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-12 fv-plugins-icon-container">
                                    <label class="form-label" for="name">{{__('all.name')}}</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{$data->name}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-6 fv-plugins-icon-container">
                                    <label class="form-label" for="name">{{__('all.phone')}}</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{$data->phone}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-6 fv-plugins-icon-container">
                                    <label class="form-label" for="name">{{__('all.reference')}}</label>
                                    <input type="text" id="reference" name="reference" class="form-control" value="{{$data->reference}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" value="{{$data->email}}">
                                </div>
                                <div class="col-12 col-md-6 fv-plugins-icon-container">
                                    <label class="form-label" for="city">{{__('all.city')}}</label>
                                    <select id="ecommerce-customer-add-country" class="select2 form-select select2-hidden-accessible" data-select2-id="ecommerce-customer-add-country"
                                            tabindex="-1" aria-hidden="true" name="city">
                                        <option value="" >Select</option>
                                        <option value="Dhi Qar" {{ $data->city == 'Dhi Qar' ? 'selected' : ''}}>Dhi Qar</option>
                                        <option value="Babylon" {{ $data->city == 'Babylon' ? 'selected' : ''}}>Babylon</option>
                                        <option value="Al-Qādisiyyah" {{ $data->city == 'Al-Qādisiyyah' ? 'selected' : ''}}>Al-Qādisiyyah</option>
                                        <option value="Karbala" {{ $data->city == 'Karbala' ? 'selected' : ''}}>Karbala</option>
                                        <option value="Al Muthanna" {{ $data->city == 'Al Muthanna' ? 'selected' : ''}}>Al Muthanna</option>
                                        <option value="Baghdad" {{ $data->city == 'Baghdad' ? 'selected' : ''}}>Baghdad</option>
                                        <option value="Basra" {{ $data->city == 'Basra' ? 'selected' : ''}}>Basra</option>
                                        <option value="Saladin" {{ $data->city == 'Saladin' ? 'selected' : ''}}>Saladin</option>
                                        <option value="Najaf" {{ $data->city == 'Najaf' ? 'selected' : ''}}>Najaf</option>
                                        <option value="Nineveh" {{ $data->city == 'Nineveh' ? 'selected' : ''}}>Nineveh</option>
                                        <option value="Al Anbar" {{ $data->city == 'Al Anbar' ? 'selected' : ''}}>Al Anbar</option>
                                        <option value="Diyala" {{ $data->city == 'Diyala' ? 'selected' : ''}}>Diyala</option>
                                        <option value="Maysan" {{ $data->city == 'Maysan' ? 'selected' : ''}}>Maysan</option>
                                        <option value="Dohuk" {{ $data->city == 'Dohuk' ? 'selected' : ''}}>Dohuk</option>
                                        <option value="Erbil" {{ $data->city == 'Erbil' ? 'selected' : ''}}>Erbil</option>
                                        <option value="Sulaymaniyah" {{ $data->city == 'Sulaymaniyah' ? 'selected' : ''}}>Sulaymaniyah</option>
                                        <option value="Wasit" {{ $data->city == 'Wasit' ? 'selected' : ''}}>Wasit</option>
                                        <option value="Kirkuk" {{ $data->city == 'Kirkuk' ? 'selected' : ''}}>Kirkuk</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6 fv-plugins-icon-container">
                                    <label class="form-label" for="name">{{__('all.cash')}}</label>
                                    @if($data->cash == 0)
                                        <input type="number" id="cash" name="cash" class="form-control" value="{{$data->cash}}">
                                    @else
                                        <input type="number" id="cash" name="cash" class="form-control" value="{{$data->cash}}" style="pointer-events: none;background-color:#E9ECEF">

                                    @endif
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserStatus">{{__('all.currency')}}</label>
                                    <div class="position-relative">
                                        @if($data->currency == null)
                                            <select id="modalEditUserStatus" name="currency" class="select2 form-select select2-hidden-accessible" aria-label="Default select example"
                                                    data-select2-id="modalEditUserStatus" tabindex="-1" aria-hidden="true" data-value="{{$data->currency}}">
                                                <option value="IQD" {{ $data->currency == 'IQDّ' ? 'selected' : ''}}>IQD</option>
                                                <option value="USD" {{ $data->currency == 'USD' ? 'selected' : ''}}>USD</option>
                                            </select>
                                        @else
                                            <input type="text" id="currency" name="currency" class="form-control" value="{{$data->currency}}" style="pointer-events: none;background-color:#E9ECEF">

                                        @endif

                                    </div>
                                </div>
                                <div class="col-12 col-md-6 fv-plugins-icon-container">
                                    <label class="form-label" for="name">{{__('all.min_ratio')}}</label>
                                    <input type="number" id="min_ratio" name="min_ratio" class="form-control" value="{{$data->min_ratio}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-6 fv-plugins-icon-container">
                                    <label class="form-label" for="name">{{__('all.max_ratio')}}</label>
                                    <input type="number" id="max_ratio" name="max_ratio" class="form-control" value="{{$data->max_ratio}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-4 fv-plugins-icon-container">
                                    <label class="form-label" for="expire_contract">{{__('all.expire_contract')}}</label>
                                    <input type="date" id="expire_contract" name="expire_contract" class="form-control" value="{{$data->expire_contract}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="modalEditUserStatus">{{__('all.status')}}</label>
                                    <div class="position-relative">
                                        <select id="modalEditUserStatus" name="enabled" class="select2 form-select select2-hidden-accessible" aria-label="Default select example"
                                                data-select2-id="modalEditUserStatus" tabindex="-1" aria-hidden="true" data-value="{{$data->enabled}}">
                                            <option value="1" {{ $data->enabled == 1 ? 'selected' : ''}}>فعال</option>
                                            <option value="0" {{ $data->enabled == 0 ? 'selected' : ''}}>غير فعال</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 fv-plugins-icon-container">
                                    <label class="form-label" for="insurance">{{__('all.insurance')}}</label>
                                    <div class="position-relative">
                                        <select id="modalEditUserStatus" name="insurance" class="select2 form-select select2-hidden-accessible" aria-label="Default select example"
                                                data-select2-id="modalEditUserStatus" tabindex="-1" aria-hidden="true" data-value="{{$data->insurance}}">
                                            <option value="1" {{ $data->insurance == 1 ? 'selected' : ''}}>فعال</option>
                                            <option value="0" {{ $data->insurance == 0 ? 'selected' : ''}}>غير فعال</option>
                                        </select>
                                    </div>
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-4 fv-plugins-icon-container">
                                    <label class="form-label" for="wdr_method">{{__('all.wdr_method')}}</label>
                                    <div class="position-relative">
                                        <select id="wdr_method" name="wdr_method" class="select2 form-select select2-hidden-accessible" aria-label="Default select example"
                                                data-select2-id="modalEditUserStatus" tabindex="-1" aria-hidden="true" data-value="{{$data->wdr_method}}"

                                        >
                                            <option value="western_union" {{ $data->wdr_method == 'western_union' ? 'selected' : ''}}>western_union</option>
                                            <option value="bank_account" {{ $data->wdr_method == 'bank_account' ? 'selected' : ''}}>bank_account</option>
                                            <option value="credit" {{ $data->wdr_method == 'credit' ? 'selected' : ''}}>credit</option>
                                            <option value="zaincash" {{ $data->wdr_method == 'zaincash' ? 'selected' : ''}}>zaincash</option>
                                        </select>
                                    </div>
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-8 fv-plugins-icon-container" id="wdr_name_field">
                                    <label class="form-label" for="contract_ref">{{__('all.contract_ref')}}</label>
                                    <input type="text" id="contract_ref" name="contract_ref" class="form-control" value="{{$data->contract_ref}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>

                                <hr class="my-4 mx-n4">
                                <h6>{{__('all.files')}} </h6>
                                <div class="col-12 col-md-4 fv-plugins-icon-container" id="document_type">
                                    <label class="form-label" for="document_type">{{__('all.document_type')}}</label>
                                    <select id="document_type" name="document_type" class="select2 form-select select2-hidden-accessible" aria-label="Default select example"
                                            data-select2-id="document_type" tabindex="-1" aria-hidden="true" data-value="{{$data->document_type}}"

                                    >
                                        <option value="جواز السفر" {{ $data->document_type == 'جواز السفر' ? 'selected' : ''}}>جواز السفر</option>
                                        <option value="الهوية الوطنية" {{ $data->document_type == 'الهوية الوطنية' ? 'selected' : ''}}>الهوية الوطنية</option>

                                    </select>
                                </div>
                                <div class="col-12 col-md-4 fv-plugins-icon-container" id="id_front_image">
                                    <label class="form-label" for="id_front_image">{{__('all.id_front_image')}}</label>
                                    <input type="file" id="id_front_image" name="id_front_image" class="form-control">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-4 fv-plugins-icon-container" id="id_back_image">
                                    <label class="form-label" for="id_back_image">{{__('all.id_back_image')}}</label>
                                    <input type="file" id="id_back_image" name="id_back_image" class="form-control">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>

                                <hr class="my-4 mx-n4">
                                <h6>{{__('all.wdr_method')}}: western_union </h6>
                                <div class="col-12 col-md-6 fv-plugins-icon-container" id="wdr_passport_field">
                                    <label class="form-label" for="wdr_passport">{{__('all.wdr_passport')}}</label>
                                    <input type="text" id="wdr_passport" name="wdr_passport" class="form-control" value="{{$data->wdr_passport}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-6 fv-plugins-icon-container" id="wdr_name_field">
                                    <label class="form-label" for="wdr_name">{{__('all.wdr_name')}}</label>
                                    <input type="text" id="wdr_name" name="wdr_name" class="form-control" value="{{$data->wdr_name}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <hr class="my-4 mx-n4">
                                <h6>{{__('all.wdr_method')}}: bank_account </h6>
                                <div class="col-12 col-md-6 fv-plugins-icon-container" id="wdr_bank_account_field">
                                    <label class="form-label" for="wdr_bank_account">{{__('all.wdr_bank_account')}}</label>
                                    <input type="text" id="wdr_bank_account" name="wdr_bank_account" class="form-control" value="{{$data->wdr_bank_account}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="col-12 col-md-6 fv-plugins-icon-container" id="wdr_swift_field">
                                    <label class="form-label" for="wdr_swift">{{__('all.wdr_swift')}}</label>
                                    <input type="text" id="wdr_swift" name="wdr_swift" class="form-control" value="{{$data->wdr_swift}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <hr class="my-4 mx-n4">
                                <h6>{{__('all.wdr_method')}}: credit </h6>
                                <div class="col-12 col-md-6 fv-plugins-icon-container" id="wdr_card_no_field">
                                    <label class="form-label" for="wdr_card_no">{{__('all.wdr_card_no')}}</label>
                                    <input type="text" id="wdr_card_no" name="wdr_card_no" class="form-control" value="{{$data->wdr_card_no}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <hr class="my-4 mx-n4">
                                <h6>{{__('all.wdr_method')}}: zaincash </h6>
                                <div class="col-12 col-md-6 fv-plugins-icon-container" id="wdr_phone_field">
                                    <label class="form-label" for="wdr_phone">{{__('all.wdr_phone')}}</label>
                                    <input type="text" id="wdr_phone" name="wdr_phone" class="form-control" value="{{$data->wdr_phone}}">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>










                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">{{ __('all.submit') }}</button>
                                    <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">{{ __('all.cancel') }}</button>
                                </div>
                                <input type="hidden">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Edit User Modal -->

            <!-- Add New Credit Card Modal -->
            <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="text-center mb-4">
                                <h3 class="mb-2">Upgrade Plan</h3>
                                <p>Choose the best plan for user.</p>
                            </div>
                            <form id="upgradePlanForm" class="row g-3" onsubmit="return false">
                                <div class="col-sm-8">
                                    <label class="form-label" for="choosePlan">Choose Plan</label>
                                    <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                                        <option selected="">Choose Plan</option>
                                        <option value="standard">Standard - $99/month</option>
                                        <option value="exclusive">Exclusive - $249/month</option>
                                        <option value="Enterprise">Enterprise - $499/month</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Upgrade</button>
                                </div>
                            </form>
                        </div>
                        <hr class="mx-md-n5 mx-n3">
                        <div class="modal-body">
                            <p class="mb-0">User current plan is standard plan</p>
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="d-flex justify-content-center me-2">
                                    <sup class="h6 pricing-currency pt-1 mt-3 mb-0 me-1 text-primary">$</sup>
                                    <h1 class="display-5 mb-0 text-primary">99</h1>
                                    <sub class="h5 pricing-duration mt-auto mb-2 text-muted">/month</sub>
                                </div>
                                <button class="btn btn-label-danger cancel-subscription mt-3 waves-effect">Cancel Subscription</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Add New Credit Card Modal -->

            <!-- /Modal -->

        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
    </div>
@endsection
