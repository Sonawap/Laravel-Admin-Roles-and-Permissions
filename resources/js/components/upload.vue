<template>
    <div>
        <div class="text-center">
            <label for="img6">
                <h3>Click to Select Image</h3>
                <img
                    :src="imgplaceholder6"
                    class="profile-user-img img-fluid img-circle mt-2"
                    :class="{'is-invaild': form.errors.has('icon')}"

                >
            </label>
            <input type="file" id="img6" name="icon" @change="croppie2" style="display:none">
            <has-error :form="form" field="icon"></has-error>
            <br>
            <b-button variant="primary" class="mt-2 btn-primary" v-if="dis" disabled><b-spinner small type="grow"></b-spinner>Uploading</b-button>
            <button @click="uploadImage()" class="mt-3 btn btn-primary" v-if="!dis"><i class="fas fa-upload"></i> Upload Profile Photo</button>
        </div>
        <div class="modal fade" id="addImage6">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crop Image</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <vue-croppie ref="croppieRef2"
                            :enableOrientation="true"
                            :enableResize = "false"
                            :boundary="{ width: 400, height: 400}"
                            :viewport="{ width:300, height:300, 'type':'square' }"
                        >
                        </vue-croppie>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-lg btn-info" @click="crop2(6,300,300)">Crop</button>

                    </div>
                </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
export default {
    data(){
        return{
            dis: false,
            imgplaceholder6:'assets/img/avatar.jpg',
            form: new Form({
                icon: ''

            }),
        }
    },
    methods:{
        crop2(id,h,w) {
            // Options can be updated.
            // Current option will return a base64 version of the uploaded image with a size of 600px X 450px.
            let options = {
                type: 'base64',
                size: { width: w, height: h },
                format: 'jpg'
            };
            this.$refs.croppieRef2.result(options, output => {
                this.imgplaceholder6 = output;
                this.form.icon = output;
                $('#addImage6').modal('hide');
            });

        },
        croppie2(e) {
            $('#addImage6').modal('show');
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;

            var reader = new FileReader();
            reader.onload = e => {
                this.$refs.croppieRef2.bind({
                url: e.target.result
                });
            };

            reader.readAsDataURL(files[0]);
        },
        uploadImage(){
            this.dis = true
            this.form.post('uploadProfilePhoto').then((response)=>{
                this.dis = false
                swal.fire(
                    'Success!',
                    'Your Profile Photo has been changed',
                    'success'
                )

            }).catch(() =>{
                this.dis = false
                swal.fire(
                    'Error!',
                    'Sorry an error occured, Unable Change your profile image at the moment try again later',
                    'error'
                )
            });
        }
    },


    created(){

    }
}
</script>
