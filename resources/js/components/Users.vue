<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminORAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Management</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">Add New <i class="fa fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Regiter At</th>
                    <th>Modify</th>
                  </tr>


                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type | upText}}</td>
                    <td>{{user.created_at | myDate}}</td>
                    <td>
                        <a href="#" class="btn btn-info" @click="editModal(user)"><i class="fa fa-edit"></i></a>
                        <a href="#" class="btn btn-info" @click="deleteUser(user.id)"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="users" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdminORAuthor()">
            <not-found></not-found>
        </div>
            <!-- Modal -->
        <div class="modal fade" id="AddNew" tabindex="-1" role="dialog" aria-labelledby="AddNewLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode" id="AddNewLabel">Add New</h5>
                    <h5 class="modal-title" v-show="editMode" id="AddNewLabel">Update User's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateUser() : createUser()" >
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input v-model="form.name" type="text" name="name" placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input v-model="form.email" type="text" name="email" placeholder="email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Bio</label>
                        <input v-model="form.bio" type="text" name="bio" placeholder="bio"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                        <has-error :form="form" field="bio"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type"  v-model="form.type" class="form-control"  :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">Standard User</option>
                            <option value="author">Author</option>
                        </select>
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input v-model="form.password" type="password" name="password" placeholder="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>

                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                    <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                editMode : false,
                users : {},
                form : new Form({
                    id : '',
                    name : '',
                    email : '',
                    password : '',
                    type : '',
                    bio : '',
                    photo : ''
                })
            }
        },
        methods : {

            loadUsers(){
                if(this.$gate.isAdminORAuthor()) {
                axios.get('api/user').then(({ data }) => (this.users = data));
                }
            },

            createUser() {
                this.$Progress.start();
                
                this.form.post('api/user')
                .then(() => {
                    Fire.$emit('AfterCreate');
                $('#AddNew').modal('hide');

                Toast.fire({
                    type: 'success',
                    title: 'User created in successfully'
                     
                });
                this.$Progress.finish()
                })
                .catch(() => {
            this.$Progress.fail();
                })
                
            },
            updateUser() {
                this.$Progress.start();
                this.form.put('api/user/' + this.form.id)
                .then(() => {
                    //success
                    $('#AddNew').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'User update in successfully'
                    });
                    Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                })
                .catch(() => {

                    //fail
                    this.$Progress.fail();
                });
                 
            },
            deleteUser(id) {
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                      if (result.value) {
                    // Send request Delete
                    this.form.delete('api/user/'+ id).then(() => {
                      
                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                
                    Fire.$emit('AfterCreate');
                    }).catch(() => {
                            Swal.fire('Failed!', 'There was something wronge.', 'warning' )
                    });
                      };
                });

          
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#AddNew').modal('show');
            },
            editModal(user) {
                this.editMode = true;
                this.form.reset();
                $('#AddNew').modal('show');
                this.form.fill(user);
            },
            getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.users = response.data;
				});
		    }
        },
        created() {
             Fire.$on('searching',() => {
                let query = this.$parent.search;
                 axios.get('api/findUser?q=' + query)
                .then( (data)=> {
                    this.users = data.data;
                }).catch (() => {

                })
            });
            this.loadUsers();
            Fire.$on('AfterCreate',() => {
                this.loadUsers();
            });
           // setInterval(this.loadUsers,3000);
        }
    }
</script>
