<template>
<div class="room">
  <app-navbar></app-navbar>
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">หน้าห้องเช่า | Rented Room</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row justify-content-md-center top-sp2">
      <button class="btn btn-outline-success btn-lg btn-full" @click="onAdd()">เพิ่มห้อง</button>
    </div>
    <div class="row justify-content-md-center top-sp2">
      <div class="card-deck col-md-4 top-sp2" v-for="room in rooms" v-if="room.host_id == show_host">
        <div class="card t-align-c dark-bd">
          <div class="card-body">
            <h5 class="card-title">ห้อง {{room.room_number}} | {{room.nickname}}</h5>
            <p class="card-text">{{room.name_title}} {{room.fullname}}</p>
          </div>
          <div class="card-footer" style="background-color:#fff;">
            <div class="row">
              <div class="col-md-4 top-sp2">
                <button class="btn btn-outline-primary btn-sm btn-block" @click="onView(room)">เพิ่มเติม</button>
              </div>
              <div class="col-md-4 top-sp2">
                <button class="btn btn-outline-success btn-sm btn-block" @click="onUpdate(room)">อัพเดท</button>
              </div>
              <div class="col-md-4 top-sp2">
                <button class="btn btn-outline-danger btn-sm btn-block" @click="onDelete(room)">ลบ</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="container">
    <div class="container-fluid t-align-c">
      <div class="row justify-content-md-center top-sp5">
        <div class="col-md-4">
          <label>LAPTOP</label>
        </div>
        <div class="col-md-4">
          <label>ANDROID</label>
        </div>
        <div class="col-md-4">
          <label>IOS</label>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import firebase from 'firebase';
import axios from 'axios';

import router from '../router'
import Navbar from '../accessory/Navbar.vue'

export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'room',
  data() {
    return {
      rooms: [],
      show_host: '',
    }
  },
  mounted() {
    this.onStatus();
    this.loadRooms();
  },
  methods: {
    loadRooms() {
      axios.get("http://localhost/vue-fire/src/php/room.php?action=read").then(data => {
        this.rooms = data.data.rooms;
        firebase.auth().onAuthStateChanged(auth => {
          if (auth) {
            this.show_host = firebase.auth().currentUser.uid;
          } else {
          }
        });
      });
    },
    onAdd() {
      router.push({
        name: 'AddRoom'
      });
    },
    onView(room) {
      router.push({
        name: 'ViewRoom',
        params: {
          room_data: room
        }
      });
    },
    onUpdate(room) {
      router.push({
        name: 'UpdateRoom',
        params: {
          room_data: room
        }
      });
    },
    onDelete(room) {
      console.log(room.room_id)
      if (confirm('ต้องการลบข้อมูลห้อง ' + room.room_number + ' ใช่หรือไม่?') == true) {
        var form = this.toForm(room);
        axios.post("http://localhost/vue-fire/src/php/room_unit.php?action=delete", form).then(data => {
          if (data.data.error) {
          } else {
            if (data.status) {

            }
          }
        });
        axios.post("http://localhost/vue-fire/src/php/room.php?action=delete", form).then(data => {
          if (data.data.error) {
          } else {
            alert('ลบห้องสำเร็จ!')
            if (data.status) {
              router.go({
                name: 'Room'
              });
            }
          }
        });
      }
    },
    toForm(obj) {
      var form = new FormData();
      for (var key in obj) {
        form.append(key, obj[key]);
      }
      return form;
    },
    onStatus() {
      firebase.auth().onAuthStateChanged(auth => {
        if(auth == null) {
        alert('คุณเข้าสู่ระบบไม่ถูกต้องโปรดเข้าสู่ระบบไหม่อีกครั้ง')
        router.push({
          name: 'Login'
        })
        }
      });
    }
  },
}
</script>

<style>
.jb-img {
  background-image: url(../assets/imgs/woman-nature.jpeg);
  background-position: center;
  background-repeat: no-repeat;
  background-size: 100% auto;
  color: #fff;
}
</style>
