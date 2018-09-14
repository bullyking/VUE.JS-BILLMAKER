<template>
<div class="billmaker">
  <app-navbar></app-navbar>
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">ประวัติ | History</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="container-fluid">
      <div class="row justify-content-md-center top-sp2">
        <div class="col-md-12">
          <div class="list-group" v-for="history in histries" v-if="show_host == history.host_id">
            <li class="list-group-item list-group-item-action active">ประวัติ</li>
            <li class="list-group-item list-group-item-action">
              <div class="row">
                <div class="col-md-8">
                  <h1>{{history.unit_date_now}}</h1>
                </div>
                <div class="col-md-2">
                  <button class="btn btn-outline-primary btn-full btn-lg btn-block">ปริ้น</button>
                </div>
                <div class="col-md-2">
                  <button class="btn btn-outline-success btn-full btn-lg btn-block" @click="showHistory(history)">ดูผล</button>
                </div>
              </div>
            </li>
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

import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;

pdfMake.fonts = {
  THSarabunNew: {
    normal: 'THSarabunNew.ttf',
    bold: 'THSarabunNew Bold.ttf',
    bolditalics: 'THSarabunNew-BoldItalic.ttf',
    italics: 'THSarabunNew Italic.ttf'
  },
  Roboto: {
    normal: 'Roboto-Regular.ttf',
    bold: 'Roboto-Medium.ttf',
    italics: 'Roboto-Italic.ttf',
    bolditalics: 'Roboto-MediumItalic.ttf'
  }
}

export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'histories',
  data() {
    return {
      show_host: '',
      histries: [],
    }
  },
  mounted() {
    this.onStatus();
    this.OnLoadHistory();
  },
  methods: {
    OnLoadHistory() {
      axios.get('http://localhost/vue-fire/src/php/room_unit.php?action=history').then(histry => {
        this.histries = histry.data.room_units;
      })
    },
    showHistory(history) {
      router.push({
        name: 'ShowHistory',
        params: {
          history: history
        }
      })
    },
    onStatus() {
      firebase.auth().onAuthStateChanged(auth => {
        this.show_host = auth.uid;
        if (auth == null) {
          alert('คุณเข้าสู่ระบบไม่ถูกต้องโปรดเข้าสู่ระบบไหม่อีกครั้ง')
          router.push({
            name: 'Login'
          })
        }
      });
    },
    onShowResult() {
      router.push({
        name: 'ShowResult',
        params: {

        }
      })
    },
    onPrint() {

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
