@extends('layouts.default')

@section('content')

<div class="wrapper wrapper-content">
    <div class="row">
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <span class="label label-success float-right">Monthly</span>
                            <h5>Income</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">40 886,200</h1>
                            <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                            <small>Total income</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <span class="label label-info float-right">Annual</span>
                            <h5>Orders</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">275,800</h1>
                            <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                            <small>New orders</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <span class="label label-primary float-right">Today</span>
                            <h5>visits</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">106,120</h1>
                            <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                            <small>New visits</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <span class="label label-danger float-right">Low value</span>
                            <h5>User activity</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">80,600</h1>
                            <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                            <small>In first month</small>
                        </div>
                    </div>
                </div>
    </div>
    <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Orders</h5>
                            <div class="float-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-white active">Today</button>
                                    <button type="button" class="btn btn-xs btn-white">Monthly</button>
                                    <button type="button" class="btn btn-xs btn-white">Annual</button>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                            <div class="col-lg-9">
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <ul class="stat-list">
                                    <li>
                                        <h2 class="no-margins">2,346</h2>
                                        <small>Total orders in period</small>
                                        <div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i></div>
                                        <div class="progress progress-mini">
                                            <div style="width: 48%;" class="progress-bar"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2 class="no-margins ">4,422</h2>
                                        <small>Orders in last month</small>
                                        <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
                                        <div class="progress progress-mini">
                                            <div style="width: 60%;" class="progress-bar"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2 class="no-margins ">9,180</h2>
                                        <small>Monthly income from orders</small>
                                        <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                        <div class="progress progress-mini">
                                            <div style="width: 22%;" class="progress-bar"></div>
                                        </div>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                            </div>

                        </div>
                    </div>
                </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label" for="product_name">Project Name</label>
                                            <input type="text" id="product_name" name="product_name" value="" placeholder="Project Name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="col-form-label" for="price">Name</label>
                                            <input type="text" id="price" name="price" value="" placeholder="Name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="col-form-label" for="quantity">Company</label>
                                            <input type="text" id="quantity" name="quantity" value="" placeholder="Company" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label" for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" selected="">Completed</option>
                                                <option value="0">Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">

                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Master project</td>
                                            <td>Patrick Smith</td>
                                            <td>$892,074</td>
                                            <td>Inceptos Hymenaeos Ltd</td>
                                            <td><strong>20%</strong></td>
                                            <td>Jul 14, 2015</td>
                                            <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Alpha project</td>
                                            <td>Alice Jackson</td>
                                            <td>$963,486</td>
                                            <td>Nec Euismod In Company</td>
                                            <td><strong>40%</strong></td>
                                            <td>Jul 16, 2015</td>
                                            <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
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
            </div>
    <div class="footer">
        <div class="float-right">
            10GB of <strong>250GB</strong> Free.
        </div>
        <div>
            <strong>Copyright</strong> Example Company &copy; 2014-2018
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

            <div class="tab-content">


                <div id="tab-1" class="tab-pane active">

                <div id="tab-3" class="tab-pane">

                    <div class="sidebar-title">
                        <h3><i class="fa fa-gears"></i> Settings</h3>
                        <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                    </div>

                    <div class="setings-item">
                <span>
                    Show notifications
                </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                                <label class="onoffswitch-label" for="example">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                <span>
                    Disable Chat
                </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
                                <label class="onoffswitch-label" for="example2">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                <span>
                    Enable history
                </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                                <label class="onoffswitch-label" for="example3">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                <span>
                    Show charts
                </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                                <label class="onoffswitch-label" for="example4">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                <span>
                    Offline users
                </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
                                <label class="onoffswitch-label" for="example5">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                <span>
                    Global search
                </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
                                <label class="onoffswitch-label" for="example6">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                <span>
                    Update everyday
                </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                                <label class="onoffswitch-label" for="example7">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-content">
                        <h4>Settings</h4>
                        <div class="small">
                            I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                            Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                        </div>
                    </div>

                </div>
            </div>

        </div>



    </div>
</div>
    
@endsection