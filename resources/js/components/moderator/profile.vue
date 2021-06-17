
<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{this.$parent.lg=='en'? 'Update the modarator data' :'Modifier les données de modérateur'}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" @submit.prevent="updateMod()">
                <div class="card-body justify-content-around">
                    <div class="form-group col-sm-5">
                    <label for="exampleInputEmail2">{{this.$parent.lg=='en'? 'Name' :'Le nom'}}</label>
                    <input v-model="form.name" name="name" type="text" class="form-control" id="exampleInputEmail2" placeholder="Enter name">
                  </div>
                  <div class="form-group col-sm-5">
                    <label for="exampleInputEmail3">Email</label>
                    <input v-model="form.email" name="email" type="email" class="form-control" id="exampleInputEmail3" placeholder="Enter email">
                  </div>
                  <div class="form-group col-sm-5">
                    <label for="exampleInputPassword1">{{this.$parent.lg=='en'? 'Password' :'Mot de passe'}}</label>
                    <input v-model="form.password" name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <button type="submit" class="btn btn-primary" >{{this.$parent.lg=='en'? 'Update' :'Confirmer la modification'}}<i class="fas fa-user-edit"></i></button>
                </div>
              </form>
            </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                form:new Form({
                  id:'',
                    name:'',
                    email:'',
                    password:'',
                })
            }
        },
        methods:{
            updateMod(){
                this.$Progress.start();
                this.form.put('/api/profile/'+1)
              .then(()=>{
                $('#addNew').modal('hide')
                swal.fire(
                                        'Done!',
                                        'Your profile has been updated.',
                                        'success'
                                        )
                this.$Progress.finish();
                    Fire.$emit('AfterCreated');
                this.form.reset();

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
        },
    }
</script>
