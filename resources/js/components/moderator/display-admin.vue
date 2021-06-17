
<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{this.$parent.lg=='en'? 'Display admins' :'Afficher les Admins'}}</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">{{this.$parent.lg=='en'? 'Add new admin' :'Ajouter un Admin'}}<i class="fas fa-user-plus fa-fw"></i></button>
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
                      <th>{{this.$parent.lg=='en'? 'Creation date' :'Date de creation'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Last update date' :'Date de dernière modification'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Edit & delete' :'Modifier & supprimer'}}</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="admin in admins.data" :key="admin.id">
                        <td>{{admin.id}}</td>
                        <td>{{admin.name}}</td>
                        <td>{{admin.email}}</td>
                        <td>{{admin.created_at |myDate}}</td>
                        <td>{{admin.updated_at|myDate}}</td>
                      <td><a href="#" @click="editModal(admin)"><i class="fa fa-edit"></i></a> / <a href="#" @click="deleteAdmin(admin.id)"><i class="fa fa-trash red"></i></a></td>
                    </tr>

                  </tbody>
                </table>
                <div class="card-footer">
                  <pagination style="margin-bottom: 0px;"
 :data="admins" @pagination-change-page="getResults"></pagination>
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
        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Add new admin' :'Ajouter un nouvel admin'}}</h5>
        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Update admin\'s information' :'Modifier les informations d\'admin'}}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateAdmin() : createAdmin()" >
      <div class="modal-body">

                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                            placeholder="Email Address"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.password" type="password" name="password"
                            placeholder="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{this.$parent.lg=='en'? 'Close' :'Fermer'}}</button>
        <button  v-show="!editmode" type="submit" class="btn btn-primary">{{this.$parent.lg=='en'? 'Create' :'Créer'}}</button>
        <button v-show="editmode" type="submit" class="btn btn-success">{{this.$parent.lg=='en'? 'Update' :'Modifier'}}</button>

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
                admins:{},
                form:new Form({
                  id:'',
                    name:'',
                    email:'',
                    password:'',
                })
            }
        },
        methods:{
            getResults(page = 1) {
                        axios.get('api/moderator?page=' + page)
                            .then(response => {
                                this.admins = response.data;
                            });
                },
            updateAdmin(){
                this.$Progress.start();
                this.form.put('/api/moderator/'+this.form.id)
              .then(()=>{
                $('#addNew').modal('hide')
                swal.fire(
                                        'Done!',
                                        'Your file has been updated.',
                                        'success'
                                        )
                this.$Progress.finish();
                    Fire.$emit('AfterCreated');
              })
              .catch(()=>{
                this.$Progress.fail();
                    swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something wrong',
  })
              });
            },
            editModal(admin){
              this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show')
                this.form.fill(admin);
            },
            newModal(){
              this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            loadAdmins(){
                    axios.get("/api/moderator").then(({ data }) => (this.admins = data));
            },
            createAdmin(){
                this.$Progress.start();
                this.form.post('/api/moderator')
                .then(()=>{
                    Fire.$emit('AfterCreated');
                $('#addNew').modal('hide')
               swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Admin added',
                        showConfirmButton: false,
                        timer: 1500
                        })
                this.$Progress.finish();
                Fire.$emit('AfterCreated');
                })
                .catch(()=>{
                    this.$Progress.fail();
                        swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something wrong',
  })
                })
            },
            deleteAdmin(id){
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
                                this.form.delete('/api/moderator/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'The admin has been deleted.',
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
                axios.get('api/findAdmin?q='+query)
                .then((data)=>{
                    this.admins=data.data
                })
                .catch(()=>{

                })
            })
            this.loadAdmins();
            Fire.$on('AfterCreated',()=>{this.loadAdmins();});
            //setInterval(()=>this.loadAdmins(),3000);
}
    }
</script>
