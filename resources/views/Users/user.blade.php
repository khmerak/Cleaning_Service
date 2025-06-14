@extends('layouts.master')

@section('navbar')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('user') }}" class="nav-link">User</a>
            </li>
            <li class="nav-item dropdown" style="position: absolute; right: 30px; top: 9px;">
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center p-2 border border-transparent text-lg leading-4 font-medium  text-black-900  hover:text-blue-900 focus:outline-none transition ease-in-out duration-150">
                                <div class="bg-blue-900 flex items-center justify-center">
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

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
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
                    <form @submit.prevent="form.id ? updateUser() : addUser()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">[[ form.id ? 'Edit User' : 'Add User' ]]</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">Name</label>
                                <input type="text" class="form-control" id="username" v-model="form.name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" v-model="form.email" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-control" id="role" v-model="form.role" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="mb-3" v-if="!form.id">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" v-model="form.password" required>
                            </div>
                            <div class="mb-3" v-if="!form.id">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       v-model="form.password_confirmation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="close">Close</button>
                            <button type="submit" class="btn btn-primary">[[ form.id ? 'Update' : 'Save' ]]</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Body -->
        <div class="content">
            <div class="container-fluid">
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fas fa-plus"></i> Add User
                </button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(user, index) in users" :key="user.id">
                                    <td>[[ index + 1 ]]</td>
                                    <td>[[ user.name ]]</td>
                                    <td>[[ user.email ]]</td>
                                    <td>[[ user.role ]]</td>
                                    <td>
                                        <button class="btn btn-primary px-2" @click="editUser(user)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger ml-2" @click="deleteUser(user.id)">
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
        const { createApp } = Vue;

        createApp({
            delimiters: ['[[', ']]'],
            data() {
                return {
                    users: [],
                    form: {
                        id: null,
                        name: '',
                        email: '',
                        role: 'user',
                        password: '',
                        password_confirmation: ''
                    }
                }
            },
            methods: {
                getUsers() {
                    axios.get('https://a.khmercleaningservice.us/api/users')
                        .then(res => {
                            this.users = res.data;
                        });
                },
                addUser() {
                    if (this.form.password !== this.form.password_confirmation) {
                        Swal.fire('Error', 'Passwords do not match', 'error');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('name', this.form.name);
                    formData.append('email', this.form.email);
                    formData.append('role', this.form.role);
                    formData.append('password', this.form.password);
                    formData.append('password_confirmation', this.form.password_confirmation);

                    axios.post('{{ route('store_user') }}', formData)
                        .then(() => {
                            Swal.fire('Success', 'User added successfully!', 'success');
                            this.getUsers();
                            this.resetForm();
                            bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                        })
                        .catch(error => {
                            const msg = error.response?.data?.message || 'Something went wrong';
                            const details = error.response?.data?.errors;
                            if (details) {
                                let html = '';
                                for (const key in details) {
                                    html += `${details[key][0]}<br>`;
                                }
                                Swal.fire('Error', html, 'error');
                            } else {
                                Swal.fire('Error', msg, 'error');
                            }
                        });
                },
                updateUser() {
                    const formData = new FormData();
                    formData.append('name', this.form.name);
                    formData.append('email', this.form.email);
                    formData.append('role', this.form.role);

                    axios.post(`https://a.khmercleaningservice.us/api/users/${this.form.id}?_method=PUT`, formData)
                        .then(() => {
                            Swal.fire('Updated!', 'User updated successfully!', 'success');
                            this.getUsers();
                            this.resetForm();
                            bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                        })
                        .catch(error => {
                            Swal.fire('Error', error.response?.data?.message || 'Update failed', 'error');
                        });
                },
                editUser(user) {
                    this.form = {
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        role: user.role,
                        password: '',
                        password_confirmation: ''
                    };
                    new bootstrap.Modal(document.getElementById('staticBackdrop')).show();
                },
                deleteUser(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then(result => {
                        if (result.isConfirmed) {
                            axios.delete(`https://a.khmercleaningservice.us/api/users/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'User has been deleted.', 'success');
                                    this.getUsers();
                                })
                                .catch(() => {
                                    Swal.fire('Error', 'Something went wrong!', 'error');
                                });
                        }
                    });
                },
                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        email: '',
                        role: 'user',
                        password: '',
                        password_confirmation: ''
                    };
                },
                close() {
                    this.resetForm();
                    const modal = bootstrap.Modal.getInstance(document.getElementById('staticBackdrop'));
                    modal.hide();
                }
            },
            mounted() {
                this.getUsers();
            }
        }).mount('#app');
    </script>
@endsection
