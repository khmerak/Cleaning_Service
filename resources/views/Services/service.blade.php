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
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="form.id ? updateService() : addService()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Service</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="serviceImage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="serviceImage" @change="handleImageChange"
                                    accept=".jpg, .jpeg, .png, .gif">
                            </div>
                            <div class="mb-3">
                                <label for="serviceName" class="form-label">Service Name</label>
                                <input type="text" class="form-control" id="serviceName" v-model="form.name" required>
                            </div>
                            <div class="mb-3">
                                <label for="serviceType" class="form-label">Type</label>
                                <input type="text" class="form-control" id="serviceType" v-model="form.type" required>
                            </div>
                            <div class="mb-3">
                                <label for="servicePrice" class="form-label">Price</label>
                                <input type="text" class="form-control" id="servicePrice" v-model="form.price" required>
                            </div>
                            <div class="mb-3">
                                <select name="category" id="category" class="form-control" v-model="form.category_id"
                                    required>
                                    <option value="">Select Category</option>
                                    <option v-for="category in categories" :value="category.id">
                                        [[ category.service_category_name ]]
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="serviceDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="serviceDescription" v-model="form.description"></textarea>
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
                        <h1 class="m-0">Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Service Page</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content body -->
        <div class="content">
            <div class="container-fluid">
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop">
                    <i class="fas fa-plus"></i> Add Service
                </button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Service Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(service, index) in services" :key="service.id">
                                        <td>[[ index + 1 ]]</td>
                                        <td>
                                            <img v-if="service.image" :src="'/storage/' + service.image" width="50"
                                                height="50" onerror="this.src='/image_error.png';" />
                                            <img v-else style="width: 80px; border-radius: 10px" src="/no-image.png">
                                        </td>

                                        <!-- Service name: larger and bold -->
                                        <td class="fw-bold" style="font-size: 1.2rem;">[[ service.service_name ]]</td>

                                        <td>[[ service.type ]]</td>
                                        <td>$ [[ service.price ]]</td>
                                        <td>[[ service.category_id ]]</td>

                                        <!-- Description: larger font, word wrap -->
                                        <td style="font-size: 1.1rem; white-space: pre-line; max-width: 250px;">
                                            [[ service.description ]]
                                        </td>

                                        <td>
                                            <button class="btn btn-primary" @click="editService(service)">
                                                <i class="fas fa-edit p-0"></i>
                                            </button>
                                            <button class="btn btn-danger ml-2" @click="deleteService(service.id)">
                                                <i class="fas fa-trash"></i>
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
                    services: [],
                    categories: [],
                    form: {
                        id: null,
                        name: '',
                        price: '',
                        type: '',
                        category_id: '',
                        description: '',
                        image: null,
                    }
                };
            },
            methods: {
                getServices() {
                    axios.get('{{ route('get_services') }}')
                        .then(response => {
                            this.services = response.data;
                        }).catch(console.error);
                },
                getCategories() {
                    axios.get('{{ route('service_categories') }}')
                        .then(response => {
                            this.categories = response.data;
                        }).catch(console.error);
                },
                addService() {
                    const formData = new FormData();
                    formData.append('service_name', this.form.name);
                    formData.append('price', this.form.price);
                    if (this.form.type) {
                        formData.append('type', this.form.type);
                    }
                    formData.append('category_id', this.form.category_id);
                    formData.append('description', this.form.description);
                    if (this.form.image) {
                        formData.append('image', this.form.image);
                    }

                    axios.post('http://127.0.0.1:8000/api/services', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Success', 'Service added successfully!', 'success');
                        this.getServices();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Something went wrong',
                            'error');
                    });
                },
                updateService() {
                    const formData = new FormData();
                    formData.append('service_name', this.form.name);
                    if (this.form.type) {
                        formData.append('type', this.form.type);
                    }
                    formData.append('price', this.form.price);
                    formData.append('category_id', this.form.category_id);
                    formData.append('description', this.form.description);
                    if (this.form.image) {
                        formData.append('image', this.form.image);
                    }
                    formData.append('_method', 'PUT');

                    axios.post(`http://127.0.0.1:8000/api/services/${this.form.id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Updated!', 'Service updated successfully!', 'success');
                        this.getServices();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Update failed', 'error');
                    });
                },
                handleImageChange(event) {
                    this.form.image = event.target.files[0];
                },
                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        type: '',
                        price: '',
                        category_id: '',
                        description: '',
                        image: null,
                    };
                    document.getElementById('serviceImage').value = null;
                },
                deleteService(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`http://127.0.0.1:8000/api/services/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'Service has been deleted.', 'success');
                                    this.getServices();
                                }).catch(() => {
                                    Swal.fire('Error', 'Something went wrong!', 'error');
                                });
                        }
                    });
                },
                editService(service) {
                    this.form = {
                        id: service.id,
                        name: service.service_name,
                        type: service.type,
                        price: service.price,
                        category_id: service.category_id,
                        description: service.description,
                        image: null,
                    };
                    new bootstrap.Modal(document.getElementById('staticBackdrop')).show();
                },
                close() {
                    this.resetForm();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('staticBackdrop'));
                    modal.hide();
                }
            },
            mounted() {
                this.getServices();
                this.getCategories();
            }
        });
        app.mount('#app');
    </script>
@endsection
