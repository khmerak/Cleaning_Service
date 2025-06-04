@extends('layouts.master')

@section('content')
    <div id="app">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="form.id ? updateProduct() : addProduct()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add product</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="productImage" @change="handleImageChange"
                                    accept=".jpg, .jpeg, .png, .gif">
                            </div>
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" v-model="form.name" required>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Price</label>
                                <input type="text" class="form-control" id="productPrice" v-model="form.price" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Stock Quantity</label>
                                <input type="text" class="form-control" id="quantity"
                                    v-model="form.stock_quantity" required>
                            </div>
                            <div class="mb-3">
                                <select name="category" id="category" class="form-control" v-model="form.category_id"
                                    required>
                                    <option value="">Select Category</option>
                                    <option v-for="category in categories" :value="category.id">
                                        [[ category.category_name ]]
                                    </option>
                                </select>
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
                        <h1 class="m-0">Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Page</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content body -->
        <div class="content">
            <div class="container-fluid">
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fas fa-plus"></i> Add Product
                </button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in products" :key="product.id">
                                        <td>[[ index + 1 ]]</td>
                                        <td>
                                            <img v-if="product.image" :src="'/storage/' + product.image" width="50"
                                                height="50" onerror="this.src='/image_error.png';" />
                                            <img v-else style="width: 80px; border-radius: 10px" src="/no-image.png">
                                        </td>
                                        <td>[[ product.product_name ]]</td>
                                        <td>$ [[ product.price ]]</td>
                                        <td>[[ product.stock_quantity ]]</td>
                                        <td>[[ product.category.category_name ]]</td>
                                        <td>[[ product.description ]]</td>
                                        <td>
                                            <button class="btn btn-outline-primary" @click="editProduct(product)">
                                                <i class="fas fa-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-outline-danger ml-2" @click="deleteProduct(product.id)">
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
                    products: [],
                    categories: [],
                    form: {
                        id: null,
                        name: '',
                        price: '',
                        quantity: '',
                        category_id: '',
                        description: '',
                        stock_quantity: '',
                        image: null,
                    }
                };
            },
            methods: {
                getEmpoyees() {
                    axios.get('http://127.0.0.1:8000/api/employees')
                        .then(response => {
                            this.empoyees = response.data;
                        }).catch(console.error);
                },
                getBranches() {
                    axios.get('http://127.0.0.1:8000/api/branches')
                        .then(response => {
                            this.branches = response.data;
                        }).catch(console.error);
                },
                addEmployee() {
                    const formData = new FormData();
                    console.log("Stock Quantity:", this.form.stock_quantity);

                    formData.append('product_name', this.form.name);
                    formData.append('price', this.form.price);
                    formData.append('stock_quantity', this.form.stock_quantity || 0); // Fallback to 0 if undefined
                    formData.append('category_id', this.form.category_id);
                    formData.append('description', this.form.description);
                    if (this.form.image) {
                        formData.append('image', this.form.image);
                    }
                    formData.append('_method', 'POST');

                    axios.post('http://127.0.0.1:8000/api/products', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Success', 'Product added successfully!', 'success');
                        this.getProducts();
                        this.resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('staticBackdrop')).hide();
                    }).catch(error => {
                        Swal.fire('Error', error.response?.data?.message || 'Something went wrong',
                        'error');
                    });
                },

                updateEmployee() {
                    const formData = new FormData();
                    formData.append('product_name', this.form.name);
                    formData.append('price', this.form.price);
                    formData.append('stock_quantity', this.form.stock_quantity);
                    formData.append('category_id', this.form.category_id);
                    formData.append('description', this.form.description);
                    formData.append('_method', 'PUT');
                    if (this.form.image) {
                        formData.append('image', this.form.image);
                    }

                    axios.post(`http://127.0.0.1:8000/api/products/${this.form.id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        Swal.fire('Updated!', 'Product updated successfully!', 'success');
                        this.getProducts();
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
                        price: '',
                        quantity: '',
                        category_id: '',
                        description: '',
                        image: null,
                    };
                    document.getElementById('productImage').value = null;
                },
                deleteEmployee(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`http://127.0.0.1:8000/api/products/${id}`)
                                .then(() => {
                                    Swal.fire('Deleted!', 'Product has been deleted.', 'success');
                                    this.getProducts();
                                }).catch(() => {
                                    Swal.fire('Error', 'Something went wrong!', 'error');
                                });
                        }
                    });
                },
                editProduct(product) {
                    this.form = {
                        id: product.id,
                        name: product.product_name,
                        price: product.price,
                        quantity: product.stock_quantity,
                        category_id: product.category_id,
                        description: product.description,
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
                this.getProducts();
                this.getCategories();
            }
        });
        app.mount('#app');
    </script>
@endsection
