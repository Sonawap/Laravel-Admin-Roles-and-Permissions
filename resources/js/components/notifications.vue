<template>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fas fa-bell"></i> Notifications</h4>
            <div class="card-tools">
                <ul class="list-inline list-header float-right">
                    <li class="list-inline-item"><a href="#" @click="markAsRead">Mark all as Read</a></li>
                    <li class="list-inline-item"><a href="#">{{ count > 0 ? "You have " + count : 'No' }} unread Notification</a></li>
                </ul>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr v-for="notification in allNotifications" :key="notification.id">
                            <td>
                                <div class="col-md-10">
                                    {{ notification.data.action}}
                                    <p class="text-muted text-sm">{{  notification.created_at | timeAgo }}</p>
                                </div>
                            </td>
                            <hr>
                        </tr>
                        <div v-if="allNotifications.length < 1">
                            <h1 class="text-center">No New Notifications</h1>
                            
                        </div>
                    </tbody>
                    <tbody>
                        <tr v-for="notification in notifications" :key="notification.id">
                            <td>
                                <div class="col-md-10">
                                    {{ notification.data.action}}
                                    <p class="text-muted text-sm">{{  notification.created_at | timeAgo }}</p>
                                </div>
                            </td>
                            <hr>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        data() {
            return {
                // logged: this.$gate.isAuth(),
                allNotifications:{},
                count:'',
                notifications: []
            }
        },

        methods: {
            markAsRead(){
                if(this.count > 0){
                    axios.get('user/mark-all-read').then(()=>{
                        Fire.$emit('AfterCreate');
                        
                        swal.fire(
                        'Marked',
                        'Notification Marked as read',
                        'success'
                        )
                    })
                }else{
                    swal.fire(
                    'Sorry',
                    'No new Notifications',
                    'error'
                    )
                }
            },
            get(){
                this.loading= true
                this.$Progress.start();
                this.status = true
                axios.get('/admin/auth/notifications').then((response) =>{
                    this.allNotifications = response.data.notification
                    this.notifications = response.data.allnotification
                    this.count = response.data.count
                    this.status = false
                    this.$Progress.finish();
                    this.loading = false
                }).catch((response)=>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot load Notifications',
                        'error'
                    )
                    this.loading = false
    
                })
            }
        },

        created(){
            this.get();
            Fire.$on('AfterCreate', ()=>{
                this.get();
            });
        },
        

    }
</script>
