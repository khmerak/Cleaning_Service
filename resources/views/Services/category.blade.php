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
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="form.id ? updateCategory() : addCategory()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Service Category</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="categoryName" v-model="form.name" required>
                            </div>
                            <div class="mb-3">
                                <label for="branchDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="branchDescription" v-model="form.description"></textarea>
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
                        <h1 class="m-0">Service Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Service Category Page</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content body -->
        <div class="content">
            <div class="container-fluid">
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fas fa-plus"></i> Add category
                </button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(service_category, index) in service_categories" :key="service_category.id">
                                        <td>[[ index + 1 ]]</td>
                                        <td>[[ service_category.service_category_name ]]</td>
                                        <td>[[ service_category.description ]]</td>
                                        <td>
                                            <button class="btn btn-outline-primary" @click="editCategory(service_category)">
                                                <i class="fas fa-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-outline-danger ml-2" @click="deleteCategory(service_category.id)">
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
                    service_categories: [],
                    form: {
                        id: null,
                        name: '',
                        description: '',
                    }
                };
            },
            methods: {
                getCategories() {
                    axios.get('https://a.khmercleaningservice.us/api/service_categories')
                        .then(response => {
                            this.service_categories = response.data;
                        }).catch(console.error);
                },
                addCategory() {
                    const formData = new FormData();
                    formData.append('service_category_name', this.form.name);
                    formData.append('description', this.form.description);
                    axios.post('https://a.khmercleaningservice.us/api/service_categories', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Success', 'Branch added successfully!', 'success');
                        this.getCategories();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Something went wrong',
                            'error');
                    });
                },

                updateCategory() {
                    const formData = new FormData();
                    formData.append('service_category_name', this.form.name);
                    formData.append('description', this.form.description);

                    axios.post(`https://a.khmercleaningservice.us/api/service_categories/${this.form.id}?_method=PUT`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Updated!', 'Category updated successfully!', 'success');
                        this.getCategories();
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
                        description: '',
                    };
                },
                editCategory(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`https://a.khmercleaningservice.us/api/service_categories/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                                    this.getCategory();
                                }).catch(() => {
                                    Swal.fire('Error', 'Something went wrong!', 'error');
                                });
                        }
                    });
                },
                editCategory(service_category) {
                    this.form = {
                        id: service_category.id,
                        name: service_category.service_category_name,
                        description: service_category.description,
                    };
                    new bootstrap.Modal(document.getElementById('staticBackdrop')).show();
                },
                deleteCategory(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`https://a.khmercleaningservice.us/api/service_categories/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                                    this.getCategories();
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
                this.getCategories();
            }
        });
        app.mount('#app');
    </script>
@endsection
