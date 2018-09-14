
<template>
  <div class="hello">
    <app-navbar></app-navbar>
  </div>
</template>

<script>
import Navbar from '../accessory/Navbar.vue'
export default {
  components: {
    'app-navbar': Navbar,
  },
  name: 'Home',
  data () {
    return {

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

.jb-img {
  background-image: url(../assets/imgs/woman-nature.jpeg);
  background-position: center;
  background-repeat: no-repeat;
  background-size: 100% auto;
  color: #fff;
}

</style>
