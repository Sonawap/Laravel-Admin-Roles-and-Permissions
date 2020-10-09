<template>
    <div class="p-0">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    {{ display }}
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="get()"><i class="fas fa-user"></i> All Users </button>
                        </li>

                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="newModal"><i class="fas fa-plus-circle"></i> Add New</button>
                        </li>
                        <li class="nav-item">
                            <div class="input-group mt-0 input-group-sm" style="width: 350px;">
                                <input type="text" v-model="searchWord" @keyup.enter="search" name="table_search" class="form-control float-right" placeholder="Search by name, email">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default" @click="search"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Action</th>
                        <th>Date Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.roles[0].name }}</td>
                            <td>{{ user.email  }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" @click="view(user)"> <i class="fa fa-eye"></i> View</button>
                                |
                                <button class="btn btn-sm btn-warning" @click="editModal(user)"> <i class="fa fa-edit"></i> Edit</button>
                                <!-- |
                                <button class="btn btn-sm btn-danger" @click="deletes(user.id)"> <i class="fa fa-trash"></i> Delete </button> -->
                            </td>
                            <td>{{ user.created_at |timeAgo }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <loading :loading='loading'></loading>
        </div>
        <div class="modal fade" id="categoryDetail">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <p><b>Name:</b> {{ categ.name }}</p>
                        <p><b>Email:</b> {{ categ.email }}</p>
                        <p><b>Last Updated:</b> {{ categ.updated_at | timeAgo }}</p>
                        <p><b>Date Posted:</b> {{ categ.created_at | timeAgo }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addNew">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="!editmode">Add User</h4>
                        <h4 class="modal-title" v-show="editmode">Update User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label> Name </label>
                                <input v-model="form.name" type="text" name="name" placeholder="Name"
                                    class="form-control" :class="{'is-invaild': form.errors.has('name')}">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label> Email </label>
                                <input v-model="form.email" type="text" name="email" placeholder="Email"
                                    class="form-control" :class="{'is-invaild': form.errors.has('email')}">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <label> Phone Number </label>
                                <input v-model="form.phone" type="text" name="phone" placeholder="Phone Number"
                                    class="form-control" :class="{'is-invaild': form.errors.has('phone')}">
                                <has-error :form="form" field="phone"></has-error>
                            </div>

                            <div class="form-group">
                                <label> Choose Role </label>
                                <b-form-select
                                    v-model="form.role"
                                    :options="roles"
                                    text-field="name"
                                    value-field="id"

                                ></b-form-select>
                                <has-error :form="form" field="role"></has-error>

                            </div>

                            <div class="form-group">
                                <label> Password </label>
                                <input v-model="form.password" type="password" name="password" placeholder="Password"
                                    class="form-control" :class="{'is-invaild': form.errors.has('password')}">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <b-form-group label="Assign Permissions">
                                <b-form-checkbox
                                    v-for="option in options"
                                    v-model="form.permissions"
                                    :key="option.name"
                                    :value="option.name"
                                    name="flavour-3a"
                                >
                                    {{ option.name }}
                                </b-form-checkbox>
                            </b-form-group>


                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
                            <b-button type="submit" variant="primary" class="btn-lg btn-primary" v-if="status" disabled><b-spinner small type="grow"></b-spinner>{{ action }}</b-button>
                            <button type="submit" v-show="editmode" v-if="!status" @click.prevent="editmode ? update() : create()" class="btn btn-lg btn-success">Update User</button>
                            <button type="submit" v-show="!editmode" v-if="!status" @click.prevent="editmode ? update() : create()" class="btn btn-lg btn-primary">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        data(){
            return {
                loading: false,
                action: '',
                status: false,
                users: [],
                roles: [],
                options: [],
                form: new Form({
                    name: '',
                    email: '',
                    role: '',
                    phone: '',
                    password: '',
                    id: '',
                    permissions: []
                }),
                editmode: false,
                categ: {},
                display:'',
                searchWord: '',
            }
        },
        methods:{
            editModal: function(category){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(category);
            },

            view: function(category){
                this.form.reset();
                $('#categoryDetail').modal('show');
                this.categ = category;
            },

            newModal: function(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            emptyform: function(){
                this.form.name= '';
                this.form.description= '';
                this.form.image= '';
            },

            get(){
                this.loading= true
                this.$Progress.start();
                this.status = true
                axios.get('get/user').then((response) =>{
                    this.users = response.data.users
                    this.roles = response.data.roles
                    this.options = response.data.permissions
                    this.status = false
                    this.$Progress.finish();
                    this.loading = false
                    this.display = 'Currently showing all users'
                }).catch((response)=>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot load Users',
                        'error'
                    )
                    this.loading = false
                    this.display = 'Currently showing all users'

                })
            },


            create(){
                this.status =true
                this.$Progress.start()
                this.action = 'Creating User'
                this.form.post('user').then((response) =>{
                    this.status = false
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    swal.fire(
                        'Created',
                        'User has been created',
                        'success'
                    )
                    this.form.reset();
                    $('#addNew').modal('hide');
                }).catch((response) =>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot Create User',
                        'error'
                    )

                })
            },
            search(){
                if(this.searchWord){
                    this.loading= true
                    this.$Progress.start();
                    this.status = true
                    axios.get('get/user/search/' + this.searchWord).then((response) =>{
                        this.users = response.data.users
                        this.roles = response.data.roles
                        this.status = false
                        this.$Progress.finish();
                        this.loading = false
                        this.display = 'Showing Search result for ' + this.searchWord
                    }).catch((response)=>{
                        this.status = false
                        this.$Progress.fail();
                        swal.fire(
                            'Error',
                            'Sorry, Cannot Find User',
                            'error'
                        )
                        this.loading = false
                        this.display = 'Showing Search result for ' + this.seachWord

                    })
                }else{
                    swal.fire(
                        'Empty',
                        'Sorry, Cannot Perform Search on empty query',
                        'error'
                    )
                }

            },
            update(){
                this.status =true
                this.$Progress.start()
                this.action = 'Updating User Info'
                this.form.put('user/' +this.form.id).then((response) =>{
                    this.status = false
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    swal.fire(
                        'Updated',
                        'User Info has been Updated',
                        'success'
                    )
                    this.form.reset();
                    $('#addNew').modal('hide');
                }).catch((response) =>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot Update User Info',
                        'error'
                    )

                })
            }
        },
        created: function(){
            this.get()
            Fire.$on('AfterCreate', ()=>{
                this.get();
            });
        }
    }
</script>
