@extends('layouts.master')
@section('navbar')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('product') }}" class="nav-link">Product</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('category') }}" class="nav-link">Category</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('preview') }}" class="nav-link">Product Preview</a>
            </li>
            <li class="nav-item dropdown" style="position: absolute; right: 30px; top: 9px;">
                  <div class="hidden sm:flex sm:items-center sm:ms-6">
                      <x-dropdown align="right" width="48">
                          <x-slot name="trigger">
                              <button
                                  class="inline-flex items-center p-2 border border-transparent text-lg leading-4 font-medium  text-black-900  hover:text-blue-900 focus:outline-none transition ease-in-out duration-150">

                                  <div
                                      class="bg-blue-900  flex items-center justify-center ">
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
                        <h1 class="m-0">Product Preview</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Preview Page</li>
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
                            <div class="col-sm-6 col-md-3 mb-4" v-for="product in products" :key="product.id">
                                <div class="card">
                                    <img class="card-img-top mx-auto mt-3 d-block" :src="fullImagePath(product.image)"
                                        alt="Product Image" style="width: 160px; object-fit: contain">
                                    <div class="card-body">
                                        <p class="card-text" style="opacity: .6">[[ product.category.category_name ]]</p>
                                        <h5 class="card-title">[[ product.product_name ]]</h5>
                                        <p class="card-text text-success">$[[ product.price ]]</p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <button class="btn btn-primary btn-sm" @click="addToCart(product)">
                                                Add to Cart
                                            </button>
                                            <div>
                                                <i class="fa fa-heart me-2"></i>
                                                <i class="fa fa-cart"></i>
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
                    products: [],
                    baseUrl: 'https://a.khmercleaningservice.us/storage/',
                };
            },
            methods: {
                getProducts() {
                    axios.get('https://a.khmercleaningservice.us/api/products')
                        .then(response => {
                            this.products = response.data;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },
                fullImagePath(image) {
                    return this.baseUrl + image;
                }
            },
            mounted() {
                this.getProducts();
            }
        });

        app.mount('#app');
    </script>
@endsection
