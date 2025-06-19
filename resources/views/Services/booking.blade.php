@extends('layouts.master')

@section('navbar')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('service') }}" class="nav-link">Service</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('service_category') }}" class="nav-link">Category Service</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('service_preview') }}" class="nav-link">Service Preview</a>
            </li>
             <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('show_booking') }}" class="nav-link">Booking</a>
            </li>
            <li class="nav-item dropdown" style="position: absolute; right: 30px; top: 9px;">
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center p-2 border border-transparent text-lg leading-4 font-medium  text-black-900  hover:text-blue-900 focus:outline-none transition ease-in-out duration-150">

                                <div class="bg-blue-900  flex items-center justify-center ">
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
@endsection

@section('content')
<div id="app">
    <!-- Page header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Booking List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Branch</th>
                                <th>Booking Date</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(booking, index) in bookings" :key="booking.id">
                                <td>[[ index + 1 ]]</td>
                                <td>[[ booking.customer?.name ]]</td>
                                <td>[[ booking.service?.service_name ]]</td>
                                <td>[[ booking.branch?.branch_name ]]</td>
                                <td>[[ booking.booking_date ]]</td>
                                <td>[[ booking.remarks ]]</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const { createApp } = Vue;

    const app = createApp({
        delimiters: ['[[', ']]'],
        data() {
            return {
                bookings: [],
            }
        },
        methods: {
            getBookings() {
                axios.get('https://a.khmercleaningservice.us/api/bookings') // Update URL if needed
                    .then(response => {
                        this.bookings = response.data;
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                        Swal.fire("Error", "Unable to load bookings.", "error");
                    });
            }
        },
        mounted() {
            this.getBookings();
        }
    });

    app.mount("#app");
</script>
@endsection
