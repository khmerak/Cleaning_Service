@extends('layouts.master')
@section('navbar')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('upload') }}" class="nav-link">Upload</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('service_category') }}" class="nav-link">Front CMS</a>
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
                    <form @submit.prevent="form.id ? updateUpload() : addUpload()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Upload</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="uploadImage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="uploadImage" @change="handleImageChange"
                                    accept=".jpg, .jpeg, .png, .gif">
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="text" class="form-control" id="position" v-model="form.name" required>
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
                        <h1 class="m-0">Upload Image</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Upload</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content body -->
        <div class="content">
            <div class="container-fluid">
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fas fa-plus"></i> Add
                </button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Position</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(upload, index) in uploads" :key="upload.id">
                                        <td>[[ index + 1 ]]</td>
                                        <td>
                                            <img v-if="upload.image" :src="'/storage/' + upload.image" width="50"
                                                height="50" onerror="this.src='/image_error.png';" />
                                            <img v-else style="width: 80px; border-radius: 10px" src="/no-image.png">
                                        </td>
                                        <td>[[ upload.position ]]</td>
                                        <td>
                                            <button class="btn btn-outline-primary" @click="editUpload(upload)">
                                                <i class="fas fa-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-outline-danger ml-2" @click="deleteUpload(upload.id)">
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
                    uploads: [],
                    form: {
                        id: null,
                        name: '',
                        image: null,
                    }
                };
            },
            methods: {
                getUpload() {
                    axios.get('https://a.khmercleaningservice.us/api/uploads')
                        .then(response => {
                            this.uploads = response.data;
                        }).catch(console.error);
                },
                addUpload() {
                    const formData = new FormData();
                    formData.append('position', this.form.name);
                    if (this.form.image) {
                        formData.append('image', this.form.image);
                    }

                    axios.post('https://a.khmercleaningservice.us/api/uploads', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Success', 'Uploaded successfully!', 'success');
                        this.getUpload();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Something went wrong',
                            'error');
                    });
                },

                updateUpload() {
                    const formData = new FormData();
                    formData.append('position', this.form.name);
                    formData.append('_method', 'PUT');
                    if (this.form.image) {
                        formData.append('image', this.form.image);
                    }

                    axios.post(`https://a.khmercleaningservice.us/api/uploads/${this.form.id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Updated!', 'Upload successfully!', 'success');
                        this.getUpload();
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
                        image: null,
                    };
                    document.getElementById('uploadImage').value = null;
                },
                deleteUpload(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`https://a.khmercleaningservice.us/api/uploads/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'Image has been deleted.', 'success');
                                    this.getUpload();
                                }).catch(() => {
                                    Swal.fire('Error', 'Something went wrong!', 'error');
                                });
                        }
                    });
                },
                editUpload(upload) {
                    this.form = {
                        id: upload.id,
                        name: upload.position,
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
                this.getUpload();
            }
        });
        app.mount('#app');
    </script>
@endsection
