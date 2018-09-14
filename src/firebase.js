import {
  initializeApp
} from 'firebase';

const app = initializeApp({
  apiKey: "apiKey",
  authDomain: "authDomain",
  databaseURL: "databaseURL",
  projectId: "projectId",
  storageBucket: "storageBucket",
  messagingSenderId: "messagingSenderId"
});

export const auth = app.auth();
