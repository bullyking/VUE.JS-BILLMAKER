<template>
<div class="billmaker">
  <app-navbar></app-navbar>
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">ใบเสร็จค่าห้อง | BILL MAKER</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="container-fluid t-align-c">
      <div class="row justify-content-md-center top-sp2">
        <div class="col-md-4 top-sp2" v-for="bill in bills" v-if="bill.host_id == show_host">
          <div class="card-deck">
            <div class="card bk-card-bd">
              <i class="bk-card-theme"> {{bill.room_number}}</i>
              <div class="row">
                <div class="col-md-6">
                  <button class="btn btn-full btn-lg btn-block bk-bt bk-card-bt" @click="onPrint(bill)">ปริ้น</button>
                </div>
                <div class="col-md-6">
                  <button class="btn btn-full btn-lg btn-block bk-bt bk-card-bt" @click="onShowResult(bill)">ดูผล</button>
                </div>
              </div>
            </div>
            <hr class="bk-hr" width="100%;" />
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
  name: 'billmaker',
  data() {
    return {
      bills: [],
      show_host: '',
      pdfObj1_3: null,
    }
  },
  mounted() {
    this.onStatus();
    this.loadRooms();;
  },
  methods: {
    loadRooms() {
      axios.get("http://localhost/vue-fire/src/php/room_unit.php?action=read").then(data => {
        this.bills = data.data.room_units;
        firebase.auth().onAuthStateChanged(auth => {
          if (auth) {
            this.show_host = firebase.auth().currentUser.uid;
          } else {}
        });
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
    },
    onShowResult(bill) {
      router.push({
        name: 'ShowResult',
        params: {
          bill: bill
        }
      })
    },
    onPrint(bill) {
      var billmaker = {
        content: [
          {
            layout: 'exampleLayout', // optional
            table: {
              // headers are automatically repeated if the table spans over multiple pages
              // you can declare how many rows should be treated as headers
              headerRows: 1,

              widths: ['17%', '13%', '15%', '15%', '18%', '22%'],
              borderLines: [[0, 1, 0, 0, 1, 0], [1, 1, 1, 1, 1, 1], [1, 1, 1, 1, 1, 1]],
              borderCols: [[0, 1, 1, 0, 0, 1, 1, 1], [1, 1, 1, 1, 0, 1, 1, 1]],

              body: [
                //Bill 1
                ['', '', '', '', { text: bill.unit_date_now, style: 'small', margin: [5, 15, 17, 5] }, { text: 'ห้อง ' + bill.room_number, style: 'subright', margin: [5, 15, 17, 5] }],
                ['#', { text: 'ยูนิตเดือนนี้', style: 'middle' }, { text: 'ยูนิตเดือนก่อน', style: 'middle' }, { text: 'หน่วย', style: 'middle' }, { text: 'หน่วยละ', style: 'middle' }, { text: 'จำนวนเงิน (บาท)', style: 'middle' }],
                [{ text: 'ค่าไฟฟ้า', style: 'header' }, { text: bill.elec_unit_now, style: 'middle' }, { text: bill.elec_unit_lastmonth, style: 'middle' }, { text: bill.res_elec, style: 'middle' }, { text: bill.elec_unit, style: 'middle' }, { text: bill.res_elec_price, style: 'middle' }],
                [{ text: 'ค่าน้ำ', style: 'header' }, { text: bill.water_unit_now, style: 'middle' }, { text: bill.water_unit_lastmonth, style: 'middle' }, { text: bill.res_water, style: 'middle' }, { text: bill.water_unit, style: 'middle' }, { text: bill.res_water_price, style: 'middle' }],
                [{ text: 'ค่าเช่า', style: 'header' }, '', '', '', '', { text: bill.room_price, style: 'middle' }],
                [{ text: 'ค่าเคเบิ้ล', style: 'header' }, '', '', '', '', { text: bill.cable_price, style: 'middle' }],
                [{ text: 'ค่าขยะ', style: 'header' }, '', '', '', '', { text: bill.trash_price, style: 'middle' }],
                [{ text: 'ค่าที่จอดรถ', style: 'header' }, '', '', '', '', { text: bill.park_price, style: 'middle' }],
                [{ text: 'ค่าอื่นๆ', style: 'header' }, '', '', '', '', { text: bill.other_price, style: 'middle' }],
                [{ width: 'auto', text: 'ผู้รับ/วันที่', style: 'subheader' }, '', '', '', { text: 'รวมเป็นเงิน', style: 'subright' }, { text: bill.result_bill, style: 'middle' }],
              ],
            }
          }
        ],

        styles: {
          header: {
            font: 'THSarabunNew',
            bold: true,
            fontSize: 16,
          },
          subheader: {
            font: 'THSarabunNew',
            bold: true,
            fontSize: 16,
          },
          subright: {
            font: 'THSarabunNew',
            bold: true,
            fontSize: 16,
            alignment: 'right'
          },
          middle: {
            font: 'THSarabunNew',
            bold: true,
            fontSize: 16,
            alignment: 'center'
          },
          small: {
            font: 'THSarabunNew',
            bold: true,
            fontSize: 16,
            alignment: 'center'
          },
        },
      }

      pdfMake.tableLayouts = {
        exampleLayout: {
          hLineWidth: function(i, node) {
            if (i === 0 || i === node.table.body.length) {
              return 0;
            }
            return (i === node.table.headerRows) ? 2 : 1;
          },
          vLineWidth: function(i) {
            return 0;
          },
          hLineColor: function(i) {
            return i === 1 ? 'black' : '#aaa';
          },
          paddingLeft: function(i) {
            return i === 0 ? 0 : 8;
          },
          paddingRight: function(i, node) {
            return (i === node.table.widths.length - 1) ? 0 : 8;
          }
        }
      };

      this.pdfObj = pdfMake.createPdf(billmaker);
      this.pdfObj1 = pdfMake.createPdf(billmaker);

      if(confirm('ต้องการปริ้นบิลของห้อง ' + bill.room_number + ' ใช่หรือไม่?') == true) {
        // this.pdfObj.download('บิลห้อง ' + bill.room_number + '.pdf');
        // this.pdfObj.print();
        this.pdfObj.open();
      }
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
