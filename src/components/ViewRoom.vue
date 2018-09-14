<template>
<div class="viewroom">
  <app-navbar></app-navbar>
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">หน้าดูห้องเช่า | View Room</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="container-fluid">
      <div class="row">
        <div class="card" style="width: 100%;border:none;">
          <div class="row">
            <div class="col-md-4">
              <ul class="list-group">
                <li class="list-group-item ship-officer-dark wh-color">ห้อง {{room_data.room_number}}</li>
              </ul>
              <img :src="showimg" class="w-100">
            </div>
            <div class="col-md-4">
              <ul class="list-group">
                <li class="list-group-item turkish-aqua-blue wh-color">ข้อมูลผู้เช่า (Renter's Info)</li>
                <li class="list-group-item">ชื่อ: {{room_data.fullname}}</li>
                <li class="list-group-item">ชื่อเล่น: {{room_data.nickname}}</li>
                <li class="list-group-item">อายุ: {{room_data.age}} ปี</li>
                <li class="list-group-item">เพศ: {{room_data.gender}}</li>
                <li class="list-group-item">เบอร์: {{room_data.phone_number}}</li>
                <li class="list-group-item">อีเมลล์: {{room_data.email}}</li>
                <li class="list-group-item">วันเกิด: {{birthdayTH}} | {{birthdayInter}}</li>
              </ul>
            </div>
            <div class="col-md-4">
              <ul class="list-group">
                <li class="list-group-item magenta-purple wh-color">ข้อมูลห้องเช่า (Room's Info)</li>
                <li class="list-group-item">ค่าห้อง: {{room_data.room_price}} บาท</li>
                <li class="list-group-item">ค่าเคเบิ้ล: {{room_data.cable_price}} บาท</li>
                <li class="list-group-item">ค่าขยะ: {{room_data.trash_price}} บาท</li>
                <li class="list-group-item">ค่าที่จอดรถ: {{room_data.park_price}} บาท</li>
                <li class="list-group-item">ค่าอื่นๆ: {{room_data.other_price}} บาท</li>
              </ul>
            </div>
          </div>
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
import moment from 'moment'
import router from '../router'
import axios from 'axios';
import Navbar from '../accessory/Navbar.vue'

export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'viewroom',
  data() {
    return {
      room_data: this.$route.params.room_data,
      showimg: '',
      monthTH: '',
      birthdayTH: '',
      birthdayInter: '',
    }
  },
  mounted() {
    this.onStatus();
    this.onDatewithAge();
  },
  methods: {
    onDatewithAge() {
      let day = moment(this.room_data.birthday).format('D');
      let month = moment(this.room_data.birthday).format('MMMM');
      let year = moment(this.room_data.birthday).format('YYYY');
      let BcYear = parseInt(year)
      let ChYear = BcYear + 543

      if (month == 'January') {
        this.monthTH = 'มกราคม'
      } else if (month == 'February') {
        this.monthTH = 'กุมภาพันธ์'
      } else if (month == 'March') {
        this.monthTH = 'มีนาคม'
      } else if (month == 'April') {
        this.monthTH = 'เมษายน'
      } else if (month == 'May') {
        this.monthTH = 'พฤษภาคม'
      } else if (month == 'June') {
        this.monthTH = 'มิถุนายน'
      } else if (month == 'July') {
        this.monthTH = 'กรกฎาคม'
      } else if (month == 'August') {
        this.monthTH = 'สิงหาคม'
      } else if (month == 'September') {
        this.monthTH = 'กันยายน'
      } else if (month == 'October') {
        this.monthTH = 'ตุลาคม'
      } else if (month == 'November') {
        this.monthTH = 'พฤศจิกายน'
      } else if (month == 'December') {
        this.monthTH = 'ธันวาคม'
      }

      this.birthdayInter = day + ' ' + month + ' ' + BcYear
      this.birthdayTH = day + ' ' + this.monthTH + ' ' + ChYear

      let monthNum = moment(this.room_data.birthday).format('MM');
      let dayNow = moment().format('DD');
      let monthNow = moment().format('MM');
      let yearNow = moment().format('YYYY');

      let positive = yearNow - BcYear;
      let negative = positive - 1;

      if((dayNow > day) && (monthNow > monthNum)) {
        this.room_data.age = positive;
      } else if ((dayNow > day) && (monthNow < monthNum)) {
        this.room_data.age = negative;
      } else if ((dayNow < day) && (monthNow > monthNum)) {
        this.room_data.age = positive;
      } else if ((dayNow < day) && (monthNow < monthNum)) {
        this.room_data.age = negative;
      } else if ((dayNow == day) && (monthNow == monthNum)) {
        this.room_data.age = positive;
      } else if ((dayNow == day) && (monthNow > monthNum)) {
        this.room_data.age = positive;
      } else if ((dayNow == day) && (monthNow < monthNum)) {
        this.room_data.age = negative;
      } else if ((dayNow > day) && (monthNow == monthNum)) {
        this.room_data.age = positive;
      } else if ((dayNow < day) && (monthNow == monthNum)) {
        this.room_data.age = negative;
      }

      var form = this.toForm(this.room_data);
      axios.post("http://localhost/vue-fire/src/php/room.php?action=update", form).then(data => {});

      let gender = this.$route.params.room_data.gender;
      if (gender === 'ชาย') {
        this.showimg = 'http://localhost/vue-fire/src/assets/imgs/man.png'
      } else {
        this.showimg = 'http://localhost/vue-fire/src/assets/imgs/woman.png'
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
    },
  }
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
