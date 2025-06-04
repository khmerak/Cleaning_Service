@extends('layouts.master')

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
                    axios.get('http://127.0.0.1:8000/api/uploads')
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

                    axios.post('http://127.0.0.1:8000/api/uploads', formData, {
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

                    axios.post(`http://127.0.0.1:8000/api/uploads/${this.form.id}`, formData, {
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
                            axios.delete(`http://127.0.0.1:8000/api/uploads/${id}`)
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
