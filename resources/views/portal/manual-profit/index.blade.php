@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
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

            @if(session('status'))
                <div class="alert alert-success alert-dismissible mb-3" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible mb-3" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">إضافة ربح يدوي - Manual Profit Credit</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('manual-profit.store') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label" for="user_id">{{ __('all.investor') }} <span class="text-danger">*</span></label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="">-- اختر المستثمر --</option>
                                    @foreach($investors as $inv)
                                        <option value="{{ $inv->id }}" data-currency="{{ $inv->currency ?? 'IQD' }}" data-profit="{{ $inv->profit ?? 0 }}">
                                            {{ $inv->name }} - {{ $inv->phone }} (رصيد: {{ number_format((float)($inv->profit ?? 0), 2) }} {{ $inv->currency ?? 'IQD' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="amount">المبلغ <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0.01" name="amount" id="amount" class="form-control" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="currency">{{ __('all.currency') }} <span class="text-danger">*</span></label>
                                <select name="currency" id="currency" class="form-select" required>
                                    <option value="IQD">IQD - دينار عراقي</option>
                                    <option value="USD">USD - دولار أمريكي</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="note">ملاحظة (اختياري)</label>
                                <input type="text" name="note" id="note" class="form-control" placeholder="مثال: ربح شباط - February Profit" maxlength="500">
                            </div>
                            <div class="col-12 pt-3">
                                <button type="submit" class="btn btn-primary">تأكيد وإضافة الربح</button>
                                <a href="{{ route('transaction-check.index') }}" class="btn btn-label-secondary">سجل العمليات</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
