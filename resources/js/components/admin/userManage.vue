<template>

    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{this.$parent.lg=='en'? 'Display users' :'Afficher les utilisateurs'}}</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>{{this.$parent.lg=='en'? 'Name' :'Nom'}}</th>
                      <th>E-mail</th>
                      <th>{{this.$parent.lg=='en'? 'Status' :'Statut'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Creation date' :'Date de creation'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Last update date' :'Date de dernière modofication'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Edit & delete' :'Modifier & supprimer'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Active/Disabled' :'activé/désactivé'}}</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td >{{user.status|acOrDi}}</td>
                        <td>{{user.created_at |myDate}}</td>
                        <td>{{user.updated_at|myDate}}</td>
                      <td><a href="#" data-toggle="modal" data-target="#addNew" @click="editModal(user)" ><i class="fa fa-edit"></i></a> / <a href="#" @click="deleteUser(user.id)"><i class="fa fa-trash red"></i></a></td>
                      <!-- <td><button type="submit" @click="updateStatus(user.id,user.status)"
                      :class="  user.status == 1 ? 'btn btn-danger' : 'btn btn-success' "
                           >{{user.status|notAcOrDi}}</button></td> -->
                           <td><div class="form-group">
                    <div class="custom-control custom-switch"
                    :class="  user.status == 0 ? 'custom-switch-on-success' : 'custom-switch-off-danger' ">
                      <input :checked="user.status == 0" @click="updateStatus(user.id,user.status)" type="checkbox" class="custom-control-input" v-bind:id="user.id">
                      <label class="custom-control-label" v-bind:for="user.id"></label>
                    </div>
                  </div></td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-footer">
                  <pagination style="margin-bottom: 0px;"
 :data="users" @pagination-change-page="getResults"></pagination>
              </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
       <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h5 v-show="editmode" class="modal-title" id="addNewLabel">{{this.$parent.lg=='en'? 'Update user\'s information' :'Modifier les informations de l\'utilisateur'}}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

<form @submit.prevent="updateUser()" >
      <div class="modal-body">

                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.password" type="password" name="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{this.$parent.lg=='en'? 'Close' :'Fermer'}}</button>
        <button  type="submit" v-show="editmode" class="btn btn-success">{{this.$parent.lg=='en'? 'Update' :'Modifier'}}</button>


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
            return{
                editmode:true,
                users:{},
                checked:true,
                form:new Form({
                  id:'',
                    name:'',
                    email:'',
                    password:'',
                    status:'',
                })
            }
        },
        methods:{
            getResults(page = 1) {
                        axios.get('api/user?page=' + page)
                            .then(response => {
                                this.users = response.data;
                            });
                },
            updateStatus(id,status){
                this.$Progress.start();
                this.form.get('/api/user/'+id)
            .then(()=>{
                if(status==0){
                    swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'The user has been activated',
  showConfirmButton: false,
  timer: 1500
})
                }
                else{
                    swal.fire({
  position: 'top-end',
  icon: 'error',
  title: 'The user has been disabled',
  showConfirmButton: false,
  timer: 1500
})
                }

                this.$Progress.finish();
                    Fire.$emit('AfterCreated');
              })
              .catch(()=>{
                this.$Progress.fail();
              });
            },
            editModal(user){
                this.form.reset();
                $('#addNew').modal('show')
                this.form.fill(user);
            },
            updateUser(){
                  this.$Progress.start();
                this.form.put('/api/user/'+this.form.id)
              .then(()=>{
                $('#addNew').modal('hide');
                swal.fire(
                                        'Done!',
                                        'The user has been updated.',
                                        'success'
                                        )
                this.$Progress.finish();
                    Fire.$emit('AfterCreated');
              })
              .catch(()=>{
                this.$Progress.fail();
              });
            },

            loadUsers(){
                    axios.get("/api/user").then(({ data }) => (this.users = data));
            },
            deleteUser(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.form.delete('/api/user/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'The user has been deleted.',
                                        'success'
                                        );//this : give us warning
                                        Fire.$emit('AfterCreated');
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            }},

        created() {
            Fire.$on('searching',()=>{
                let query=this.$parent.search;
                axios.get('api/findUser?q='+query)
                .then((data)=>{
                    this.users=data.data
                })
                .catch(()=>{

                })
            })
            this.loadUsers();
            Fire.$on('AfterCreated',()=>{this.loadUsers();});
}
    }
</script>


