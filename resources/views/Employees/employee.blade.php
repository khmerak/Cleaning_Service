@extends('layouts.master')

@section('navbar')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('employee')}}" class="nav-link">Empoyee</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('position')}}" class="nav-link">Position</a>
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
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form @submit.prevent="form.id ? updateEmployee() : addEmployee()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Employee</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="row">


                                <!-- First Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" v-model="form.first_name"
                                        required>
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" v-model="form.last_name"
                                        required>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" v-model="form.email" required>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" v-model="form.phone" required>
                                </div>

                                <!-- Position -->
                                <div class="col-md-6 mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <select class="form-control" id="position" v-model="form.position_id" required>
                                        <option value="">Select Position</option>
                                        <option v-for="position in positions" :value="position.id">[[
                                            position.position_name ]]
                                        </option>
                                    </select>
                                </div>

                                <!-- Branch -->
                                <div class="col-md-6 mb-3">
                                    <label for="branch" class="form-label">Branch</label>
                                    <select class="form-control" id="branch" v-model="form.branch_id" required>
                                        <option value="">Select Branch</option>
                                        <option v-for="branch in branches" :value="branch.id">[[ branch.branch_name ]]
                                        </option>
                                    </select>
                                </div>

                                <!-- Hire Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="hireDate" class="form-label">Hire Date</label>
                                    <input type="date" class="form-control" id="hireDate" v-model="form.hire_date"
                                        required>
                                </div>

                                <!-- Salary -->
                                <div class="col-md-6 mb-3">
                                    <label for="salary" class="form-label">Salary</label>
                                    <input type="number" class="form-control" id="salary" v-model="form.salary"
                                        required>
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" v-model="form.date_of_birth"
                                        required>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" v-model="form.status" required>
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <!-- Address (full width) -->
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" v-model="form.address" rows="2" required></textarea>
                                </div>
                                <!-- Profile Picture -->
                                <div class="col-md-6 mb-3">
                                    <label for="profilePicture" class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" id="profilePicture"
                                        @change="handleImageChange" accept=".jpg, .jpeg, .png, .gif">
                                </div>
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
                        <h1 class="m-0">Employee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Employee Page</li>
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
                    <i class="fas fa-plus"></i> Add customer
                </button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Employee Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Position ID</th>
                                        <th>Branch ID</th>
                                        <th>Hire Date</th>
                                        <th>Salary</th>
                                        <th>Birth of Date</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(employee, index) in employees" :key="employee.id">
                                        <td>[[ index + 1 ]]</td>
                                        <td>
                                            <img v-if="employee.profile_picture"
                                                :src="'/storage/' + employee.profile_picture" width="50"
                                                height="50" onerror="this.src='/image_error.png';" />
                                            <img v-else style="width: 80px; border-radius: 10px" src="/no-image.png">
                                        </td>
                                        <td>[[ employee.first_name ]] [[employee.last_name ]]</td>
                                        <td>[[employee.phone]]</td>
                                        <td>[[ employee.email ]]</td>
                                        <td>[[ employee.position_id ]]</td>
                                        <td>[[ employee.branch_id ]]</td>
                                        <td>[[ employee.hire_date ]]</td>
                                        <td>$ [[ employee.salary ]]</td>
                                        <td>[[ employee.date_of_birth ]]</td>
                                        <td>[[ employee.address ]]</td>
                                        <td>
                                            <span class="badge"
                                                :class="employee.status === 'active' ? 'bg-success' : 'bg-danger'">
                                                [[ employee.status ]]
                                            </span>
                                        <td>
                                            <button class="btn btn-primary" @click="editEmployee(employee)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger ml-2" @click="deleteEmployee(employee.id)">
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
                    employees: [],
                    branches: [],
                    positions: [],
                    form: {
                        id: null,
                        first_name: '',
                        last_name: '',
                        email: '',
                        phone: '',
                        position_id: '',
                        branch_id: '',
                        hire_date: '',
                        salary: '',
                        address: '',
                        date_of_birth: '',
                        profile_picture: null,
                        status: '',
                    }
                };
            },
            methods: {
                getEmployees() {
                    axios.get('http://127.0.0.1:8000/api/employees')
                        .then(response => {
                            this.employees = response.data;
                        }).catch(console.error);
                },
                getBranches() {
                    axios.get('http://127.0.0.1:8000/api/branches')
                        .then(response => {
                            this.branches = response.data;
                        }).catch(console.error);
                },
                getPositions() {
                    axios.get('http://127.0.0.1:8000/api/positions')
                        .then(response => {
                            this.positions = response.data;
                        }).catch(console.error);
                },
                addEmployee() {
                    const formData = new FormData();
                    formData.append('first_name', this.form.first_name);
                    formData.append('last_name', this.form.last_name);
                    formData.append('email', this.form.email);
                    formData.append('phone', this.form.phone);
                    formData.append('position_id', this.form.position_id);
                    formData.append('branch_id', this.form.branch_id);
                    formData.append('hire_date', this.form.hire_date);
                    formData.append('salary', this.form.salary);
                    formData.append('address', this.form.address);
                    formData.append('date_of_birth', this.form.date_of_birth);
                    formData.append('status', this.form.status);
                    if (this.form.profile_picture) {
                        formData.append('profile_picture', this.form.profile_picture);
                    }

                    axios.post('http://127.0.0.1:8000/api/employees', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Success', 'Employee added successfully!', 'success');
                        this.getEmployees();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Something went wrong',
                            'error');
                    });
                },
                updateEmployee() {
                    const formData = new FormData();
                    formData.append('_method', 'PUT');
                    formData.append('first_name', this.form.first_name);
                    formData.append('last_name', this.form.last_name);
                    formData.append('email', this.form.email);
                    formData.append('phone', this.form.phone);
                    formData.append('position_id', this.form.position_id);
                    formData.append('branch_id', this.form.branch_id);
                    formData.append('hire_date', this.form.hire_date);
                    formData.append('salary', this.form.salary);
                    formData.append('address', this.form.address);
                    formData.append('date_of_birth', this.form.date_of_birth);
                    formData.append('status', this.form.status);
                    if (this.form.profile_picture) {
                        formData.append('profile_picture', this.form.profile_picture);
                    }

                    axios.post(`http://127.0.0.1:8000/api/employees/${this.form.id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Success', 'Employee updated successfully!', 'success');
                        this.getEmployees();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Update failed', 'error');
                    });
                },
                handleImageChange(event) {
                    this.form.profile_picture = event.target.files[0];
                },
                resetForm() {
                    this.form = {
                        id: null,
                        first_name: '',
                        last_name: '',
                        email: '',
                        phone: '',
                        position_id: '',
                        branch_id: '',
                        hire_date: '',
                        salary: '',
                        address: '',
                        date_of_birth: '',
                        profile_picture: null,
                        status: '',
                    };
                    document.getElementById('profilePicture').value = null;
                },
                deleteEmployee(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action is permanent!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`http://127.0.0.1:8000/api/employees/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'Employee has been deleted.', 'success');
                                    this.getEmployees();
                                }).catch(() => {
                                    Swal.fire('Error', 'Something went wrong!', 'error');
                                });
                        }
                    });
                },
                editEmployee(employee) {
                    this.form = {
                        id: employee.id,
                        first_name: employee.first_name,
                        last_name: employee.last_name,
                        email: employee.email,
                        phone: employee.phone,
                        position_id: employee.position_id,
                        branch_id: employee.branch_id,
                        hire_date: employee.hire_date,
                        salary: employee.salary,
                        address: employee.address,
                        date_of_birth: employee.date_of_birth,
                        profile_picture: null,
                        status: employee.status,
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
                this.getEmployees();
                this.getBranches();
                this.getPositions();
            }
        });
        app.mount('#app');
    </script>
@endsection
