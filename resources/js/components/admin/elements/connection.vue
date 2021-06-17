<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{this.$parent.lg=='en'? 'Display connections' :'Afficher les connexions'}}</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">{{this.$parent.lg=='en'? 'Add new connection' :'Ajouter une connexion'}}<i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>{{this.$parent.lg=='en'? 'Image ' :'L\'image'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Article' :'Article'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Description' :'La description'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Creation date' :'Date de creation'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Last update date' :'Date de dernière modification'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Edit & delete' :'Modifier & supprimer'}}</th>

                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="pole in poles.data" :key="pole.id">
                        <td>{{pole.id}}</td>
                        <td><img v-bind:src="'/images/connetions/' + pole.image" ></td>
                        <td>{{pole.name}}</td>
                        <td>{{pole.article}}</td>
                        <td>{{pole.description}}</td>
                        <td>{{pole.created_at |myDate}}</td>
                        <td>{{pole.updated_at|myDate}}</td>
                      <td><a href="#" @click="editModal(pole)"><i class="fa fa-edit"></i></a> / <a href="#" @click="deletePole(pole.id)"><i class="fa fa-trash red"></i></a></td>
                    </tr>

                  </tbody>
                </table>
                <div class="card-footer">
                  <pagination style="margin-bottom: 0px;"
 :data="poles" @pagination-change-page="getResults"></pagination>
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
        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Add new connexion' :'Ajouter une connection'}}</h5>
        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Update pole\'s information' :'Modifier les informations du connection'}}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateImage() : createImage()" >
      <div class="modal-body">
                    <div class="form-group" style="margin-bottom:0px">
                    <label for="exampleInputFile">{{this.$parent.lg=='en'? 'File input' :'Entrée le fichier'}}</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input @change="onImageChange" name="image" type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile" >{{form.name}}</label>
                      </div>

                    </div>
                  </div>

                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name" style="height:0px;border:0px;padding:0px"

                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form"  field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.article" type="text" name="article" class="form-control" placeholder="article name">
                    </div>
                    <div class="form-group">
                        <input v-model="form.description" type="text" name="decription" class="form-control" placeholder="description name">
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{this.$parent.lg=='en'? 'Close' :'Fermer'}}</button>
        <button @click.prevent="createImage" v-show="!editmode"  type="submit" class="btn btn-primary">{{this.$parent.lg=='en'? 'Create' :'Créer'}}</button>
        <button v-show="editmode"   type="submit" class="btn btn-success">{{this.$parent.lg=='en'? 'Update' :'Modifier'}}</button>
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
                poles:{},
                form:new Form({
                  id:'',
                    name:'',
                    image:'',
                    article:'',
                    description:'',
                })
            }
        },
        methods:{
            getResults(page = 1) {
                        axios.get('api/pole?page=' + page)
                            .then(response => {
                                this.poles = response.data;

                            });
                },
          onImageChange(e) {
                let file = e.target.files[0] ;
                 var reader = new FileReader();
                 if(file!=null){
                     reader.onloadend = (file) =>{
                    this.form.image = reader.result;
                  }
                   this.form.name = file.name;
                     console.log(reader.readAsDataURL(file)) ;}
            },
          createImage(file) {//updateInfo
          this.$Progress.start();
                this.form.post('/api/pole')
                .then(()=>{
                    $('#addNew').modal('hide')
                swal.fire(
                                        'Done!',
                                        'Your image has been created.',
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
  text: 'Some fields already has been taken',
  })
                });
          },
            updateImage(){
            this.$Progress.start();
                this.form.put('/api/pole/'+this.form.id)
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
  text: 'Some fields already has been taken',
  })
              });
            },
            editModal(pole){
              this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show')
                this.form.fill(pole);
            },
            newModal(){
              this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            loadPoles(){
                    axios.get("/api/pole").then(({ data }) => (this.poles = data));
            },

            deletePole(id){
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
                                this.form.delete('/api/pole/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'The pole has been deleted.',
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
                axios.get('api/findPole?q=' + query)
                .then((data)=>{
                    this.poles=data.data
                })
                .catch(()=>{

                })
            })
            this.loadPoles();
            Fire.$on('AfterCreated',()=>{this.loadPoles();});
}
    }
</script>
