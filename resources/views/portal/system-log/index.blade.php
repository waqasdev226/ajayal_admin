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


            <div class="card">
                <div class="card-header">
{{--                    <h5 class="card-title mb-0">Filter</h5>--}}
{{--                    <form class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0" action="{{ route('withdraw-check.index') }}" method="get">--}}

{{--                        <div class="col-md-3">--}}
{{--                                <label class="form-label" for="email">{{ __('all.investor') }}</label>--}}
{{--                                <input name="investor" type="text" class="form-control" placeholder="{{ __('all.investor') }}"  value="{{ $filter->investor }}">--}}

{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            @if(isset($filter))--}}
{{--                                <label class="form-label" for="email">{{ __('all.date_from') }}</label>--}}
{{--                                <input name="date_from" type="date" class="form-control" placeholder="{{ __('all.date_from') }}"  value="{{ $filter->date_from }}">--}}

{{--                            @else--}}
{{--                                <label class="form-label" for="email">{{ __('all.date_from') }}</label>--}}
{{--                                <input name="date_from" type="date" class="form-control" placeholder="{{ __('all.date_from') }}" >--}}

{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            @if(isset($filter))--}}
{{--                                <label class="form-label" for="email">{{ __('all.date_to') }}</label>--}}
{{--                                <input name="date_to" type="date" class="form-control" placeholder="{{ __('all.date_to') }}"  value="{{ $filter->date_to }}">--}}

{{--                            @else--}}
{{--                                <label class="form-label" for="email">{{ __('all.date_to') }}</label>--}}
{{--                                <input name="date_to" type="date" class="form-control" placeholder="{{ __('all.date_to') }}" >--}}

{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            <label class="form-label" for="status">{{ __('all.status') }}</label>--}}
{{--                            <select id="status" name="status" class="form-select text-capitalize">--}}
{{--                                <option value="-1" ></option>--}}
{{--                                <option value="0" {{ $filter->status == '0' ? 'selected' : ''}}>غير فعال</option>--}}
{{--                                <option value="1" {{ $filter->status == '1' ? 'selected' : ''}}>  فعال</option>--}}
{{--                            </select></div>--}}
{{--                        <div class="col-md-3 pt-3">--}}


{{--                            <button type="submit" class="btn  btn-primary">--}}
{{--                                {{ __('all.search') }}--}}
{{--                            </button>--}}

{{--                        </div>--}}
{{--                    </form>--}}

                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header d-flex border-top rounded-0 flex-wrap py-2">
                            <div class="me-5 ms-n2 pe-5">
{{--                                <div id="DataTables_Table_0_filter" class="dataTables_filter">--}}
{{--                                    <form action="{{ route('withdraw-check.index') }}" method="get">--}}
{{--                                        <label>--}}
{{--                                            <input name="investor" type="search" class="form-control" placeholder="{{ __('all.investor') }}" aria-controls="DataTables_Table_0">--}}
{{--                                            --}}{{--                                            <input name="issue_date" type="datetime-local" class="form-control" placeholder="Search Order" aria-controls="DataTables_Table_0">--}}
{{--                                            --}}{{--                                            <button type="submit" class="btn btn-secondary add-new btn-primary py-2"><span><i class="ti ti-plus me-0 me-sm-1 mb-1 ti-xs"></i><span class="d-none d-sm-inline-block">أضافة</span></span>--}}
{{--                                            --}}{{--                                            </button>--}}
{{--                                        </label>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
                            </div>
{{--                            <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">--}}
{{--                                <div class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">--}}

{{--                                    <div class="dt-buttons d-flex flex-wrap">--}}
{{--                                        <form action="{{ route('withdraw-check.export') }}" method="get">--}}
{{--                                        <button type="submit" class="dt-button buttons-collection  btn btn-label-secondary me-3" ><span><i class="ti ti-download me-1 ti-xs"></i>{{ __('all.export') }}</span>--}}
{{--                                        </button>--}}
{{--                                        </form>--}}
{{--                                        <button class="dt-button add-new btn btn-primary ms-2 ms-sm-0" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i--}}
{{--                                                    class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">{{ __('all.add') }}</span></span>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <table class="datatables-customers table border-top dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>action</th>
                                <th>entity_name</th>
                                <th>entity_id</th>
                                <th>description</th>
                                <th>created_by</th>
                                <th>created_at</th>
{{--                                <th>action</th>--}}
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

                                    <td class="text-sm">{{ $row->action }}</td>
                                    <td class="text-sm">{{ $row->entity_name }}</td>
                                    <td class="text-sm">{{ $row->entity_id }}</td>
                                    <td class="text-sm">{{ $row->description }}</td>
                                    <td class="text-sm">{{ $row->created_by_name }}</td>
                                    <td class="text-sm" style="direction: ltr">{{ $row->created_at }}</td>
{{--                                    <td>--}}
{{--                                        <a href="{{  route('withdraw-check.show', $row->id) }}"><i class="ti ti-eye"></i></a>--}}
{{--                                    </td>--}}

                                </tr>
                            @endforeach
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
            </div>


        </div>
        <!-- / Content -->

        <!-- Footer -->
        <!-- / Footer -->


        <div class="content-backdrop fade"></div>
    </div>
@endsection
