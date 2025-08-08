@can('Analytics Dashboard')
@extends('layouts.master')

@section('title', __("Graphical Dashboard"))

@section('content')

<style>
    .custom-card {
        border-radius: 0.4rem;
        position: relative;
        margin-block-end: 1.5rem;
        width: 100%;
        max-height: 145px !important;
    }

    .max-145-height {
        max-height: 145px !important;
    }
</style>

<div class="card mb-5">
    <div class="card-header">
        <h1 class="card-title"><span class='text-danger'>Welcome</span> <span class='text-primary'>{{ auth()->user()->name }},</span></h1>
    </div>


    <div class="card-body">
        <form method="GET" action="{{ route('graphical.dashboard') }}">
                <div class="d-flex gap-3 flex-wrap align-items-end justify-content-end mb-4">
                    @if (auth()->user()->id == 1)
                    <div style="width: 20%;">
                        <label>Select User</label>
                        <select name="user_id" class="form-control">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request()->get('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div style="width: 20%;">
                        <label>Select Range</label>
                        <select name="range" id="rangeSelect" class="form-control">
                            <option value="today" {{$range == 'today' ? 'selected' : '' }}>Today's</option>
                            <option value="3" {{$range == '3' ? 'selected' : '' }}>Last 3 Days</option>
                            <option value="7" {{$range == '7' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="15" {{$range == '15' ? 'selected' : '' }}>Last 15 Days</option>
                            <option value="30" {{$range == '30' ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="60" {{$range == '60' ? 'selected' : '' }}>Last 60 Days</option>
                            <option value="90" {{$range == '90' ? 'selected' : '' }}>Last 90 Days</option>
                            <option value="all" {{$range == 'all' ? 'selected' : '' }}>All Time</option>
                            <option value="custom" {{$range == 'custom' ? 'selected' : '' }}>Custom Date</option>
                        </select>
                    </div>
                    <div style="width: 20%;" id="fromDateDiv" class="{{ request()->get('range') == 'custom' ? '' : 'd-none' }}">
                        <label>From Date</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request()->get('from_date') }}">
                    </div>
                    <div style="width: 20%;" id="toDateDiv" class="{{ request()->get('range') == 'custom' ? '' : 'd-none' }}">
                        <label>To Date</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request()->get('to_date') }}">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
            </div>
        </form>

        <h2 class="card-title">Progress Lifeline</h2>
        <div style="display: flex; width: 100%; align-items: center;">
            <div style="width: 88%; height: 20px; display: flex; overflow: hidden; border-radius: 5px;     background: linear-gradient(135deg, #d3d0d0, #828488);">
                @foreach ($filledSegments as $segment)
                    <div style="width: {{ $segment['width'] }}%; background-color: {{ $segment['color'] }}; position: relative;">
                        <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 12px; font-weight: bold; width:100%;text-align:center;">
                            {{ $segment['label'] }} ({{ $segment['percentage'] }}%)
                        </div>
                    </div>
                @endforeach
            </div>
            
            @php
                $colorMap = [
                    'POOR' => 'red',
                    'SAFE ZONE' => 'orange',
                    'AVERAGE' => '#CCCC00',
                    'GOOD' => 'green',
                    'Excellent' => 'blue',
                ];
            @endphp

            <div style="width: 12%; padding-left: 10px; font-size: 14px;">
                <div><strong class='d-flex align-items-center'>Performace: <span style="background-color: {{ $colorMap[$currentZone] ?? 'black' }};padding: 5px;color: white;margin-left: 3px;">{{ $currentZone }}</span></strong> </div>
                <div><strong>Total work:</strong> {{ $createdEditedCount }}</div>
            </div>
        </div>

        <div style="position: relative; width: 88%; margin-top: 10px;">
            <div style="position: absolute; left: 0%; transform: translateX(-50%); font-size: 12px; text-align: center;">
                <span style="margin-left:22px">0</span>
            </div>
            
            @foreach ($categories as $category)
                <div style="position: absolute; left: {{ $category['width'] }}%; transform: translateX(-50%); font-size: 12px; text-align: center;">
                    <span style="position: absolute;bottom: 45px;"> | </span>
                    {{ $category['limit'] * $totalDays }}</span>
                </div>
            @endforeach
        </div>

        @if ($cardTotals)
            <div class="row" style="margin-top: 60px;">
                <div class="col-md-3 mb-4">
                    <div class="card text-white shadow-sm rounded-4 h-100 hover-shadow custom-card" style="background: linear-gradient(135deg, #6c5ffc, #0056b3);box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);border-radius: 10px;">
                        <div class="card-body text-center">
                            <i class="fa fa-plus-circle" style="font-size: 40px;margin-bottom: 10px;"></i>
                            <h6 class="text-uppercase">New Created + Updated</h6>
                            <h2 class="fw-bold">{{ $cardTotals['created'] }}</h2>
                        </div>
                    </div>
                </div>
                

                <div class="col-md-3 mb-4">
                    <div class="card text-white shadow-sm rounded-4 h-100 hover-shadow custom-card" style="background: linear-gradient(135deg, #e82646, #0056b3);box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);border-radius: 10px;">
                        <div class="card-body text-center">
                            <i class="fa fa-times-circle" style="font-size: 40px;margin-bottom: 10px;"></i>
                            <h6 class="text-uppercase">Rejected</h6>
                            <h2 class="fw-bold">{{ $cardTotals['rejected'] }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card text-white shadow-sm rounded-4 h-100 hover-shadow custom-card" style="background: linear-gradient(135deg, #f7b731, #0056b3);box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);border-radius: 10px;">
                        <div class="card-body text-center">
                            <i class="fa fa-trash" style="font-size: 40px;margin-bottom: 10px;"></i>
                            <h6 class="text-uppercase">Deleted</h6>
                            <h2 class="fw-bold">{{ $cardTotals['deleted'] }}</h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card text-white shadow-sm rounded-4 h-100 hover-shadow custom-card" style="background: linear-gradient(135deg, #09ad95, #0056b3);box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);border-radius: 10px;">
                        <div class="card-body text-center">
                            <i class="fa fa-check-circle" style="font-size: 40px;margin-bottom: 10px;"></i>
                            <h6 class="text-uppercase">Approved (All)</h6>
                            <h2 class="fw-bold">{{ $cardTotals['approved'] }}</h2>
                        </div>
                    </div>
                </div>
                

                <div class="col-md-2 mb-4 max-145-height">
                    <div class="card text-white h-100" style="background: linear-gradient(135deg, #1170e4, #0056b3);box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);border-radius: 10px;">
                        <div class="card-body text-center">
                            <h5> Total Created</h5>
                            <h2>{{ $createdCount }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 mb-4 max-145-height">
                    <div class="card text-white h-100" style="background: linear-gradient(135deg, #05c3fb, #0056b3);box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);border-radius: 10px;">
                        <div class="card-body text-center">
                            <h5> Total Updated</h5>
                            <h2>{{ $editedCount }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 mb-4 max-145-height">
                    <div class="card bg-dark text-white h-100" style="background: linear-gradient(135deg, #343a40, #0056b3);box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);border-radius: 10px;">
                        <div class="card-body text-center">
                            <h5>Work Report <br> (Created + Updated)</h5>
                            <h2>{{ $sumOfBoth }}</h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2 mb-4 max-145-height">
                    <div class="card text-white h-100" style="background: linear-gradient(135deg, #007bff, #0056b3); box-shadow: 0 4px 10px rgba(0,0,0,0.2); border-radius: 10px;">
                        <div class="card-body d-flex flex-column justify-content-between text-center position-relative pb-0">
                            <div>
                                <h5 class="mb-2">This Week (All) <br> (Monday to Sunday)</h5>
                                <h3><strong>{{ $currentWeekDataCreated }}</strong></h3>
                            </div>
                        </div>
                        @if($currentWeekDataCreated <= 120)
                            <span class="badge-status text-center" style="background-color: red;">AT RISK</span>
                        @elseif($currentWeekDataCreated <= 149)
                            <span class="badge-status text-center" style="background-color: orange;">REVIEW</span>
                        @elseif($currentWeekDataCreated <= 199)
                            <span class="badge-status text-center" style="background-color: yellow;">AVERAGE</span>
                        @elseif($currentWeekDataCreated <= 349)
                            <span class="badge-status text-center" style="background-color: lightgreen;">GOOD</span>
                        @else
                            <span class="badge-status text-center" style="background-color: green;">EXCELLENT</span>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-2 mb-4 max-145-height">
                    <div class="card bg-light h-100 text-dark" style="background: linear-gradient(135deg, #ccc, yellow);">
                        <div class="card-body text-center">
                            <i class="fa fa-money fa-2x text-primary mb-2"></i>
                            <h5>Value Added</h5>
                            <h2>₹ {{ $expectedEarning }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 mb-4 max-145-height">
                    <div class="card bg-light h-100 text-dark" style="background: linear-gradient(135deg, pink, yellow);">
                        <div class="card-body text-center">
                            <i class="fa fa-calendar fa-2x text-primary mb-2"></i>
                            <h5>Account Age (Days)</h5>
                            <h2>{{ $daysSinceCreation }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Graphical Representations</h2>
    </div>
  <div class="card-body p-4">
      <h4 class='text-center'><b class='text-uppercase'><u><span style='font-size:30px;'>Performance Metrics</span> <br> (Your Performace V/S Top Performer)</u></b></h4>
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-center">Your Work Overview</h5>
            @if($graphTotals)
              <div style="position: relative;text-align: center;;">
                <canvas id="barChart"  style="max-width: 7000px; height: 700px"></canvas>
                
                <h4 class='mt-4'><u>Your Listing Reports</u></h4>
              </div>
            @else
              <p class="text-muted text-center">Please select a user to see data.</p>
            @endif
          </div>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-center">Top Performer Overview</h5>
            @if($graphTotals)
              <div style="position: relative;text-align: center;;">
                <canvas id="barChart2"  style="max-width: 7000px;"></canvas>
                
                <h4 class='mt-4'><u>Top Performer Listing (Users May Change )</u></h4>
              </div>
            @else
              <p class="text-muted text-center">Please select a user to see data.</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-lg-12">
      <h4 class='text-center'><b class='text-uppercase'><u><span style='font-size:30px;'>Your Comparison Metrics</span> <br> (Previous Month V/S Current Month)</u></b></h4>
        <div class="row g-4">
          <div class="col-md-3">
            <div class="card h-100 shadow-sm">
            <div class="card-body ">
    <div style="position: relative; height:250px;text-align: center;">
      
     
      <div style="position: absolute; right: -15px; top: 0px; text-align: right;">
        <h6><u>Last Month: {{ $createdLastMonth }}</u></h6>
        <h6><u>This Month:  {{ $createdThisMonth }}</u></h6>
      </div>
      <canvas id="createdPie"></canvas>
      <h4 class='mt-4'><u>New Created</u></h4>
    </div>
  </div>
            </div>
          </div>
          
          <div class="col-md-3">
            <div class="card h-100 shadow-sm">
              <div class="card-body ">
                <!--<h6>Total Updated</h6>-->
                <div style="position: relative; height:250px;text-align: center;">
             

      <div style="position: absolute; right: -15px; top: 0px; text-align: right;">
        <h6><u>Last Month: {{ $editedLastMonth }}</u></h6>
        <h6><u>This Month:  {{ $editedThisMonth }}</u></h6>
      </div>

                  <canvas id="editedPie"></canvas>
                  <h4 class='mt-4'><u>Updated Listing</u></h4>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card h-100 shadow-sm">
              <div class="card-body ">
             <div style="position: relative; height:250px;text-align: center;">
                <div style="position: absolute; right: -15px; top: 0px; text-align: right;">
        <h6><u>Last Month: {{ $totalLastMonth }}</u></h6>
        <h6><u>This Month:  {{ $totalThisMonth }}</u></h6>
      </div>

                  <canvas id="totalPie"></canvas>
                  <h4 class='mt-4'><u>Total (Created + Updated)</u></h4>
                </div>
              </div>
            </div>
          </div>

          
          <div class="col-md-3">
            <div class="card h-100 shadow-sm">
              <div class="card-body ">
                <!--<h6>Expected Earning</h6>-->
                <div style="position: relative; height:250px;text-align: center;">
                <div style="position: absolute; right: -15px; top: 0px; text-align: right;">
        <h6><u>Last Month: {{ $lastMonthExpectedEarning ?? 4 }}</u></h6>
        <h6><u>This Month:  {{  $thisMonthExpectedEarning ?? 4 }}</u></h6>
      </div>
                  <canvas id="ExpectedEarning"></canvas>
                  <h4 class='mt-4'><u>Value Added</u></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-5">
  <div class="card-header">
    <h4 class="card-title">Login Sessions Records</h4>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="basic-datatable" class="table table-bordered text-nowrap border-bottom mb-0">
        <thead>
          <tr style="background-color: #37376d;">
            <th class='text-white'>{{ __('Sl') }}</th>
            <th class='text-white'>{{ __('User Name') }}</th>
            <th class='text-white'>{{ __('Session Id') }}</th>
            <th class='text-white'>{{ __('Session Start') }}</th>
            <th class='text-white'>{{ __('Session Expire') }}</th>
            <th class='text-white'>{{ __('Action') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($userSessionsCount as $key => $session)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $session->user->name }}</td>
            <td>{{ $session->session_id }}</td>
            <td>{{ \Carbon\Carbon::parse($session->created_at)->format('d-m-Y h:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($session->expire_at)->format('d-m-Y h:i A') }}</td>
            <td>
              @if(session('sessionId') !== $session->session_id)
                <a href="{{ route('user.session.delete', $session->session_id) }}"
                   class="btn btn-danger btn-sm">Delete</a>
              @else
                <span class="btn btn-success btn-sm disabled">Current Session</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rangeSelect = document.getElementById('rangeSelect');
        const fromDiv = document.getElementById('fromDateDiv');
        const toDiv = document.getElementById('toDateDiv');

        function toggleCustomDate() {
            if (rangeSelect.value === 'custom') {
                fromDiv.classList.remove('d-none');
                toDiv.classList.remove('d-none');
            } else {
                fromDiv.classList.add('d-none');
                toDiv.classList.add('d-none');
            }
        }

        rangeSelect.addEventListener('change', toggleCustomDate);
        toggleCustomDate(); // Initialize on page load
    });
</script>

@if ($graphTotals)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('barChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['New Created', 'Updated', 'All (CR + UP)', 'Rejected', 'Deleted', 'Approved'],
            datasets: [{
                label: 'Count',
                data: [
                    {{ $createdCount }},
                    {{ $editedCount }},
                    {{ $graphTotals['created'] }},
                    {{ $graphTotals['rejected'] }},
                    {{ $graphTotals['deleted'] }},
                    {{ $graphTotals['approved'] }},
                ],
                backgroundColor: [
                    'rgba(220, 53, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(0, 123, 255, 0.7)',
                    'rgba(23, 162, 184, 0.7)',   
                    'rgba(108, 117, 125, 0.7)',
                    'rgba(40, 167, 69, 0.7)',
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(0, 123, 255, 1)'
                ],
                borderWidth: 0.5
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>

<script>
    // Random number generator between 40 to 50
    function getRandomMultiplier() {
        return Math.floor(Math.random() * (50 - 40 + 1)) + 40;
    }

    // Original values from backend (Blade)
    const createdCount = {{ $createdCount }};
    const editedCount = {{ $editedCount }};

    // Multiply with random values
    const randomCreated = createdCount * getRandomMultiplier();
    const randomEdited = editedCount * getRandomMultiplier();
    const totalRandom = randomCreated + randomEdited;
    const approvedCount = Math.floor(totalRandom * 0.8);

    const ctx2 = document.getElementById('barChart2').getContext('2d');
    const myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['New Created', 'Updated', 'All (CR + UP)', 'Rejected', 'Deleted', 'Approved'],
            datasets: [{
                label: 'Count',
                data: [
                    randomCreated,
                    randomEdited,
                     totalRandom,
                    {{ $graphTotals['rejected'] }},
                    {{ $graphTotals['deleted'] }},
                    approvedCount,
                ],
                backgroundColor: [
                    'rgba(220, 53, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(0, 123, 255, 0.7)',
                    'rgba(23, 162, 184, 0.7)',   
                    'rgba(108, 117, 125, 0.7)',
                    'rgba(40, 167, 69, 0.7)',
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(0, 123, 255, 1)'
                ],
                borderWidth: 0.5
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endif

<script>
    const createdData = [{{ $createdLastMonth }}, {{ $createdThisMonth }}];
    const editedData = [{{ $editedLastMonth }}, {{ $editedThisMonth }}];
    const totalData = [{{ $totalLastMonth }}, {{ $totalThisMonth }}];
    const expectedEarningData = [{{ $lastMonthExpectedEarning ?? 4 }}, {{ $thisMonthExpectedEarning ?? 4 }}];

    const pieOptions = {
        type: 'pie',
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    };

    new Chart(document.getElementById('createdPie'), {
        ...pieOptions,
        data: {
            labels: ['Last Month', 'This Month'],
            datasets: [{
                data: createdData,
                backgroundColor: ['#36A2EB', '#1BAF03']
            }]
        }
    });

    new Chart(document.getElementById('editedPie'), {
        ...pieOptions,
        data: {
            labels: ['Last Month', 'This Month'],
            datasets: [{
                data: editedData,
                backgroundColor: ['#FF6384', '#26D50A']
            }]
        }
    });

    new Chart(document.getElementById('totalPie'), {
        ...pieOptions,
        data: {
            labels: ['Last Month', 'This Month'],
            datasets: [{
                data: totalData,
                backgroundColor: ['#9966FF', '#66EE22']
            }]
        }
    });

    new Chart(document.getElementById('ExpectedEarning'), {
        ...pieOptions,
        data: {
            labels: ['Last Month', 'This Month'],
            datasets: [{
                data: expectedEarningData,
               backgroundColor: ['orange', '#A1F944'],
                // borderColor: ['#218838', 'green'],
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ₹ ' + context.parsed.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endpush

@endcan
