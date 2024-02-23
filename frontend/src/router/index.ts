import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/pages/Home.vue'
import SurveysListVue from '@/page/SurveysList.vue'
import SurveyDetailVue from '@/page/SurveyDetail.vue'
import SurveyFillOutVue from '@/page/SurveyFillOut.vue'
import SurveyCreateVue from '@/page/SurveyCreate.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'index',
      component: HomePage
    },
    {
      // list of all surveys
      path: '/survey/list',
      name: 'survey-list',
      component: SurveysListVue
    },
    {
      // detail of a survey (results, questions, etc.)
      path: '/survey/detail/:id',
      name: 'survey-detail',
      component: SurveyDetailVue
    },
    {
      // fill out a survey
      path: '/survey/fill/:id',
      name: 'survey-fill',
      component: SurveyFillOutVue
    },
    {
      // create a new survey
      path: '/survey/create',
      name: 'survey-create',
      component: SurveyCreateVue
    }
  ]
})

export default router
