<template>
<div class="updateroom">
  <app-navbar></app-navbar>
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">หน้าอัพเดทห้องเช่า | Add Rented Room</p>
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
              <select class="form-control" v-model="room_data.name_title">
            <option value="นาย">นาย</option>
            <option value="นาง">นาง</option>
            <option value="นางสาว">นางสาว</option>
          </select>
            </div>
            <div class="top-sp5">
              <label><i class="fab fa-github"></i> ชื่อ-นามสกุล (Full Name)</label>
              <input type="text" class="form-control" v-model="room_data.fullname" />
            </div>
            <div class="top-sp5">
              <label><i class="fab fa-keybase"></i> ชื่อเล่น (Nickname)</label>
              <input type="text" class="form-control" v-model="room_data.nickname" />
            </div>
            <div class="top-sp5">
              <label><i class="fab fa-yoast"></i> อายุ (Age)</label>
              <input type="number" class="form-control" v-model="room_data.age" />
            </div>
            <div class="top-sp5">
              <label><i class="fas fa-mars"></i> เพศ (Gender)</label>
              <select class="form-control" v-model="room_data.gender" >
            <option value="ชาย">ชาย</option>
            <option value="หญิง">หญิง</option>
          </select>
            </div>
            <div class="top-sp5">
              <label><i class="fas fa-phone"></i> เบอร์โทรศัพท์ (Telephone Number)</label>
              <input type="text" class="form-control" v-model="room_data.phone_number"  />
            </div>
            <div class="top-sp5">
              <label><i class="fas fa-envelope"></i> อีเมลล์ (Email)</label>
              <input type="email" class="form-control" v-model="room_data.email"  />
            </div>
            <div class="top-sp5">
              <label><i class="fas fa-calendar-alt"></i> วันเกิด (Date of Birth)</label>
              <input type="date" class="form-control" v-model="room_data.birthday" />
            </div>
          </div>
          <div class="col-md-6">
            <div>
              <label><i class="fas fa-home"></i> หมายเลขห้อง (Room Number)</label>
              <input type="number" class="form-control" v-model="room_data.room_number" />
            </div>
            <div class="top-sp5">
              <label><i class="fab fa-houzz"></i> ค่าห้อง (Room price)</label>
              <input type="number" class="form-control" v-model="room_data.room_price" />
            </div>
            <div class="top-sp5">
              <label><i class="fab fa-asymmetrik"></i> ค่าเคเบิ้ล (Cable price)</label>
              <input type="number" class="form-control" v-model="room_data.cable_price" />
            </div>
            <div class="top-sp5">
              <label><i class="fas fa-trash"></i> ค่าขยะ (Trash's price)</label>
              <input type="number" class="form-control" v-model="room_data.trash_price"  />
            </div>
          </div>
        </div>
        <div class="top-sp5">
          <input type="hidden" v-model="room_data.id">
          <input type="hidden" v-model="room_data.room_id">
          <input type="hidden" v-model="room_data.host_id">
          <button class="btn btn-primary btn-block btn-lg" @click="onUpdate(room_data)">
            <i class="fas fa-edit"></i>
            อัพเดท
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="container" style="padding-top:5%;">
    <div class="container-fluid" style="text-align:center;">
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
  name: 'updateroom',
  data() {
    return {
      room_data: this.$route.params.room_data,
    }
  },
  mounted() {
    this.onStatus();
  },
  methods: {
    onUpdate(updateform) {
      if (confirm('ต้องการอัพเดทห้องหมายเลข ' + updateform.room_number + ' ใช่หรือไหม่?') == true) {
        var form = this.toForm(updateform);
        axios.post("http://localhost/vue-fire/src/php/room.php?action=update", form).then(data => {
          if (data.data.error) {
            this.errorMessage = data.data.message;
          } else {
            alert('อัพเดทห้องสำเร็จ!');
            router.push({
              name: 'Room'
            });
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
