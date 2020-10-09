<template>
    <form>
        <div class="modal-body">
            <div class="form-group">
                <input v-model="form.name" type="text" name="name" placeholder="Role Name"
                    class="form-control" :class="{'is-invaild': form.errors.has('name')}">
                <has-error :form="form" field="name"></has-error>

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
            <b-button type="submit" variant="primary" class="btn-lg btn-primary" v-if="!dis" disabled><b-spinner small type="grow"></b-spinner>{{ action }}</b-button>
            <button type="submit"  v-if="dis" @click.prevent="createRole()" class="btn btn-lg btn-primary"><i class="fas fa-save"></i> Save Role</button>
        </div>
    </form>
</template>


<script>
export default {
    data(){
        return{
            options: [],
            dis: true,
            action: '',
            form: new Form({
                id: '',
                name: '',
                permissions: [],
            })
        }
    },
    methods:{
        emptyform: function(){
            this.form.name= '';
            this.form.id= '';
            this.form.permissions= '';
        },
        getPermissions: function(){
            axios.get("getPermission").then(({ data }) => (this.options = data.permissions));
        },
        createRole: function(){
            this.action = "Creating Role"
            this.dis = false
            this.form.post('role')
            .then((response)=>{


                this.emptyform();
                swal.fire(
                    'New Role Created!',
                    response.data.message,
                    'success',
                    window.location = '/role'
                )
                this.dis = true
            })
            .catch(()=>{
                this.dis = true
                swal.fire(
                    'Error!',
                    'Sorry an error occured, Unable to create new role try again',
                    'error'
                )
            })

        },
    },
    created() {
        this.getPermissions()
    },

}
</script>
