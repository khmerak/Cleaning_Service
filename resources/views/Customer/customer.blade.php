@extends('layouts.master')
@section('navbar')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('customer') }}" class="nav-link">Customer</a>
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
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="form.id ? updateCustomer() : addCustomer()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Customer</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" v-model="form.name" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" v-model="form.phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" v-model="form.email" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" v-model="form.address"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                @click='close'>Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customer Page</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content body -->
        <div class="content">
            <div class="container-fluid">
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fas fa-plus"></i> Add customer
                </button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(customer, index) in customers" :key="customer.id">
                                        <td>[[ index + 1 ]]</td>
                                        <td>[[ customer.customer_name ]]</td>
                                        <td>[[ customer.phone ]]</td>
                                        <td>[[ customer.email ]]</td>
                                        <td>[[ customer.address ]]</td>
                                        <td>
                                            <button class="btn btn-outline-primary" @click="editCustomer(customer)">
                                                <i class="fas fa-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-outline-danger ml-2"
                                                @click="deleteCustomer(customer.id)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
                    customers: [],
                    form: {
                        id: null,
                        name: '',
                        phone: '',
                        email: '',
                        address: ''
                    }
                };
            },
            methods: {
                getCustomers() {
                    axios.get('https://a.khmercleaningservice.us/api/customers')
                        .then(response => {
                            this.customers = response.data;
                            console.log(this.customers);
                        }).catch(console.error);
                },
                addCustomer() {
                    const formData = new FormData();
                    formData.append('customer_name', this.form.name);
                    formData.append('phone', this.form.phone);
                    formData.append('email', this.form.email);
                    formData.append('address', this.form.address);
                    axios.post('https://a.khmercleaningservice.us/api/customers', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Success', 'Customer added successfully!', 'success');
                        this.getCustomers();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Something went wrong',
                            'error');
                    });
                },

                updateCustomer() {
                    const formData = new FormData();
                    formData.append('customer_name', this.form.name);
                    formData.append('phone', this.form.phone);
                    formData.append('email', this.form.email);
                    formData.append('address', this.form.address);

                    axios.post(`https://a.khmercleaningservice.us/api/customers/${this.form.id}?_method=PUT`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Updated!', 'Customer updated successfully!', 'success');
                        this.getCustomers();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Update failed', 'error');
                    });
                },
                handleFileUpload(event) {
                    this.form.logo = event.target.files[0];
                },
                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        phone: '',
                        email: '',
                        address: ''
                    };
                },
                editCustomer(customer) {
                    this.form = {
                        id: customer.id,
                        name: customer.customer_name,
                        phone: customer.phone,
                        email: customer.email,
                        address: customer.address,
                    };
                    new bootstrap.Modal(document.getElementById('staticBackdrop')).show();
                },
                deleteCustomer(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`https://a.khmercleaningservice.us/api/customers/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'Customer has been deleted.', 'success');
                                    this.getCustomers();
                                }).catch(() => {
                                    Swal.fire('Error', 'Something went wrong!', 'error');
                                });
                        }
                    });
                },
                close() {
                    this.resetForm();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('staticBackdrop'));
                    modal.hide();
                }
            },
            mounted() {
                this.getCustomers();
            }
        });
        app.mount('#app');
    </script>
@endsection
