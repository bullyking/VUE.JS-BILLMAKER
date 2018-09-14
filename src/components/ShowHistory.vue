<template>
<div class="showhistory">
  <app-navbar></app-navbar>
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">หน้าดูประวัติห้องเช่า | View History</p>
      </div>
    </div>
  </div>
  <div class="container top-sp2">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3" v-for="bill in bill_history" v-if="history.host_id == bill.host_id">
          <div class="card border-info mb-3" style="max-width: 18rem;">
            <div class="card-header bg-transparent border-info"><h3 class="card-title font-bold" style="color:#17a2b8;">ห้อง {{bill.room_number}}</h3></div>
            <div class="card-body text-info">
              <p class="card-text font-bold">ค่าใช้สอย: {{bill.res_service_price}} บาท</p>
              <p class="card-text font-bold">ค่าไฟฟ้า: {{bill.res_elec_price}} บาท</p>
              <p class="card-text font-bold">ค่าน้ำ: {{bill.res_water_price}} บาท</p>
              <p class="card-text font-bold">รวม: {{bill.result_bill}} บาท</p>
              <p class="card-text font-bold"><small class="text-muted">วัน/เวลา {{bill.unit_date}} - {{bill.unit_time}}</small></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import firebase from 'firebase'
import moment from 'moment'
import axios from 'axios';
import router from '../router'
import Navbar from '../accessory/Navbar.vue'

export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'showresult',
  data() {
    return {
      history: this.$route.params.history,
      bill_history: [],
    }
  },
  mounted() {
    this.onStatus();
    this.onLoadData();
  },
  methods: {
    onLoadData() {
      axios.get('http://localhost/vue-fire/src/php/room_unit.php?action=read').then(histry => {
        this.bill_history = histry.data.room_units;
      });
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
