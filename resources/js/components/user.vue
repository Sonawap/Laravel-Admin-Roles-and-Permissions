<template>
    <div class="p-0">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Users
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#createUser"><i class="fas fa-plus-circle"></i> Add New</button>
                        </li>
                        <li class="nav-item">
                            <div class="input-group mt-0 input-group-sm" style="width: 350px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search by name, email">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
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
                            <td> {{ user.name }}</td>
                            <td>{{ user.role }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <button class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> View</button>
                                <button class="btn btn-sm btn-warning" > <i class="fa fa-edit"></i> Edit</button>
                                <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Delete </button>
                            </td>
                            <td>
                                {{ user.created_at | date }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createUser()">
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
                                    v-for="option in permissions"
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
                            <button type="button"  class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
                            <b-button variant="primary" v-if="!load" class="btn-lg" disabled>
                                <b-spinner small type="grow"></b-spinner>
                                Creating Account...
                            </b-button>
                            <button type="submit" v-if="load" class="btn btn-lg btn-primary">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            load: true,
            users: [],
            roles: [],
            permissions:[],
            form: new Form({
                'name': '',
                'phone': '',
                'password': '',
                'email': '',
                'permissions': [],
                'role': 3,
            })
        }
    },
    methods:{
        getUsers(){
            axios.get('/getAllUsers').then((response) =>{
                this.users = response.data.users
            }).catch(()=>{
                this.$toastr.e("Cannot load users", "Error");
            })
        },
        getRoles(){
            axios.get('/getAllRoles').then((response) =>{
                this.roles = response.data.roles
            });
        },
        getPermissions(){
            axios.get('/getAllPermissions').then((response) =>{
                this.permissions = response.data.permissions
            });
        },

        createUser(){
            this.load = false;
            this.form.post("/account/create").then((response) => {
                this.load = true;
                this.$toastr.s("user create succefully", "Created");
                Fire.$emit("loadUser");
                $("#createUser").modal("hide");
                this.form.reset();
            }).catch(() => {
                this.load = true;
                this.$toastr.e("Cannot create user, try again", "Error");
            });
        }

    },
    created(){
        this.getUsers();
        this.getRoles();
        this.getPermissions();
        Fire.$on('loadUser', () => {
            this.getUsers();
        });
    }
}
</script>
