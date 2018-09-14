import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/login'
import Register from '@/components/register'
import Testregister from '@/components/testregister'
import Home from '@/components/home'
import Utility from '@/components/utility'
import AddUnit from '@/components/addunit'
import ShowResult from '@/components/showresult'
import BillMaker from '@/components/billmaker'
import Histories from '@/components/histories'
import ShowHistory from '@/components/showhistory'
import Room from '@/components/room'
import AddRoom from '@/components/addroom'
import ViewRoom from '@/components/viewroom'
import UpdateRoom from '@/components/updateroom'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Login',
      component: Login
    },
    {
      path:'/register',
      name: 'Register',
      component: Register
    },
    {
      path:'/testregister',
      name: 'Testregister',
      component: Testregister
    },
    {
      path:'/home',
      name: 'Home',
      component: Home
    },
    {
      path:'/utility',
      name: 'Utility',
      component: Utility
    },
    {
      path:'/addunit',
      name: 'AddUnit',
      component: AddUnit
    },
    {
      path:'/showresult',
      name: 'ShowResult',
      component: ShowResult
    },
    {
      path:'/billmaker',
      name: 'BillMaker',
      component: BillMaker
    },
    {
      path:'/histories',
      name: 'Histories',
      component: Histories
    },
    {
      path:'/showhistory',
      name: 'ShowHistory',
      component: ShowHistory
    },
    {
      path:'/room',
      name: 'Room',
      component: Room
    },
    {
      path:'/addroom',
      name: 'AddRoom',
      component: AddRoom
    },
    {
      path:'/viewroom',
      name: 'ViewRoom',
      component: ViewRoom,
    },
    {
      path:'/updateroom',
      name: 'UpdateRoom',
      component: UpdateRoom,
    },
  ]
})
