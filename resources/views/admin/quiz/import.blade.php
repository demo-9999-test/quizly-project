@extends('admin.layouts.master')
@section('title', 'Quiz Import')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Quiz ') }}
    @endslot
    @slot('menu1')
    {{ __('Quiz ') }}
    @endslot
    @slot('menu2')
    {{ __('Import ') }}
    @endslot

    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('quiz.index') }}" class="btn btn-primary"><i class="flaticon-back"
                    title="{{ __('Back') }}"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <div class="contentbar user-import-block">
        @include('admin.layouts.flash_msg')
        <div class="client-detail-block mb-4">
            <div class="row">
                <div class="col-lg-9 col-md-8">
                    <h5> {{ __('Import Quiz') }}</h5>
                </div>
                <div class="col-lg-3 col-md-4">
                    <button onclick="downloadQuizCSV()" class="btn btn-primary float-lg-end float-md-end float-sm-start"
                        title=" {{ __('Download Demo CSV') }}">
                        {{ __('Download Demo CSV') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <form action="{{route('quiz.importSave')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <h5 class="block-heading"> {{ __('Import') }}</h5>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-5">
                                    <label for="" class="form-label"> {{ __('Select CSV File :') }}</label>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <input class="form-control" type="file" name="file" accept=".csv" required>
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="user-import-submit-btn">
                                                <button type="submit" title=" {{ __('Submit') }}"
                                                    class="btn btn-primary">{{ __('Submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        
                        <!--  Table start-->
                        <table class="table data-table display nowrap" id="example">
                            <thead>
                                <tr>
                                    <th>{{ __('Column No') }}</th>
                                    <th>{{ __(' Column Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><strong>{{ __('name') }}</strong> (Required)</td>
                                    <td>{{ __('name') }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><strong>{{ __('description') }}</strong> (Required)</td>
                                    <td>{{ __('description') }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><strong>{{ __('timer') }}</strong> (Required)</td>
                                    <td> {{ __('timer') }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><strong>{{ __('start date') }}</strong> (Required)</td>
                                    <td>{{ __('start date') }}</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td><strong>{{ __('ebd date') }}</strong> (Required)</td>
                                    <td>{{ __('end date') }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td><strong>{{ __('status') }}</strong> (Required)</td>
                                    <td>{{ __('status') }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td><strong> {{ __('reattempt') }}</strong> (Required)</td>
                                    <td> {{ __('reattempt') }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td><strong> {{ __('type') }}</strong> (Required)</td>
                                    <td> {{ __('type') }}</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td><strong> {{ __('subject') }}</strong> (Required)</td>
                                    <td> {{ __('subject') }}</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td><strong>{{ __('service') }}</strong> (Required)</td>
                                    <td>{{ __('service') }}</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td><strong>{{ __('order') }}</strong> (Required)</td>
                                    <td>{{ __('order') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- --------- Table end-------------------------- --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function downloadQuizCSV() {
        const csvContent =
            'name,description,timer,status,reattempt,type,subject,start_date,end_date,question_order,service';
        const blob = new Blob([csvContent], {
            type: 'text/csv'
        });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'quiz.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
