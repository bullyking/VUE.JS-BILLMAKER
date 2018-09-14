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
  <div class="row justify-content-md-center top-sp2">
    <button type="button" class="btn btn-outline-info btn-lg btn-full" data-toggle="modal" data-target="#showUnit">ยูนิตค่าน้ำ | ค่าไฟ ห้องเช่า</button>
    <!-- Modal Component -->
    <div class="modal" tabindex="-1" role="dialog" id="showUnit">
      <div class="modal-dialog" role="document">
        <div class="modal-content" v-for="unit in loadunits" v-if="unit.host_id == show_host">
          <div class="modal-header">
            <h5 class="modal-title">ยูนิตค่าน้ำ | ค่าไฟ ห้องเช่า</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="row t-align-c">
                <div class="col-md-6">
                  <label for="recipient-name" class="col-form-label" style="color:#eb4d4b;">ค่าไฟ {{unit.elec_unit}} บาท / ยูนิต</label>
                </div>
                <div class="col-md-6">
                  <label for="recipient-name" class="col-form-label" style="color:#1289A7;">ค่าน้ำ {{unit.water_unit}} บาท / ยูนิต</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <p class="small font-bold" style="color:#4834d4;">แก้ไขล่าสุด: {{unit.date_unit}} - {{unit.time_unit}}</p>
            </div>
            <hr width="100%;" />
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">ราคาค่าไฟ / ยูนิต:</label>
              <input type="number" class="form-control" v-model="unit.elec_unit">
              </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">ราคาค่าน้ำ / ยูนิต:</label>
              <input type="number" class="form-control" v-model="unit.water_unit">
              </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" v-model="unit.host_id" value="">
            <input type="hidden" v-model="unit.date_id" value="">
            <input type="hidden" v-model="unit.time_id" value="">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="onSetUnit(unit)">บันทึก</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="container-fluid t-align-c">
      <div class="row justify-content-md-center top-sp2">
        <div class="col-md-4 top-sp2" v-for="unit in units" v-if="unit.host_id == show_host">
          <div class="card-deck">
            <div class="card ut-card-bd">
              <i class="ut-card-theme"> {{unit.room_number}}</i>
              <div class="card-body">
                <h5 class="card-title">{{unit.nickname}}</h5>
                <h5 class="card-title">{{unit.name_title}} {{unit.fullname}}</h5>
              </div>
              <div class="card-footer ut-card-ft">
                <div class="row">
                  <button class="btn btn-full btn-lg btn-block ut-bt"@click="onUnit(unit)">
                      เพิ่มยูนิต
                    </button>
                </div>
              </div>
            </div>
            <hr class="ut-hr" width="100%;" />
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
</div>
</template>


<script>
import firebase from 'firebase';
import axios from 'axios';
import moment from 'moment'
import router from '../router'
import Navbar from '../accessory/Navbar.vue'

export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'utility',
  data() {
    return {
      units: [],
      show_host: '',
      loadunits: [],
    }
  },
  mounted() {
    this.onStatus();
    this.loadRooms();
    this.onLoadUnit();
  },
  methods: {
    loadRooms() {
      axios.get("http://localhost/vue-fire/src/php/room.php?action=read").then(data => {
        this.units = data.data.rooms;
        firebase.auth().onAuthStateChanged(auth => {
          if (auth) {
            this.show_host = firebase.auth().currentUser.uid;
          } else {}
        });
      });
    },
    onLoadUnit() {
      axios.get("http://localhost/vue-fire/src/php/unit.php?action=read").then(unit => {
        this.loadunits = unit.data.loadunits;
        firebase.auth().onAuthStateChanged(auth => {
          if (auth) {} else {

          }
        });
      });
    },
    onSetUnit(unit) {
      let date = moment().format('DD/MM/YYYY');
      let time = moment().format('hh:mm a');
      firebase.auth().onAuthStateChanged(auth => {
        if (auth) {
          unit.elec_unit = unit.elec_unit ? parseFloat(unit.elec_unit) : 0;
          unit.water_unit = unit.water_unit ? parseFloat(unit.water_unit) : 0;
          unit.date_unit = date;
          unit.time_unit = time;

          var form = this.toForm(unit);
          axios.post("http://localhost/vue-fire/src/php/unit.php?action=update", form).then(data => {})
        } else {}
      });
    },
    onUnit(unit) {
      router.push({
        name: 'AddUnit',
        params: {
          unit: unit
        }
      })
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
