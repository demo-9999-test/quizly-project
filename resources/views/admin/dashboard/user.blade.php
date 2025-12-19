@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('main-container')

    <div class="dashboard-card">
        <!-- Breadcrumb Start -->
        <nav class="breadcrumb-main-block" aria-label="breadcrumb">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumbbar">
                        <h4 class="page-title">{{ __('Welcome to Dashboard,') }} {{ Auth::user()->name }}!</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb d-flex">
                                <li class="breadcrumb-item"><a href="{{ url('user/dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                </div>
            </div>
        </nav>
        <!-- Breadcrumb End -->
        <!-- Start Contentbar -->
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="sidebar-main-block">
                <div class="row">
                    {{-- ------------------------------------- Massage Print Code Start------------------------------------------- --}}
                    @if (session('success'))
                        <h6 class="alert alert-success">{{ session('success') }}</h6>
                    @endif
                    {{-- ------------------------------------- Massage Print Code end------------------------------------------- --}}
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="progress-block">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-9 col-md-9 col-9">
                                                    <div class="progress-heading">Total Revenue</div>
                                                    <div class="progress-dtls">
                                                        $35500
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-3">
                                                    <div class="progress-block-image mb-2">
                                                        <img src="http://localhost/futureai/futureai_livepreview/public/admin_theme/assets/images/sidebar/revenue.png" class="img-fluid" alt="Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="progress-block">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-9 col-md-9 col-9">
                                                    <div class="progress-heading">Total Orders</div>
                                                    <div class="progress-dtls">
                                                        5000
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-3">
                                                    <div class="progress-block-image mb-2">
                                                        <img src="http://localhost/futureai/futureai_livepreview/public/admin_theme/assets/images/sidebar/revenue.png" class="img-fluid" alt="Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="progress-block">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-9 col-md-9 col-9">
                                                    <div class="progress-heading">Active users</div>
                                                    <div class="progress-dtls">
                                                        10000
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-3">
                                                    <div class="progress-block-image mb-2">
                                                        <img src="http://localhost/futureai/futureai_livepreview/public/admin_theme/assets/images/sidebar/revenue.png" class="img-fluid" alt="Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="progress-block">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-9 col-md-9 col-9">
                                                    <div class="progress-heading">Cancelled Orders</div>
                                                    <div class="progress-dtls">
                                                        2000
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-3">
                                                    <div class="progress-block-image mb-2">
                                                        <img src="http://localhost/futureai/futureai_livepreview/public/admin_theme/assets/images/sidebar/revenue.png" class="img-fluid" alt="Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <div class="client-detail-block sale-block">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-6">
                                    <h5 class="dashboard-title">Overview of Sales Value</h5>
                                </div>
                                <div class="col-lg-6 col-md-6 col-6">
                                    <div class="interval-dropdown text-end">
                                        <select id="interval" class="form-select">
                                            <option value="monthly">Monthly</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5">
                        <div class="client-detail-block statics-block">
                            <h5 class="dashboard-title">Statics</h5>
                            <ul>
                                <li>
                                    <div class="statics-block">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <h6 class="stat-title">New Users</h6>
                                                <p>10</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <div id="spark1"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="statics-block">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <h6 class="stat-title">Pending Tickets</h6>
                                                <p>1000</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <div id="spark2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="statics-block">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <h6 class="stat-title">Junk Devices</h6>
                                                <p>1200</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <div id="spark3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="statics-block">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <h6 class="stat-title">Today's Messages</h6>
                                                <p>2500</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <div id="spark4"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="statics-block">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <h6 class="stat-title">Active Devices</h6>
                                                <p>8000</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <div id="spark5"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7">
                        <div class="recent-table-block client-detail-block">
                            <h5 class="dashboard-title">Recent Orders</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr class="order-list">
                                            <td width="20%"><a href="" title=""><img src="{{ asset('images/users/1703827980.jpg') }}" class="img-fluid" alt="dashboard image"></td>
                                            <td width="45%">
                                                <div class="order-name"><a href="" title="">Admin</a></div>
                                                <p>Basic</p>
                                            </td>
                                            <td width="35%" class="text-end">
                                                <div class="order-price">$10.00</div>
                                                <div class="order-time">10 Hours Ago</div>
                                            </td>
                                        </tr>
                                        <tr class="order-list">
                                            <td width="20%"><a href="" title=""><img src="{{ asset('images/users/1703827980.jpg') }}" class="img-fluid" alt="dashboard image"></td>
                                            <td width="45%">
                                                <div class="order-name"><a href="" title="">Admin</a></div>
                                                <p>Basic</p>
                                            </td>
                                            <td width="35%" class="text-end">
                                                <div class="order-price">$10.00</div>
                                                <div class="order-time">10 Hours Ago</div>
                                            </td>
                                        </tr>
                                        <tr class="order-list">
                                            <td width="20%"><a href="" title=""><img src="{{ asset('images/users/1703827980.jpg') }}" class="img-fluid" alt="dashboard image"></td>
                                            <td width="45%">
                                                <div class="order-name"><a href="" title="">Admin</a></div>
                                                <p>Basic</p>
                                            </td>
                                            <td width="35%" class="text-end">
                                                <div class="order-price">$10.00</div>
                                                <div class="order-time">10 Hours Ago</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="plan-table-block client-detail-block">
                            <h5 class="dashboard-title">Plans</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr class="table-headings">
                                            <th width="35%" colspan="2">Plan</th>
                                            <th width="20%">Active users</th>
                                            <th width="20%">Sales</th>
                                            <th width="25%">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="product-list">
                                            <td width="35%"colspan="2">Enterprise</td>
                                            <td width="20%">8000</td>
                                            <td width="20%">100</td>
                                            <td width="25%">$7500</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contentbar -->
