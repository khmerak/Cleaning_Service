@extends('layouts.master')

@section('content')
    <div id="app">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="form.id ? updatePosition() : addPosition()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add position</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="positionName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="positionName" v-model="form.name" required>
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
                        <h1 class="m-0">Position</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Position Page</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content body -->
        <div class="content">
            <div class="container-fluid">
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fas fa-plus"></i> Add position
                </button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(position, index) in positions" :key="position.id">
                                        <td>[[ index + 1 ]]</td>
                                        <td>[[ position.position_name ]]</td>
                                        <td>
                                            <button class="btn btn-primary px-2" @click="editPosition(position)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger ml-2"
                                                @click="deletePosition(position.id)">
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
                    positions: [],
                    form: {
                        id: null,
                        name: '',
                    }
                };
            },
            methods: {
                getPositions() {
                    axios.get('http://127.0.0.1:8000/api/positions')
                        .then(response => {
                            this.positions = response.data;
                        }).catch(console.error);
                },
                addPosition() {
                    const formData = new FormData();
                    formData.append('position_name', this.form.name);
                    axios.post('{{ route('positions_store') }}', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Success', 'Position added successfully!', 'success');
                        this.getPositions();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Something went wrong',
                            'error');
                    });
                },

                updatePosition() {
                    const formData = new FormData();
                    formData.append('position_name', this.form.name);

                    axios.post(`http://127.0.0.1:8000/api/positions/${this.form.id}?_method=PUT`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Updated!', 'Position updated successfully!', 'success');
                        this.getPositions();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Update failed', 'error');
                    });
                },
                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                    };
                },
                editPosition(position) {
                    this.form = {
                        id: position.id,
                        name: position.position_name,
                    };
                    new bootstrap.Modal(document.getElementById('staticBackdrop')).show();
                },
                deletePosition(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`http://127.0.0.1:8000/api/positions/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'Position has been deleted.', 'success');
                                    this.getPositions();
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
                this.getPositions();
            }
        });
        app.mount('#app');
    </script>
@endsection
