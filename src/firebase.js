import {
  initializeApp
} from 'firebase';

const app = initializeApp({
  apiKey: "AIzaSyAtaSI4ZJscdsh_UinPT-XCzoiYsikSD2I",
  authDomain: "billmaker-187a9.firebaseapp.com",
  databaseURL: "https://billmaker-187a9.firebaseio.com",
  projectId: "billmaker-187a9",
  storageBucket: "billmaker-187a9.appspot.com",
  messagingSenderId: "272113820685"
});

export const auth = app.auth();
