
<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{this.$parent.lg=='en'? 'Display workers' :'Afficher les ouvriers'}}</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">{{this.$parent.lg=='en'? 'Add new worker' :'Ajouter un ouvrier'}}<i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>{{this.$parent.lg=='en'? 'Name' :'Nom'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Registration number' :'№ de matricule'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Creation date' :'Date de creation'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Last update date' :'Date de dernière modification'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Edit & delete' :'Modifier & supprimer'}}</th>

                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="worker in workers.data" :key="worker.id">
                        <td>{{worker.id}}</td>
                        <td>{{worker.full_name}}</td>
                        <td>{{worker.nb_matricule}}</td>
                        <td>{{worker.created_at |myDate}}</td>
                        <td>{{worker.updated_at|myDate}}</td>
                      <td><a href="#" @click="editModal(worker)"><i class="fa fa-edit"></i></a> / <a href="#" @click="deleteWorker(worker.id)"><i class="fa fa-trash red"></i></a></td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-footer">
                  <pagination style="margin-bottom: 0px;"
 :data="workers" @pagination-change-page="getResults"></pagination>
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
        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Add new worker' :'Ajouter un ouvrier'}}</h5>
        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Update worker\'s information' :'Modifier les informations d\'ouvrier'}}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateWorker() : createWorker()" >
      <div class="modal-body">

                    <div class="form-group">
                        <input v-model="form.full_name" type="text" name="full_name"
                            placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('full_name') }">
                        <has-error :form="form" field="full_name"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="form.nb_matricule" type="text" name="nb_matricule"
                            placeholder="Registration number"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('nb_matricule') }">
                        <has-error :form="form" field="nb_matricule"></has-error>
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
                workers:{},
                form:new Form({
                  id:'',
                    full_name:'',
                    nb_matricule:'',
                })
            }
        },
        methods:{
             getResults(page = 1) {
                        axios.get('api/worker?page=' + page)
                            .then(response => {
                                this.workers = response.data;
                            });
                },
            updateWorker(){
                this.$Progress.start();
                this.form.put('/api/worker/'+this.form.id)
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
              });
            },
            editModal(worker){
              this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show')
                this.form.fill(worker);
            },
            newModal(){
              this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            loadWorkers(){
                    axios.get("/api/worker").then(({ data }) => (this.workers = data));
            },
            createWorker(){
                this.$Progress.start();
                this.form.post('/api/worker')
                .then(()=>{
                    Fire.$emit('AfterCreated');
                $('#addNew').modal('hide')
               swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Worker added',
                        showConfirmButton: false,
                        timer: 1500
                        })
                this.$Progress.finish();
                Fire.$emit('AfterCreated');
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },
            deleteWorker(id){
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
                                this.form.delete('/api/worker/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'The worker has been deleted.',
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
                axios.get('api/findWorker?q=' + query)
                .then((data)=>{
                    this.workers=data.data
                })
                .catch(()=>{

                })
            })
            this.loadWorkers();
            Fire.$on('AfterCreated',()=>{this.loadWorkers();});
}
    }
</script>
