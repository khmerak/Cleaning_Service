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
    <div id="app" class="container mt-4">
        <h2>Order</h2>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in orderItems" :key="item.id">
                    <td>[[ index + 1 ]]</td>
                    <td>[[ item.order_id ]]</td>
                    <td>[[ item.order.order_date ]]</td>
                    <td>[[ item.product.product_name ]]</td>
                    </td>
                    <td>[[ item.quantity ]]</td>
                    <td>$[[ parseFloat(item.price).toFixed(2) ]]</td>
                    <td>$[[ (item.quantity * parseFloat(item.price)).toFixed(2) ]]</td>
                    <td>
                        <span
                            :class="{
                                'badge bg-warning': item.order.status === 'pending',
                                'badge bg-success': item.order.status === 'completed',
                                'badge bg-danger': item.order.status === 'cancelled'
                            }">[[
                            item.order.status ]]</span>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
@endsection

@section('scripts')
    <script>
        const app = Vue.createApp({
            delimiters: ['[[', ']]'],
            data() {
                return {
                    orderItems: [],
                    loading: false,
                    error: null,
                };
            },
            methods: {
                getOrderItems() {
                    this.loading = true;
                    this.error = null;
                    axios.get('https://a.khmercleaningservice.us/api/order_items')
                        .then(res => {
                            this.orderItems = res.data;
                        })
                        .catch(err => {
                            this.error = err.response?.data?.message || err.message ||
                                'Failed to load order items';
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            },
            mounted() {
                this.getOrderItems();
            }
        });
        app.mount('#app');
    </script>
@endsection
