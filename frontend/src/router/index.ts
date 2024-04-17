import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/page/home.vue'
import SurveysListVue from '@/page/SurveysList.vue'
import SurveyDetailVue from '@/page/SurveyDetail.vue'
// import SurveyFillOutVue from '@/page/SurveyFillOut.vue'
import SurveyCreateVue from '@/page/SurveyCreate.vue'
import LoginPage from '@/page/Login.vue'

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
      path: '/login',
      name: 'login',
      component: LoginPage,
      meta: {
        title: 'Login'
      }
    },
    {
      // list of all surveys
      path: '/survey/list',
      name: 'survey-list',
      component: SurveysListVue,
      meta: {
        title: 'Umfragen'
      }
    },
    {
      // detail of a survey (results, questions, etc.)
      path: '/survey/detail/:id',
      name: 'survey-detail',
      component: SurveyDetailVue,
      meta: {
        title: 'Umfrage'
      }
    },
    // {
    //   // fill out a survey
    //   path: '/survey/fill/:id',
    //   name: 'survey-fill',
    //   component: SurveyFillOutVue,
    //   meta: {
    //     title: 'Umfrage ausfüllen'
    //   }
    // },
    {
      // create a new survey
      path: '/survey/create',
      name: 'survey-create',
      component: SurveyCreateVue,
      meta: {
        title: 'Umfrage erstellen'
      }
    }
  ]
})

export default router
