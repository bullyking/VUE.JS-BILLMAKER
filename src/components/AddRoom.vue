
<template>
<div class="login">
  <app-navbar></app-navbar>
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">หน้าเพิ่มห้องเช่า | Add Rented Room</p>
      </div>
    </div>
  </div>
  <div class="container top-sp5">
    <div class="container-fluid">
      <div class="top-sp5" style="border:2px solid #007bff;padding:25px;">
        <ul class="list-group">
          <li class="list-group-item active"><i class="fas fa-file-alt"></i> หน้าเพิ่มห้องเช่า</li>
        </ul>
        <div class="row top-sp5">
          <div class="col-md-6">
            <div>
              <label><i class="fas fa-file-code"></i> คำนำหน้า (Title Name)</label><br />
              <select v-model="newRoom.name_title" class="form-control">
            <option value="นาย">นาย</option>
            <option value="นาง">นาง</option>
            <option value="นางสาว">นางสาว</option>
          </select>
            </div>
            <div class="top-sp5">
              <label><i class="fab fa-github"></i> ชื่อ-นามสกุล (Full Name)</label>
              <input type="text" class="form-control" v-model="newRoom.fullname" />

            </div>
            <div class="top-sp5">
              <label><i class="fab fa-keybase"></i> ชื่อเล่น (Nickname)</label>
              <input type="text" class="form-control" v-model="newRoom.nickname" />

            </div>
            <div class="top-sp5">
              <label><i class="fab fa-yoast"></i> อายุ (Age)</label>
              <input type="number" class="form-control" v-model="newRoom.age" />

            </div>
            <div class="top-sp5">
              <label><i class="fas fa-mars"></i> เพศ (Gender)</label>
              <select class="form-control" v-model="newRoom.gender">
            <option value="ชาย">ชาย</option>
            <option value="หญิง">หญิง</option>
          </select>
            </div>
            <div class="top-sp5">
              <label><i class="fas fa-phone"></i> เบอร์โทรศัพท์ (Telephone Number)</label>
              <input type="text" class="form-control" v-model="newRoom.phone_number" />

            </div>
            <div class="top-sp5">
              <label><i class="fas fa-envelope"></i> อีเมลล์ (Email)</label>
              <input type="email" class="form-control" v-model="newRoom.email" />

            </div>
            <div class="top-sp5">
              <label><i class="fas fa-calendar-alt"></i> วันเกิด (Date of Birth)</label>
              <input type="date" class="form-control" v-model="newRoom.birthday" />

            </div>
          </div>
          <div class="col-md-6">
            <div>
              <label><i class="fas fa-home"></i> หมายเลขห้อง (Room Number)</label>
              <input type="number" class="form-control" v-model="newRoom.room_number" />

            </div>
            <div class="top-sp5">
              <label><i class="fab fa-houzz"></i> ค่าห้อง (Room price)</label>
              <input type="number" class="form-control" v-model="newRoom.room_price" />

            </div>
            <div class="top-sp5">
              <label><i class="fab fa-asymmetrik"></i> ค่าเคเบิ้ล (Cable price)</label>
              <input type="number" class="form-control " v-model="newRoom.cable_price" />

            </div>
            <div class="top-sp5">
              <label><i class="fas fa-trash"></i> ค่าขยะ (Trash price)</label>
              <input type="number" class="form-control" v-model="newRoom.trash_price" />

            </div>
            <div class="top-sp5">
              <label><i class="fab fa-asymmetrik"></i> ค่าที่จอดรถ (Park price)</label>
              <input type="number" class="form-control " v-model="newRoom.park_price" />

            </div>
            <div class="top-sp5">
              <label><i class="fas fa-trash"></i> ค่าอื่นๆ (Other price)</label>
              <input type="number" class="form-control" v-model="newRoom.other_price" />

            </div>
          </div>
        </div>
        <div class="top-sp5">
          <input type="hidden" v-model="newRoom.host_id">
          <button class="btn btn-primary btn-block btn-lg" @click="onSave()">
            <i class="fas fa-edit"></i>
            บันทึก
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="container top-sp5">
    <div class="container-fluid t-align-c">
      <div class="row">
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
import firebase from 'firebase'
import router from '../router'
import moment from 'moment'
import Navbar from '../accessory/Navbar.vue'
export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'addroom',
  data() {
    return {
      newRoom: {
        host_id: "",
        name_title: "",
        fullname: "",
        nickname: "",
        age: "",
        gender: "",
        phone_number: "",
        email: "",
        birthday: "",
        room_number: "",
        room_price: "",
        cable_price: "",
        trash_price: "",
      },
      room_unit: [],
    }
  },
  mounted() {
    this.onStatus();
    axios.get("http://localhost/vue-fire/src/php/room.php?action=read").then(data => {
      this.rooms = data.data.rooms;
    })
  },
  methods: {
    onSave() {
      let room_id = moment().format('DDMMYYhhmmss');
      console.log('date',room_id)
      if (confirm('ต้องการเพิ่มห้องหมายเลข ' + this.newRoom.room_number + ' ใช่หรือไหม่?') == true) {
        firebase.auth().onAuthStateChanged(auth => {
          if (auth) {
            this.newRoom.host_id = auth.uid;
            this.newRoom.room_id = room_id;

            var newRoom = this.toForm(this.newRoom);
            axios.post("http://localhost/vue-fire/src/php/room.php?action=create", newRoom).then(data => {

            }).then(data => {
              alert('เพิ่มห้องสำเร็จ!');
            });
            this.room_unit.room_id = room_id;
            this.room_unit.host_id = this.newRoom.host_id;
            this.room_unit.name_title = this.newRoom.name_title;
            this.room_unit.fullname = this.newRoom.fullname;
            this.room_unit.nickname = this.newRoom.nickname;
            this.room_unit.room_number = this.newRoom.room_number;
            this.room_unit.room_price = this.newRoom.room_price;
            this.room_unit.cable_price = this.newRoom.cable_price;
            this.room_unit.trash_price = this.newRoom.trash_price;
            this.room_unit.park_price = this.newRoom.park_price;
            this.room_unit.other_price = this.newRoom.other_price;
            var setRoom = this.toForm(this.room_unit);
            axios.post("http://localhost/vue-fire/src/php/room_unit.php?action=create", setRoom).then(data => {
              router.push({
                name: 'Room'
              });
            })
          } else {
            console.log('not logged in')
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
        if (auth == null) {
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
