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
                        <h1 class="m-0">Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Service Preview Page</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content body -->
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-3 mb-2" v-for="service in services" :key="service.id">
                                <div class="card">
                                    <img :src="fullImagePath(service.image)" alt="Service Image"
                                        class="card-img-top mx-auto mt-3 d-block"
                                        style="width: 200px; height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <p class="card-text text-muted">[[ service.service_category.service_category_name ]]
                                        </p>
                                        <h5 class="card-title mb-0">Service: [[ service.service_name ]]</h5>
                                        <p class="card-text">Area:[[ service.type ]]</p>
                                        <p class="card-text text-success">Price: $[[ service.price ]]</p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <button class="btn btn-sm btn-primary" @click="bookService(service)">
                                                Request Quote
                                            </button>
                                            <i class="fa fa-heart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    services: [],
                };
            },
            methods: {
                getServices() {
                    axios.get('{{ route('service_previews') }}')
                        .then(response => {
                            this.services = response.data;
                        }).catch(console.error);
                },
                fullImagePath(image) {
                    return image ? `/storage/${image}` : '/images/default-service.png';
                },
            },
            mounted() {
                this.getServices();
            }
        });
        app.mount('#app');
    </script>
@endsection
