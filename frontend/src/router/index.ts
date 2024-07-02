import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/page/home.vue'
import SurveysListVue from '@/page/SurveysList.vue'
import SurveyDetailVue from '@/page/SurveyDetail.vue'
import AdminIndex from '@/page/admin/AdminIndex.vue'
import AdminCategory from '@/page/admin/AdminCategory.vue'
import LoginPage from '@/page/Login.vue'
import AdminSurvey from '@/page/admin/AdminSurvey.vue'
import AdminCreateSurvey from '@/page/admin/AdminCreateSurvey.vue'
import SurveyParticipate from '@/page/SurveyParticipate.vue'
import RegisterPage from "@/page/Register.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'index',
      component: HomePage,
      meta: {
        title: 'Startseite'
      }
    },
    {
      path: '/admin',
      name: 'admin',
      component: AdminIndex,
      meta: {
        title: 'Umfrageprojekt Administration'
      },
      children: [
        {
          path: 'category',
          name: 'admin-categories',
          component: AdminCategory
        },
        {
          path: 'survey',
          name: 'admin-surveys',
          component: AdminSurvey
        },
        {
          path: 'survey/create',
          name: 'admin-survey-create',
          component: AdminCreateSurvey
        }
      ]
    }, {
      path: '/login',
      name: 'login',
      component: LoginPage,
      meta: {
        title: 'Login'
      }
    }, {
      path: '/register',
      name: 'register',
      component: RegisterPage,
    },{
      // list of all surveys
      path: '/survey',
      name: 'survey-list',
      component: SurveysListVue,
      meta: {
        title: 'Umfragen'
      }
    },
    {
      path: '/survey/:id/detail',
      name: 'survey-detail',
      component: SurveyDetailVue
    },
    {
      path: '/survey/:id/participate',
      name: 'survey-participate',
      component: SurveyParticipate
    }
  ]
})

export default router
