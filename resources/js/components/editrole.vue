<template>
    <div>
        <div class="span" v-for="permission in prem" v-key="permission.id">
            <button role="button" class="btn btn-warning">
                {{ permission.name }}
            </button>
        </div>
        <div class="modal-body">
            <b-form-group label="Select Permissions">
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
            <button type="submit"  v-if="dis" @click.prevent="createRole()" class="btn btn-lg btn-primary">Update Role</button>
        </div>
    </div>
</template>


<script>
export default {
    props: {
        role: [Object, Array],
        permissions: [Object, Array],
    },
    data(){
        return{
            options: [],
            prem: this.permissions,
            dis: true,
            action: '',
            form: new Form({
                id: '',
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
        updateRole: function(){
            this.action = "Updating Role"
            this.dis = false
            this.form.post('saveRole')
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
