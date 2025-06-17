  @extends('layouts.master')


  @section('navbar')
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
              </li>
              <li class="nav-item d-none d-sm-inline-block">
                  <a href="#" class="nav-link">POS</a>
              </li>
              <li class="nav-item d-none d-sm-inline-block">
                  <a href="#" class="nav-link">Contact</a>
              </li>
              <li class="nav-item dropdown" style="position: absolute; right: 30px; top: 9px;">
                  <div class="hidden sm:flex sm:items-center sm:ms-6">
                      <x-dropdown align="right" width="48">
                          <x-slot name="trigger">
                              <button
                                  class="inline-flex items-center p-2 border border-transparent text-lg leading-4 font-medium  text-black-900  hover:text-blue-900 focus:outline-none transition ease-in-out duration-150">

                                  <div class="flex items-center justify-center ">
                                      {{ Auth::user()->name }}
                                  </div>
                                  <div class="ms-1">
                                      <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                          viewBox="0 0 20 20">
                                          <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd" />
                                      </svg>
                                  </div>
                              </button>

                          </x-slot>

                          <x-slot name="content">
                              <x-dropdown-link :href="route('profile.edit')">
                                  {{ __('Profile') }}
                              </x-dropdown-link>

                              <!-- Authentication -->
                              <form method="POST" action="{{ route('logout') }}">
                                  @csrf

                                  <x-dropdown-link :href="route('logout')"
                                      onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                      {{ __('Log Out') }}
                                  </x-dropdown-link>
                              </form>
                          </x-slot>
                      </x-dropdown>
                  </div>
              </li>
          </ul>

      </nav>
      <!-- Settings Dropdown -->
  @endsection


  @section('content')
      <div id="app">
          <!-- Content Header (Page header) -->
          <div class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1 class="m-0">Dashboard Page</h1>
                      </div><!-- /.col -->
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">Dashboard Page</li>
                          </ol>
                      </div><!-- /.col -->
                  </div><!-- /.row -->
              </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="card">
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-lg-3 col-12">
                                          <!-- small card -->
                                          <div class="small-box bg-info">
                                              <div class="inner">
                                                  <h3>[[orders]]</h3>

                                                  <p>New Orders</p>
                                              </div>
                                              <div class="icon">
                                                  <i class="fas fa-shopping-cart"></i>
                                              </div>
                                              <a href="#" class="small-box-footer">
                                                  More info <i class="fas fa-arrow-circle-right"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <!-- ./col -->
                                      <div class="col-lg-3 col-6">
                                          <!-- small card -->
                                          <div class="small-box bg-success">
                                              <div class="inner">
                                                  <h3>53<sup style="font-size: 20px">%</sup></h3>

                                                  <p>Bounce Rate</p>
                                              </div>
                                              <div class="icon">
                                                  <i class="ion ion-stats-bars"></i>
                                              </div>
                                              <a href="#" class="small-box-footer">
                                                  More info <i class="fas fa-arrow-circle-right"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <!-- ./col -->
                                      <div class="col-lg-3 col-6">
                                          <!-- small card -->
                                          <div class="small-box bg-warning">
                                              <div class="inner">
                                                  <h3>[[ users ]]</h3>
                                                  <p>User Registrations</p>
                                              </div>
                                              <div class="icon">
                                                  <i class="fas fa-user-plus"></i>
                                              </div>
                                              <a href="#" class="small-box-footer">
                                                  More info <i class="fas fa-arrow-circle-right"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <!-- ./col -->
                                      <div class="col-lg-3 col-6">
                                          <!-- small card -->
                                          <div class="small-box bg-danger">
                                              <div class="inner">
                                                  <h3>65</h3>

                                                  <p>Unique Visitors</p>
                                              </div>
                                              <div class="icon">
                                                  <i class="fas fa-chart-pie"></i>
                                              </div>
                                              <a href="#" class="small-box-footer">
                                                  More info <i class="fas fa-arrow-circle-right"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <!-- ./col -->
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-6">
                          <div class="card card-danger">
                              <div class="card-header">
                                  <h3 class="card-title">Donut Chart</h3>

                                  <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                          <i class="fas fa-minus"></i>
                                      </button>
                                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                                          <i class="fas fa-times"></i>
                                      </button>
                                  </div>
                              </div>
                              <div class="card-body">
                                  <canvas id="donutChart"
                                      style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                              </div>
                              <!-- /.card-body -->
                          </div>
                      </div>
                      <div class="col-6">
                          <div class="card card-success">
                              <div class="card-header">
                                  <h3 class="card-title">Bar Chart</h3>

                                  <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                          <i class="fas fa-minus"></i>
                                      </button>
                                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                                          <i class="fas fa-times"></i>
                                      </button>
                                  </div>
                              </div>
                              <div class="card-body">
                                  <div class="chart">
                                      <canvas id="barChart"
                                          style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                  </div>
                              </div>
                              <!-- /.card-body -->
                          </div>
                      </div>
                      <!-- /.col-md-6 -->
                  </div>
                  <!-- /.row -->
              </div><!-- /.container-fluid -->
          </div>

      </div>
      <!-- /.content -->

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              // Donut Chart
              const donutCtx = document.getElementById('donutChart').getContext('2d');
              const donutData = {
                  labels: {!! json_encode($labels ?? ['Chrome', 'IE', 'Firefox', 'Safari', 'Opera', 'Navigator']) !!},
                  datasets: [{
                      data: {!! json_encode($data ?? [700, 500, 400, 600, 300, 100]) !!},
                      backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
                  }]
              };
              const donutOptions = {
                  maintainAspectRatio: false,
                  responsive: true,
                  plugins: {
                      legend: {
                          position: 'bottom'
                      }
                  }
              };
              new Chart(donutCtx, {
                  type: 'doughnut',
                  data: donutData,
                  options: donutOptions
              });

              // Bar Chart
              const barCtx = document.getElementById('barChart').getContext('2d');
              const barData = {
                  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                  datasets: [{
                      label: 'Sales',
                      data: [120, 150, 180, 200, 170, 210],
                      backgroundColor: '#3c8dbc'
                  }]
              };
              const barOptions = {
                  responsive: true,
                  maintainAspectRatio: false
              };
              new Chart(barCtx, {
                  type: 'bar',
                  data: barData,
                  options: barOptions
              });
          });
      </script>
  @endsection

  @section('scripts')
      <script>
          const {
              createApp
          } = Vue;

          const app = createApp({
              delimiters: ['[[', ']]'],
              data() {
                  return {
                      orders: '',
                      users: '',
                  };
              },
              methods: {
                  getOrders() {
                      axios.get('{{ route('count_order') }}')
                          .then(response => {
                              this.orders = response.data.total_orders;
                          })
                          .catch(console.error);
                  },
                  getUsers() {
                      axios.get('{{ route('count_users') }}')
                          .then(response => {
                              this.users = response.data.total_users;
                          }).catch(console.error);
                  }
              },
              mounted() {
                  this.getOrders();
                  this.getUsers();
              }
          });

          app.mount('#app');
      </script>
  @endsection
