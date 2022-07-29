@extends('layouts.default')

@section('content')

<div class="wrapper wrapper-content">

    {{-- GRAFIK --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Total Barang Keluar (Stock Out)</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="graph-chart">
                                <div class="graph-chart-content" id="graph-dashboard-content-out"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Total Barang Masuk (Stock In)</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="graph-chart">
                                <div class="graph-chart-content" id="graph-dashboard-content-in"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Total Barang Opname (Stock Opname)</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="graph-chart">
                                <div class="graph-chart-content" id="graph-dashboard-content-op"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="float-right">
            10GB of <strong>250GB</strong> Free.
        </div>
        <div>
            <strong>Copyright</strong> Futake Indonesia &copy; 2022 (v1.0)
        </div>
    </div>
    </div>
    <div id="right-sidebar">
        <div class="sidebar-container">
            <ul class="nav nav-tabs navs-3">
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab-3"> <i class="fa fa-gear"></i> </a>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

@section('script-custom')

<script src="https://code.highcharts.com/highcharts.js"></script>

<script text="text/javascript">
    // STOCKOUT
    var total_price_out = <?php echo json_encode($data['total_price_out']) ?>;
    var month_out = <?php echo json_encode($data['month_out']) ?>;
    // var numcheck = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total_price_out);

    // STOCKIN
    var total_product_in = <?php echo json_encode($data['total_product_in']) ?>;
    var month_in = <?php echo json_encode($data['month_in']) ?>;

    // STOCKOPNAME
    var total_product_opname = <?php echo json_encode($data['total_product_opname']) ?>;
    var month_opname = <?php echo json_encode($data['month_opname']) ?>;

    // GRAFIK STOCKOUT
    Highcharts.chart('graph-dashboard-content-out', {
        title : {
            text : 'Grafik Barang Keluar'
        },
        xAxis : {
            categories : month_out
        },
        yAxis : {
            title : {
                text : 'Nominal Pendapatan Bulanan'
            }
        },
        plotOptions : {
            series: {
                allowPointSelect : true
            },
        },
        series : [{
            name : 'Nominal Pendapatan',
            data : total_price_out
        }]
    });

    // GRAFIK STOCKIN
    Highcharts.chart('graph-dashboard-content-in', {
        title : {
            text : 'Grafik Barang Masuk'
        },
        xAxis : {
            categories : month_in
        },
        yAxis : {
            title : {
                text : 'Nominal Pendapatan Bulanan'
            }
        },
        plotOptions : {
            series: {
                allowPointSelect : true
            },
        },
        series : [{
            name : 'Nominal Pendapatan',
            data : total_product_in
        }]
    });

    // GRAFIK STOCKOPNAME
    Highcharts.chart('graph-dashboard-content-op', {
        title : {
            text : 'Grafik Pengeluaran Bulanan'
        },
        xAxis : {
            categories : month_opname
        },
        yAxis : {
            title : {
                text : 'Nominal Pendapatan Bulanan'
            }
        },
        plotOptions : {
            series: {
                allowPointSelect : true
            },
        },
        series : [{
            name : 'Nominal Pendapatan',
            data : total_product_opname
        }]
    });
</script>

@endsection
