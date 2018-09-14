<template>
<div class="register">
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">หน้าสมัครสมาชิก | Register</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="container-fluid">
      <h2>
          <span style="color:red;">**หลังจากสมัครและเข้าสู่ระบบแล้ว จะมีหน้าให้ทดลองทำบิลค่าห้องให้ด้วย</span>
        </h2>
      <h2 class="bd-line top-sp2">ข้อมูลสำหรับลงชื่อเข้าใช้งาน (Sign-In Info)
          <span style="color:red;">**</span>
        </h2>
      <div class="row top-sp2">
        <div class="col-md-4">
          <span style="color:red;">{{emailIncorrect}}</span>
          <span style="color:green;">{{emailCorrect}}</span>
          <input type="email" class="form-control" v-model="newUser.email" placeholder="อีเมลล์ (Email)" :change="emailChange()" />
        </div>
        <div class="col-md-4">
          <span style="color:red;">รหัสผ่านอย่างน้อย 8 ตัว</span>
          <input type="password" class="form-control" v-model="newUser.password" placeholder="รหัสผ่าน (Password)" minlength="6" />
        </div>
      </div>
      <h2 class="top-sp5 bd-line">ข้อมูลส่วนตัว (Personal Info)
          <span style="color:red;">**</span>
        </h2>
      <div class="row top-sp2">
        <div class="col-md-3">
          <input type="text" class="form-control" v-model="newUser.first_name" placeholder="ชื่อ (First Name)" />
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" v-model="newUser.last_name" placeholder="นามสกุล (Last Name)" />
        </div>
        <div class="col-md-3">
          <input type="number" class="form-control" v-model="newUser.contact_no" placeholder="เบอร์โทรสำหรับติดต่อ (Contact No.) " />
        </div>
      </div>
      <h2 class="top-sp5 bd-line">ข้อมูลที่อยู่ (Address Info)
          <span style="color:red;">**แนะนำให้กรอก เพื่อแสดงที่อยู่ห้องเช่าให้ผู้อื่นเห็นด้วย</span>
        </h2>
      <div class="row top-sp2">
        <div class="col-md-3">
          <textarea type="text" class="form-control" cols="3" rows="3" v-model="newUser.address" placeholder="ที่อยู่ (Address)"></textarea>
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" v-model="newUser.district" placeholder="เขต/อำเภอ (District)" />
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" v-model="newUser.sub_district" placeholder="แขวง/ตำบล (Sub-District)" />
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" v-model="newUser.province" placeholder="จังหวัด (Province)" />
        </div>
        <div class="col-md-2">
          <input type="number" class="form-control" v-model="newUser.postal_code" placeholder="เลขไปรษณีย์ (Postal Code)" />
        </div>
      </div>
      <div class="row justify-content-md-center">
        <div class="alert alert-light" style="color:red" role="alert">
          {{showError}}
        </div>
      </div>
      <div class="row justify-content-md-center top-sp2">
        <input type="hidden" v-model="newUser.UsID" value="">
        <input type="hidden" v-model="newUnit.host_id" value="">
        <input type="hidden" v-model="newUnit.elec_unit" value="">
        <input type="hidden" v-model="newUnit.water_unit" value="">
        <input type="hidden" v-model="newUnit.date_unit" value="">
        <input type="hidden" v-model="newUnit.time_unit" value="">
        <button type="submit" class="btn btn-outline-primary btn-lg" @click="onRegister()">ลงทะเบียน</button>
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
</div>
</template>

<script>
import firebase from 'firebase'
import axios from 'axios'
import moment from 'moment'

export default {
  name: 'register',
  data() {
    return {
      newUser: {
        UsID: "",
        email: "",
        password: "",
        first_name: "",
        last_name: "",
        contact_no: "",
        address: "",
        district: "",
        sub_district: "",
        province: "",
        postal_code: "",
      },
      newUnit: {
        host_id: "",
        elec_unit: "",
        water_unit: "",
        date_unit: "",
        time_unit: ""
      },
      showError: '',
      emailCorrect: '',
      emailIncorrect: '',
    }
  },
  methods: {
    onRegister() {
      if (confirm('ยืนยันการสมัคร?') == true) {
        firebase.auth().createUserWithEmailAndPassword(this.newUser.email, this.newUser.password).then(auth => {
          this.newUser.UsID = auth.user.uid;
          if (auth) {
            var form = this.toForm(this.newUser);
            axios.post("http://localhost/vue-fire/src/php/register.php?action=create", form).then(data => {
              this.newUser = {
                UsID: "",
                email: "",
                password: "",
                first_name: "",
                last_name: "",
                contact_no: "",
                address: "",
                district: "",
                sub_district: "",
                province: "",
                postal_code: "",
              };

              let date = moment().format('DD/MM/YYYY');
              let time = moment().format('hh:mm a');
              let zero = 0;
              this.newUnit.host_id = auth.user.uid;
              this.newUnit.elec_unit = zero ? parseFloat(zero) : 0;
              this.newUnit.water_unit = zero ? parseFloat(zero) : 0;
              this.newUnit.date_unit = date;
              this.newUnit.time_unit = time;
              var unitform = this.toForm(this.newUnit);
              axios.post("http://localhost/vue-fire/src/php/unit.php?action=create", unitform).then(data => {
                this.newUnit = {
                  host_id: "",
                  elec_unit: "",
                  water_unit: "",
                  date_unit: "",
                  time_unit: ""
                };
              });
              alert('สมัครเข้าใช้งานสำเร็จ!')
            });
          }
        }).catch( err => {
          this.showError = 'อีเมลล์หรือรหัสผ่านไม่ถูกต้อง หรือมีผู้ใช้งานอีเมลล์นี้แล้ว ถ้าอีเมลล์นี้เป็นของคุณ คุณสามารถกดลืมรหัสผ่านได้ที่หน้าเข้าสู่ระบบ!'
        })
      }
    },
    onSetUnit() {

    },
    emailChange() {
      var emailFilter = /^.+@.+\..{2,3}$/;
      if (!emailFilter.test(this.newUser.email)) {
        this.emailIncorrect = '✗ อีเมลล์ไม่ถูกต้อง!'
        this.emailCorrect = ''
      } else {
        this.emailCorrect = '✓ อีเมลล์ถูกต้อง!'
        this.emailIncorrect = ''
      }
    },
    toForm(obj) {
      var form = new FormData();
      for (var key in obj) {
        form.append(key, obj[key]);
      }
      return form;
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
