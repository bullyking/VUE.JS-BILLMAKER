<template>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <h3 style="color:#fff;padding-top:5px;">BiLL Maker</h3>
  <ul class="nav">
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle wh-color" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">ค่าน้ำ/ค่าไฟ</a>
    <div class="dropdown-menu dropdown-theme">
      <router-link class="wh-color" style="text-decoration:none;" to="/utility">เพิ่มยูนิต ค่าน้ำ/ค่าไฟ</router-link>
      <div class="dropdown-divider"></div>
      <router-link class="wh-color" style="text-decoration:none;" to="/billmaker">ทำใบเสร็จค่าห้อง</router-link>
    </div>
  </li>
    <li class="nav-item nav-pad" style="padding-top:1.5%;">
      <router-link class="wh-color" style="text-decoration:none;" to="/histories">ประวัติ</router-link>
    </li>
    <li class="nav-item nav-pad" style="padding-top:1.5%;">
      <router-link class="wh-color" style="text-decoration:none;" to="/room">ห้องเช่า</router-link>
    </li>
    <li class="nav-item nav-pad" style="padding-top:1.5%;">
      <a class="wh-color" style="text-decoration:none;cursor:pointer" @click="onLogout()">ออกจากระบบ</a>
    </li>
  </ul>
</nav>
</template>

<script>
import firebase from 'firebase'
import router from '../router'

export default {
  name: 'Navbar',
  data() {
    return {

    }
  },
  methods: {
    onLogout() {
      if (confirm('ยันยันการออกจากระบบ?') == true) {
        firebase.auth().signOut().then(auth => {
          router.push({
            name: 'Login'
          });
        }).catch(error => {
          console.log('err', error)
        });
      }
    }
  }
}
</script>

<style>
.nav-pad {
  padding: 0 2rem;
}
</style>
