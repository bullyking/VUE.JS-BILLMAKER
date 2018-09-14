<template>
<div class="addunit">
  <div class="row">
    <app-navbar></app-navbar>
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">หน้าเพิ่มยูนิตห้องเช่า | Add Unit Room</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="container-fluid">
      <div class="card-deck">
        <div class="row card-body" v-for="load_unit in load_units" v-if="load_unit.room_id == unit.room_id">
          <div class="col-md-12">
            <ul class="list-group t-align-c" style="font-size:1.3rem;">
              <li class="list-group-item lightcoral wh-color"><h3>ห้อง {{unit.room_number}} | {{unit.name_title}} {{unit.fullname}} - ประวัติ [History] </h3>
              </li>
              <li class="list-group-item">วันที่ | เวลา [ล่าสุด] <br /> {{load_unit.unit_date_now}} | {{load_unit.unit_time}}</li>
              <li class="list-group-item">ยูนิตค่าไฟล่าสุด <br /> {{load_unit.elec_unit_now}} หน่วย</li>
              <li class="list-group-item">ยูนิตค่าน้ำล่าสุด <br /> {{load_unit.water_unit_now}} หน่วย</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card-deck top-sp2">
        <div class="card no-border">
          <div class="row" style="font-size:1.3rem;">
            <div class="col-md-6">
              <ul class="list-group">
                <li class="list-group-item lightcoral wh-color t-align-c">เพิ่มยูนิต [Add Unit]</li>
                <li class="list-group-item">วันที่ปัจจุบัน
                    <input type="date" class="form-control" v-model="room_unit.unit_date_now" :disabled="UDNDisable" />
              </li>
                <li class="list-group-item lightning-font">ยูนิตค่าไฟปัจจุบัน
                  <input type="number" class="form-control" placeholder="ยูนิตค่าไฟปัจจุบัน" v-model="room_unit.elec_unit_now" :disabled="ENDisable" />
                </li>
                <li class="list-group-item lightning-font">ยูนิตค่าไฟเดือนก่อน
                  <input type="number" class="form-control" placeholder="ยูนิตค่าไฟเดือนก่อน" v-model="room_unit.elec_unit_lastmonth" :disabled="ELDisable" />
                </li>
                <li class="list-group-item blue-font">ยูนิตค่าน้ำปัจจุบัน
                  <input type="number" class="form-control" placeholder="ยูนิตค่าน้ำปัจจุบัน" v-model="room_unit.water_unit_now" :disabled="WNDisable" />
                </li>
                <li class="list-group-item blue-font">ยูนิตค่าน้ำเดือนก่อน
                  <input type="number" class="form-control" placeholder="ยูนิตค่าน้ำเดือนก่อน" v-model="room_unit.water_unit_lastmonth" :disabled="WLDisable" />
                </li>
                <li class="list-group-item" v-for="room_unit in main_unit" v-if="room_unit.host_id == unit.host_id">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="hidden" v-model="room_unit.elec_unit">
                      <input type="hidden" v-model="room_unit.water_unit">
                      <button class="btn btn-outline-success btn-lg btn-block" @click="onCal(room_unit)">คำนวณ</button>
                    </div>
                    <div class="col-md-6">
                      <button class="btn btn-outline-danger btn-lg btn-block" @click="onLock()">แก้ไข</button>
                    </div>
                  </div>
                  <div class="row top-sp2">
                    <div class="col-md-12">
                      <button class="btn btn-outline-primary btn-lg btn-block" @click="onSave(room_unit)" :disabled="BTNDisable">บันทึก</button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-group">
                <li class="list-group-item lightcoral wh-color t-align-c">แสดงผล [Show Result]</li>
                <ul class="list-group border">
                  <div class="row">
                    <div class="col-md-6">
                      <li class="list-group-item no-border">ยูนิตไฟ {{res_elec}} หน่วย</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">ยูนิตน้ำ {{res_water}} หน่วย</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">หน่วยละ {{e}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">หน่วยละ {{w}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">เป็นเงิน {{result_elec}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">เป็นเงิน {{result_water}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">ค่าห้อง {{unit.room_price}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">ค่าเคเบิ้ล {{unit.cable_price}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">ค่าขยะ {{unit.trash_price}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">ค่าที่จอดรถ {{unit.park_price}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">ค่าอื่นๆ {{unit.other_price}} บาท</li>
                    </div>
                    <div class="col-md-6">
                      <li class="list-group-item no-border">รวมเป็นเงินทั้งหมด {{this.result_bill}} บาท</li>
                    </div>
                  </div>
                </ul>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
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
import moment from 'moment'
import router from '../router'
import Navbar from '../accessory/Navbar.vue'

export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'addunit',
  data() {
    return {
      unit: this.$route.params.unit,
      main_unit: [],
      room_unit: [],
      load_units: [],
      e: '',
      w: '',
      res_elec: '',
      result_elec: '',
      res_water: '',
      result_water: '',
      res_service_price: '',
      result_bill: '',
      date: '',
      UDNDisable: true,
      ENDisable: true,
      WNDisable: true,
      ELDisable: true,
      WLDisable: true,
      BTNDisable: true,
    }
  },
  mounted() {
    this.onStatus();
    this.onLoadUnit();
    this.room_unit.unit_date_now = moment().format('YYYY-MM-DD');
    this.date = moment().format('DD/MM/YYYY');

    axios.get("http://localhost/vue-fire/src/php/unit.php?action=read").then(unit => {
      this.main_unit = unit.data.loadunits;
    })
  },
  methods: {
    onLock() {
      this.UDNDisable = false;
      this.ENDisable = false;
      this.WNDisable = false;
      this.ELDisable = false;
      this.WLDisable = false;
    },
    onLoadUnit() {
      axios.get("http://localhost/vue-fire/src/php/room_unit.php?action=read").then(data => {
        this.load_units = data.data.room_units;
      });
    },
    onCal(room_unit) {
      let enow = this.room_unit.elec_unit_now;
      let elast = this.room_unit.elec_unit_lastmonth;
      let wnow = this.room_unit.water_unit_now;
      let wlast = this.room_unit.water_unit_lastmonth;
      let room_price = this.unit.room_price ? parseFloat(this.unit.room_price) : 0;
      let cable_price = this.unit.cable_price ? parseFloat(this.unit.cable_price) : 0;
      let trash_price = this.unit.trash_price ? parseFloat(this.unit.trash_price) : 0;
      let park_price = this.unit.park_price ? parseFloat(this.unit.park_price) : 0;
      let other_price = this.unit.trash_price ? parseFloat(this.unit.other_price) : 0;
      this.e = room_unit.elec_unit;
      this.w = room_unit.water_unit;

      this.res_elec = enow - elast;
      this.res_water = wnow - wlast;
      this.result_elec = this.res_elec * this.e;
      this.result_water = this.res_water * this.w;
      this.res_service_price = room_price + cable_price + trash_price + park_price + other_price;
      this.result_bill = this.result_elec + this.result_water + room_price + cable_price + trash_price + park_price + other_price;
      this.BTNDisable = false;
    },
    onSave(room_unit) {
      axios.get("http://localhost/vue-fire/src/php/unit.php?action=read").then(unit => {
        this.main_unit = unit.data.loadunits;
        let unit_date_now = this.room_unit.unit_date_now;
        let fixdate = this.room_unit.unit_date_now;
        console.log('unit_date_now', unit_date_now)
        let elec_unit_now = this.room_unit.elec_unit_now;
        let water_unit_now = this.room_unit.water_unit_now;

        if ((unit_date_now == '') || (elec_unit_now == 0) || (water_unit_now == 0)) {
          alert('โปรดกรอกข้อมูลให้ครบ!')
        } else {
          //Set Form
          this.room_unit.room_id = this.unit.room_id;
          this.room_unit.host_id = this.unit.host_id;
          this.room_unit.name_title = this.unit.name_title;
          this.room_unit.fullname = this.unit.fullname;
          this.room_unit.nickname = this.unit.nickname;
          this.room_unit.room_number = this.unit.room_number;
          this.room_unit.room_price = this.unit.room_price ? parseFloat(this.unit.room_price) : 0;
          this.room_unit.cable_price = this.unit.cable_price ? parseFloat(this.unit.cable_price) : 0;
          this.room_unit.trash_price = this.unit.trash_price ? parseFloat(this.unit.trash_price) : 0;
          this.room_unit.park_price = this.unit.park_price ? parseFloat(this.unit.park_price) : 0;
          this.room_unit.other_price = this.unit.other_price ? parseFloat(this.unit.other_price) : 0;
          this.room_unit.elec_unit = this.e
          this.room_unit.water_unit = this.w
          this.room_unit.unit_date_now = this.room_unit.unit_date_now;
          this.room_unit.elec_unit_now = this.room_unit.elec_unit_now;
          this.room_unit.elec_unit_lastmonth = this.room_unit.elec_unit_lastmonth;
          this.room_unit.water_unit_now = this.room_unit.water_unit_now;
          this.room_unit.water_unit_lastmonth = this.room_unit.water_unit_lastmonth;
          this.room_unit.res_elec = this.res_elec;
          this.room_unit.res_water = this.res_water;
          this.room_unit.res_elec_price = this.result_elec;
          this.room_unit.res_water_price = this.result_water;
          this.room_unit.res_service_price = this.res_service_price;
          this.room_unit.result_bill = this.result_bill;
          this.room_unit.unit_date = moment().format('DD/MM/YYYY');
          this.room_unit.unit_time = moment().format('hh:mm a');
          //Save Form
          if (confirm('ยืนยันการคำนวณ?') == true) {
            var setUnit = this.toForm(this.room_unit);
            axios.post("http://localhost/vue-fire/src/php/room_unit.php?action=update", setUnit)
              .then(data => {
                alert('บันทึกสำเร็จ!')
                router.push({
                  name: 'Utility'
                })
              }).catch(err => {
                console.log('er', err)
              })
          }
        }
      });
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
