<template>
<div class="showresult">
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
      <li class="list-group-item wh-color sea-tone">
        ใบเสร็จค่าห้อง
      </li>
      <li class="list-group-item">
        ห้อง {{bill.room_number}} | {{bill.name_title}} {{bill.fullname}}
      </li>
      <li class="list-group-item">
        <div class="row">
          <div class="col-md-6" style="text-align:-webkit-center;padding-top:3%;">
            <div class="card" style="width: 50%;border:none;">
              <img :src="showimg" class="w-100">
            </div>
          </div>
          <div class="col-md-6">
            <div class="top-space">
              <li class="list-group-item wh-color jungle-tone">ค่าห้อง และอื่นๆ</li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ค่าเช่าห้อง
                  </div>
                  <div class="col-md-6">
                    {{bill.room_price}} บาท
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ค่าเคเบิ้ล
                  </div>
                  <div class="col-md-6">
                    {{bill.cable_price}} บาท
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ค่าขยะ
                  </div>
                  <div class="col-md-6">
                    {{bill.trash_price}} บาท
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ค่าที่จอดรถ
                  </div>
                  <div class="col-md-6">
                    {{bill.park_price}} บาท
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ค่าอื่นๆ
                  </div>
                  <div class="col-md-6">
                    {{bill.other_price}} บาท
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    รวมเป็นเงิน
                  </div>
                  <div class="col-md-6">
                    {{bill.res_service_price}} บาท
                  </div>
                </div>
              </li>
            </div>
          </div>
        </div>
        <hr width="100%;">
        <div class="row">
          <div class="col-md-6">
            <div class="top-space">
              <li class="list-group-item wh-color lightning-tone">ค่าไฟฟ้า</li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ยูนิตเดือนนี้
                  </div>
                  <div class="col-md-6">
                    {{bill.elec_unit_now}} หน่วย
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ยูนิตเดือนที่แล้ว
                  </div>
                  <div class="col-md-6">
                    {{bill.elec_unit_lastmonth}} หน่วย
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    จะได้
                  </div>
                  <div class="col-md-6">
                    {{bill.res_elec}} หน่วย
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ยูนิตละ
                  </div>
                  <div class="col-md-6">
                    {{bill.elec_unit}} บาท
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    รวมเป็นเงิน
                  </div>
                  <div class="col-md-6">
                    {{bill.res_elec_price}} บาท
                  </div>
                </div>
              </li>
            </div>
          </div>
          <div class="col-md-6">
            <div class="top-space">
              <li class="list-group-item active">ค่าน้ำ</li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ยูนิตเดือนนี้
                  </div>
                  <div class="col-md-6">
                    {{bill.water_unit_now}} หน่วย
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ยูนิตเดือนที่แล้ว
                  </div>
                  <div class="col-md-6">
                    {{bill.water_unit_lastmonth}} หน่วย
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    จะได้
                  </div>
                  <div class="col-md-6">
                    {{bill.res_water}} หน่วย
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    ยูนิตละ
                  </div>
                  <div class="col-md-6">
                    {{bill.water_unit}} บาท
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    รวมเป็นเงิน
                  </div>
                  <div class="col-md-6">
                    {{bill.res_water_price}} บาท
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-6">
                    <h5 class="font-bold">รวมเป็นเงินทั้งหมด</h5>
                  </div>
                  <div class="col-md-6">
                    <h5 class="font-bold"> {{bill.result_bill}} บาท</h5>
                  </div>
                </div>
              </li>
            </div>
          </div>
        </div>
      </li>
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
import Navbar from '../accessory/Navbar.vue'

export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'showresult',
  data() {
    return {
      bill: this.$route.params.bill,
      showimg: '',
    }
  },
  mounted() {
    this.onStatus();
    this.onLoadData();

    // let day = moment(this.room_data.birthday).format('D');
    // let month = moment(this.room_data.birthday).format('MMMM');
    // let year = moment(this.room_data.birthday).format('YYYY');
    // let BcYear = parseInt(year)
    // let ChYear = BcYear + 543
    //
    // if (month == 'January') {
    //   this.monthTH = 'มกราคม'
    // } else if (month == 'February') {
    //   this.monthTH = 'กุมภาพันธ์'
    // } else if (month == 'March') {
    //   this.monthTH = 'มีนาคม'
    // } else if (month == 'April') {
    //   this.monthTH = 'เมษายน'
    // } else if (month == 'May') {
    //   this.monthTH = 'พฤษภาคม'
    // } else if (month == 'June') {
    //   this.monthTH = 'มิถุนายน'
    // } else if (month == 'July') {
    //   this.monthTH = 'กรกฎาคม'
    // } else if (month == 'August') {
    //   this.monthTH = 'สิงหาคม'
    // } else if (month == 'September') {
    //   this.monthTH = 'กันยายน'
    // } else if (month == 'October') {
    //   this.monthTH = 'ตุลาคม'
    // } else if (month == 'November') {
    //   this.monthTH = 'พฤศจิกายน'
    // } else if (month == 'December') {
    //   this.monthTH = 'ธันวาคม'
    // }
    //
    // this.birthdayInter = day + ' ' + month + ' ' + BcYear
    // this.birthdayTH = day + ' ' + this.monthTH + ' ' + ChYear
    //
    let gender = this.bill.gender;
    if (gender === 'ชาย') {
      this.showimg = 'http://localhost/vue-fire/src/assets/imgs/man.png'
    } else {
      this.showimg = 'http://localhost/vue-fire/src/assets/imgs/woman.png'
    }
  },
  methods: {
    onLoadData() {

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
