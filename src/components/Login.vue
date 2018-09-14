<template>
<div class="login">
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron jb-img">
        <h1 class="display-4">ระบบดูแลห้องเช่า</h1>
        <p class="lead">หน้าเข้าสู่ระบบ | Login</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="container-fluid">
      <div class="row justify-content-md-center">
        <div class="t-align-c">
          <h1 class="gray-color">เข้าสู่ระบบ</h1>
          <div class="alert alert-light" role="alert" style="color:#28a745;">{{showSuccess}}{{showError}}</div>
        </div>
      </div>
      <div class="row justify-content-md-center">
        <div class="col-md-4">
          <span style="color:#28a745;">{{loginSuccess}}{{loginError}}</span>
          <input type="email" class="form-control" placeholder="อีเมลล์ผู้ใช้" v-model="email" :change="onCheck()" />

        </div>
      </div>
      <div class="row justify-content-md-center top-sp2">
        <div class="col-md-4">
          <input type="password" class="form-control" placeholder="รหัสผ่าน" v-model="pass" />

        </div>
      </div>
      <div class="row justify-content-md-center top-sp2">
        <div class="col-md-2">
          <button type="submit" class="btn btn-outline-primary btn-block" @click="onLogin()">เข้าสู่ระบบ</button>
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#exampleModal">ลืมรหัสผ่าน</button>
          <!-- Modal Component -->
          <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">กรอกอีเมลล์เพื่อรีเซ็ตรหัสผ่าน</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div>
                    <div class="alert alert-primary" role="alert">{{msgsuccess}}{{msgfail}}</div>
                  </div>
                  <input type="email" class="form-control" placeholder="อีเมลล์ (Email)" v-model="rsemail" :change="onChange()" />

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" data-dismiss="modal" @click="onReset()">Save changes</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-md-center top-sp2">
        <div class="col-md-4">
          <button class="btn btn-outline-success btn-block" @click="toRegisterPage()">
            <!-- <router-link to="/register">สมัครสมาชิก</router-link> -->
            สมัครสมาชิก
          </button>
        </div>
      </div>
      <div class="row justify-content-md-center top-sp2">
        <div class="col-md-4">
          <a class="btn btn-outline-success btn-block">
            <router-link to="/testregister">ทดลองสมัคร</router-link>
          </a>
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
import firebase from 'firebase';
import router from '../router'

export default {
  name: 'home',
  data() {
    return {
      email: '',
      pass: '',
      rsemail: '',
      loginSuccess: '',
      loginError: '',
      showSuccess: '',
      showError: '',
      msgsuccess: '',
      msgfail: '',
    }
  },
  mounted() {
    firebase.auth().onAuthStateChanged(auth => {
      if (auth) {
        router.push({
          name: 'Home'
        });
      } else {
        console.log('not logged in')
      }
    });

    if (this.email === '') {
      // console.log('got it')
      this.loginError = ''
      this.loginSuccess = ''
    }

    if (this.rsemail == '') {
      this.msgsuccess = ''
      this.msgfail = ''
    }

  },
  methods: {
    onLogin() {
      var email = this.email;
      var password = this.pass;
      firebase.auth().signInWithEmailAndPassword(email, password).then(auth => {
        let signIn = auth.operationType;
        if (signIn == 'signIn') {
          router.push({
            name: 'Home'
          });
        }
      }).catch(err => {
        console.log('err', err)
      })
    },
    onReset() {
      firebase.auth().sendPasswordResetEmail(this.rsemail).then(data => {
        this.showSuccess = 'ระบบทำการส่งข้อความไปที่อีเมลล์ ' + this.rsemail + ' เรียบร้อยแล้ว!';
        this.showError = '';
      }).catch(err => {
        this.showError = 'การรีเซ็ตรหัสผ่านมีปัญหา โปรดลองไหม่อีกครั้ง!';
        this.showSuccess = '';
      })
    },
    onCheck() {
      var emailFilter = /^.+@.+\..{2,3}$/;
      if (!emailFilter.test(this.email)) {
        this.loginError = 'อีเมลล์ไม่ถูกต้อง!'
        this.loginSuccess = ''
      } else {
        this.loginSuccess = 'อีเมลล์ถูกต้อง!'
        this.loginError = ''
      }
    },
    onChange() {
      var emailFilter = /^.+@.+\..{2,3}$/;

      if (!emailFilter.test(this.rsemail)) {
        this.msgfail = 'อีเมลล์ไม่ถูกต้อง!'
        this.msgsuccess = ''
      } else {
        this.msgsuccess = 'อีเมลล์ถูกต้อง!'
        this.msgfail = ''
      }
    },
    toRegisterPage() {
      router.push({
        name: 'Register'
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
