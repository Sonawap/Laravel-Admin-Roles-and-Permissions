<template>
    <div class="container-fuild">
        <h3>Quick Links</h3><hr>
        <div class="row mt-3">
           <div class="col-lg-3 col-6">
            <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h2>Users</h2>
                        <h4>{{ usercount }}</h4>
                    </div>
                    <div class="icon ">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="/user" class="small-box-footer ">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
       </div>
    </div>

</template>

<script>
    export default {
        props:{
            usercount: [Number,String]
        },
        created(){
            this.$toastr.defaultType = "success";
            this.$toastr.s(
                "Welcome Administator, to the dashbaord"
            );
        }
    }

</script>