@endsection
@section("scripts")
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Default data
        let data = {
            monthly: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                series: [
                    { name: 'Series 1', data: [30, 40, 35, 50, 49, 60, 70, 91, 125, 100, 95, 80] }
                ]
            },
            weekly: {
                labels: ["5 Feb", "12 Feb", "19 Feb", "26 Feb"],
                series: [
                    { name: 'Series 1', data: [30, 40, 35, 50] }
                ]
            },
            yearly: {
                labels: ["2020", "2021", "2022", "2023", "2024"],
                series: [
                    { name: 'Series 1', data: [100, 200, 150, 250, 300] }
                ]
            }
        };

        let options = {
            chart: {
                type: 'bar',
                height: 500,
                stacked: true,
            },
            series: data.monthly.series,
            xaxis: {
                categories: data.monthly.labels
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '20%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#196C99']
            },
            toolbar: {
                show: false
            },
            colors: ['#75E4A5'],
        };

        let chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // Event listener for dropdown change
        document.querySelector("#interval").addEventListener("change", function() {
            let interval = this.value;
            chart.updateSeries(data[interval].series);
            chart.updateOptions({
                xaxis: {
                    categories: data[interval].labels
                }
            });
        });
    });
</script>
<script>
    Apex.grid = {
        padding: {
            right: 0,
            left: 0
        }
    }

    Apex.dataLabels = {
        enabled: false
    }

    var randomizeArray = function (arg) {
        var array = arg.slice();
        var currentIndex = array.length, temporaryValue, randomIndex;

        while (0 !== currentIndex) {

            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    }

    var spark1 = {
    chart: {
        type: 'area',
        width: 100,
        height: 50,
        sparkline: {
        enabled: true
        },
        toolbar: {
            show: false
        },
    },
    stroke: {
        curve: 'smooth',
        width: 1.5
    },
    fill: {
        opacity: 1,
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.45,
            opacityTo: 0.05,
            stops: [50, 100, 100, 100]
        }
    },
    series: [{
        name: "Total Users",
        data: [85, 68, 35, 90, 8, 11, 26, 54, 10, 12]
    }],
    colors: ['#75E4A5'],

    }
    new ApexCharts(document.querySelector("#spark1"), spark1).render();


    var spark2 = {
    chart: {
        type: 'area',
        width: 100,
        height: 50,
        sparkline: {
        enabled: true
        },
        toolbar: {
            show: false
        },
    },
    stroke: {
        curve: 'smooth',
        width: 1.5
    },
    fill: {
        opacity: 1,
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.45,
            opacityTo: 0.05,
            stops: [50, 100, 100, 100]
        }
    },
    series: [{
        name: "Total Users",
        data: [10, 25, 40, 20, 10, 80, 70, 85, 90, 40]
    }],
    colors: ['#DC3545'],

    }
    new ApexCharts(document.querySelector("#spark2"), spark2).render();


    var spark3 = {
    chart: {
        type: 'area',
        width: 100,
        height: 50,
        sparkline: {
        enabled: true
        },
        toolbar: {
            show: false
        },
    },
    stroke: {
        curve: 'smooth',
        width: 1.5
    },
    fill: {
        opacity: 1,
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.45,
            opacityTo: 0.05,
            stops: [50, 100, 100, 100]
        }
    },
    series: [{
        name: "Total Users",
        data: [20, 35, 34, 48, 120, 79, 80, 158, 142, 45]
    }],
    colors: ['#75E4A5'],

    }
    new ApexCharts(document.querySelector("#spark3"), spark3).render();


    var spark4 = {
    chart: {
        type: 'area',
        width: 100,
        height: 50,
        sparkline: {
        enabled: true
        },
        toolbar: {
            show: false
        },
    },
    stroke: {
        curve: 'smooth',
        width: 1.5
    },
    fill: {
        opacity: 1,
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.45,
            opacityTo: 0.05,
            stops: [50, 100, 100, 100]
        }
    },
    series: [{
        name: "Total Users",
        data: [44, 25, 32, 38, 70, 71, 90, 100, 120, 150]
    }],
    colors: ['#75E4A5'],

    }
    new ApexCharts(document.querySelector("#spark4"), spark4).render();


    var spark5 = {
    chart: {
        type: 'area',
        width: 100,
        height: 50,
        sparkline: {
        enabled: true
        },
        toolbar: {
            show: false
        },
    },
    stroke: {
        curve: 'smooth',
        width: 1.5
    },
    fill: {
        opacity: 1,
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.45,
            opacityTo: 0.05,
            stops: [50, 100, 100, 100]
        }
    },
    series: [{
        name: "Total Users",
        data: [70, 40, 44, 25, 63, 15, 80, 90, 74, 63]
    }],
    colors: ['#75E4A5'],

    }
    new ApexCharts(document.querySelector("#spark5"), spark5).render();
</script>
@endsection
