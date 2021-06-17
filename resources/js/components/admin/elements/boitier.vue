<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{this.$parent.lg=='en'? 'Display boitiers' :'Afficher les boitiers'}}</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal" data-toggle="modal" data-target="#addNew">{{this.$parent.lg=='en'? 'Add new boitier' :'Ajouter un boitier'}}<i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>{{this.$parent.lg=='en'? 'Image ' :'L\'image'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Article' :'Article'}} </th>
                      <th>{{this.$parent.lg=='en'? 'Description' :'La description'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Creation date' :'Date de creation'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Last update date' :'Date de dernière modification'}}</th>
                      <th>{{this.$parent.lg=='en'? 'Edit & delete' :'Modifier & supprimer'}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="boitier in boitiers.data" :key="boitier.id">
                        <td>{{boitier.id}}</td>
                        <td><img v-bind:src="'/images/boitiers/' + boitier.image" ></td>
                        <td>{{boitier.article}}</td>
                        <td>{{boitier.description}}</td>
                        <td>{{boitier.name}}</td>
                        <td>{{boitier.created_at |myDate}}</td>
                        <td>{{boitier.updated_at|myDate}}</td>
                      <td><a href="#" @click="editModal(boitier)"><i class="fa fa-edit"></i></a> / <a href="#" @click="deleteBoitier(boitier.id)"><i class="fa fa-trash red"></i></a></td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-footer">
                  <pagination style="margin-bottom: 0px;"
 :data="boitiers" @pagination-change-page="getResults"></pagination>
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
        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Add new boitier' :'Ajouter un boitier'}}</h5>
        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{this.$parent.lg=='en'? 'Update boitier\'s information' :'Modifier les informations du boitier'}}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateImage() : createImage()" >
      <div class="modal-body">
                    <div class="form-group" style="margin-bottom:0px">
                    <label for="exampleInputFile">{{this.$parent.lg=='en'? 'File input' :'Entrer le fichier'}}</label>
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
                boitiers:{},
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
                        axios.get('api/boitier?page=' + page)
                            .then(response => {
                                this.boitiers = response.data;

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
                this.form.post('/api/boitier')
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
                this.form.put('/api/boitier/'+this.form.id)
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
            editModal(boitier){
              this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show')
                this.form.fill(boitier);
            },
            newModal(){
              this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            loadBoitiers(){
                    axios.get("/api/boitier").then(({ data }) => (this.boitiers = data));
            },

            deleteBoitier(id){
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
                                this.form.delete('/api/boitier/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'The boitier has been deleted.',
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
                axios.get('api/findBoitier?q=' + query)
                .then((data)=>{
                    this.boitiers=data.data
                })
                .catch(()=>{

                })
            })
            this.loadBoitiers();
            Fire.$on('AfterCreated',()=>{this.loadBoitiers();});
}
    }
</script>
