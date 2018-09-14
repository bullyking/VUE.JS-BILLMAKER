<template>
<div id="testregister">
  <!-- {{msgsuccess}}
  {{users}} -->
  <div>
    Username
    <input type="text" v-model="newUser.username" />
  </div>
  <div>
    Name
    <input type="text" v-model="newUser.name" />
  </div>
  <div>
    email
    <input type="text" v-model="newUser.email" />
  </div>
  <div>
    <button class="btn btn-primary" @click="insertUser()">insertUser</button>
  </div>
  <div v-for="updateUser in users">
    <input type="text" v-model="updateUser.id" />
    <input type="text" v-model="updateUser.username" />
    <input type="text" v-model="updateUser.name" />
    <input type="text" v-model="updateUser.email" />
    <button class="btn btn-success" @click="update(updateUser)">Update</button>
    <button class="btn btn-danger" @click="deleteUser(updateUser)">Delete</button>
  </div>
  <div v-for="user in users">
    {{user.id}} {{user.username}} {{user.name}} {{user.email}}
  </div>
</div>
</template>

<script>
import firebase from 'firebase';
import axios from 'axios';

export default {
  name: 'testregister',
  data() {
    return {
      errorMessage: '',
      msgsuccess: '',
      newUser: {
        username: "",
        name: "",
        email: ""
      },
      users: [],
      updateUser: []
    }
  },
  mounted() {
    this.msgsuccess = 'Good'
    this.getUser();
  },
  methods: {
    getdata() {
      this.msgsuccess = 'click done'
    },
    getUser() {
      axios.get("http://localhost/b-maker/src/php/api.php?action=read").then(data => {
        this.users = data.data.users;
      })
    },
    insertUser() {
      var form = this.toForm(this.newUser);
      axios.post("http://localhost/b-maker/src/php/api.php?action=create", form).then(data => {
        this.newUser = {
          username: "",
          name: "",
          email: ""
        };

        if (data.data.error) {
          this.errorMessage = data.data.message;
        } else {
          this.getUser();
        }
      });
    },
    update(updateUser) {
      console.log('updateUser', updateUser)
      var form = this.toForm(updateUser);
      axios.post("http://localhost/b-maker/src/php/api.php?action=update", form).then(data => {
        if (data.data.error) {
          this.errorMessage = data.data.message;
        } else {
          this.getUser();
        }
      });
    },
    deleteUser(user){
      var form = this.toForm(user);
      axios.post("http://localhost/b-maker/src/php/api.php?action=delete", form).then(data => {
        if (data.data.error) {
          this.errorMessage = data.data.message;
        } else {
          this.getUser();
        }
      });
    },
    toForm(obj) {
      var form = new FormData();
      for(var key in obj) {
        form.append(key, obj[key]);
      }
      return form;
    },
  }
}
</script>

<style>

</style>
